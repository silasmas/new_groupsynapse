<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Controller;

class EmailVerificationController extends Controller
{
    public function verify(EmailVerificationRequest $request)
    {
        if (! $request->user()->hasVerifiedEmail()) {
            $request->fulfill(); // marque comme vérifié
        }

        return redirect()->route('verification.success'); // redirige vers la bonne vue
    }

    public function notice()
    {
        return view('auth.verify-email');
    }
}
