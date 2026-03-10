<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\LoginCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class LoginCodeController extends Controller
{
    private const CACHE_PREFIX = 'login_code:';
    private const EXPIRE_MINUTES = 10;

    /**
     * Afficher le formulaire de connexion (étape 1 : email).
     */
    public function create(Request $request)
    {
        $email = $request->session()->get('login_email');
        return view('auth.login', ['step' => $email ? 'code' : 'email', 'email' => $email]);
    }

    /**
     * Envoyer le code à 6 chiffres par email.
     */
    public function sendCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Aucun compte n\'est associé à cette adresse email.',
            ]);
        }

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $key = self::CACHE_PREFIX . $request->email;
        Cache::put($key, $code, now()->addMinutes(self::EXPIRE_MINUTES));

        Mail::to($request->email)->send(new LoginCodeMail($code, self::EXPIRE_MINUTES));

        $request->session()->put('login_email', $request->email);

        return redirect()->route('login')->with('status', 'Un code à 6 chiffres a été envoyé à votre adresse email.');
    }

    /**
     * Vérifier le code et connecter l'utilisateur.
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $email = $request->session()->get('login_email');
        if (!$email) {
            return redirect()->route('login')->withErrors(['code' => 'Session expirée. Veuillez recommencer.']);
        }

        $key = self::CACHE_PREFIX . $email;
        $storedCode = Cache::get($key);

        if (!$storedCode || $storedCode !== $request->code) {
            throw ValidationException::withMessages([
                'code' => 'Code invalide ou expiré. Vérifiez votre email ou demandez un nouveau code.',
            ]);
        }

        Cache::forget($key);
        $request->session()->forget('login_email');

        $user = User::where('email', $email)->firstOrFail();
        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    /**
     * Retour à l'étape email (nouveau code).
     */
    public function backToEmail(Request $request)
    {
        $request->session()->forget('login_email');
        return redirect()->route('login');
    }
}
