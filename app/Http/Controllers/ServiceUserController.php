<?php
namespace App\Http\Controllers;

use App\Http\Requests\Updateservice_userRequest;
use App\Models\Service;
use App\Models\service_user;
use App\Models\TransactionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ServiceUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }
    public function getService($slug)
    {
        $service = Service::where([['disponible', true], ["active", true]])->get();
        $serv    = $service->where('slug', $slug)->firstOrFail();

        $page = $slug;
        return view("pages.getService", compact("serv", 'page', 'service'));
    }
    public function init(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'nom'          => 'required|string|max:255',
            'email'        => 'required|email',
            'phone'        => 'required|string',
            'piece'        => 'required|file|max:2048',
            'premierDepos' => 'required|numeric',
            'photo'        => 'nullable|file|max:2048',
            'adresse'      => 'nullable|string',
            'livraison'    => 'nullable',
            'service'      => 'required|exists:services,slug',
        ], [
            'nom.required'          => 'Le nom est obligatoire.',
            'nom.string'            => 'Le nom doit être une chaîne de caractères.',
            'nom.max'               => 'Le nom ne peut pas dépasser 255 caractères.',

            'email.required'        => 'L\'adresse e-mail est obligatoire.',
            'email.email'           => 'L\'adresse e-mail n\'est pas valide.',

            'phone.required'        => 'Le numéro de téléphone est obligatoire.',
            'phone.string'          => 'Le numéro de téléphone doit être une chaîne de caractères.',

            'piece.required'        => 'Veuillez fournir une pièce d’identité valide.',
            'piece.file'            => 'La pièce d’identité doit être un fichier.',
            'piece.max'             => 'La pièce d’identité est trop volumineuse (max 2 Mo).',

            'photo.file'            => 'La photo d’identité doit être un fichier valide.',
            'photo.max'             => 'La photo d’identité est trop volumineuse (max 2 Mo).',

            'adresse.string'        => 'L\'adresse doit être une chaîne de caractères.',

            'premierDepos.required' => 'Le champ du premier dépôt est requis.',
            'premierDepos.numeric'  => 'Le premier dépôt doit être un nombre.',

            'service.required'      => 'Le champ service est requis.',
            'service.exists'        => 'Le service sélectionné est invalide.',
        ]);

        $service = Service::where('slug', $validated['service'])->firstOrFail();

        // Upload fichiers
        $piecePath = $request->file('piece')->store('pieces', 'public');
        $photoPath = $request->hasFile('photo') ? $request->file('photo')->store('photos', 'public') : null;

        $reference = "Synapse-" . date('Ymd') . "-" . strtoupper(Str::random(6));

        $serviceUser = service_user::create([
            'reference'      => $reference,
            'nom'            => $validated['nom'],
            'email'          => $validated['email'],
            'telephone'      => $validated['phone'],
            'photo_identite' => $piecePath,
            'piece_identite' => $photoPath,
            'premierDepot'   => $validated['premierDepos'] ?? null,
            'montant_depot'  => $service->prix ?? null,
            'adresse'        => $validated['adresse'] ?? null,
            'livraison'      => $request->has('livraison'),
            'etat'           => 'init',
            'user_id'        => Auth::user()->id,
            'service_id'     => $service->id,
        ]);

        $livraison    = $request->has('livraison') ? 50 : 0;
        $premierDepot = $validated['premierDepos'];
        $coutService  = $service->prix + $livraison + $premierDepot;

        return response()->json([
            'success'   => true,
            'id'        => $serviceUser->id,
            'slug'      => $service->slug,
            'service'   => $serviceUser->prix,
            'livraison' => $livraison,    // exemple de calcul
            'premier'   => $premierDepot, // exemple de calcul
            'total'     => $coutService,  // exemple de calcul
            'currency'  => $service->currency,
            'reference' => $serviceUser->reference,

        ]);
    }
    public function initrecharge(Request $request)
    {
        try {
            $validated = $request->validate([
                'rid'       => 'required|numeric|digits:10',
                'rnumCarte' => 'required|numeric|digits:4',
                'rmontant'  => 'required|numeric|min:1',
                'service'   => 'required|exists:services,slug',
            ], [
                'rid.required'       => 'L\'ID est obligatoire.',
                'rid.numeric'        => 'L\'ID doit être composé de chiffres.',
                'rid.digits'         => 'L\'ID doit contenir exactement 10 chiffres.',

                'rnumCarte.required' => 'Le numéro de la carte est obligatoire.',
                'rnumCarte.digits'   => 'Le numéro de la carte doit contenir exactement 4 chiffres.',

                'rmontant.required'  => 'Le montant est obligatoire.',
                'rmontant.numeric'   => 'Le montant doit être un nombre.',
                'rmontant.min'       => 'Le montant doit être supérieur à 0.',

                'service.required'   => 'Le champ service est requis.',
                'service.exists'     => 'Le service sélectionné est invalide.',
            ]);

            $service = Service::where('slug', $validated['service'])->firstOrFail();

            $reference = "Synapse-" . date('Ymd') . "-" . strtoupper(Str::random(6));

            $serviceUser = service_user::create([
                'reference'       => $reference,
                'montantRecharge' => $validated['rmontant'],
                'idCarte'         => $validated['rid'],
                'numero_carte'    => $validated['rnumCarte'],

                'etat'            => 'init',
                'currency'        => 'CDF',
                'user_id'         => Auth::user()->id,
                'service_id'      => $service->id,
            ]);
            // dd($serviceUser);

            return response()->json([
                'success'      => true,
                'id'           => $serviceUser->id,
                'slug'         => $service->slug,
                'montant'      => $serviceUser->montantRecharge,
                'currency'     => $serviceUser->currency,
                'idCarte'      => $serviceUser->idCarte,
                'numero_carte' => $serviceUser->numero_carte,
                'reference'    => $serviceUser->reference,

            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue. Veuillez réessayer.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    public function modifier(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'nom'          => 'required|string|max:255',
            'email'        => 'required|email',
            'phone'        => 'required|string',
            'piece'        => 'required|file|max:2048',
            'premierDepos' => 'required|numeric',
            'photo'        => 'nullable|file|max:2048',
            'adresse'      => 'nullable|string',
            'livraison'    => 'nullable',
            'service'      => 'required|exists:services,slug',
        ], [
            'nom.required'          => 'Le nom est obligatoire.',
            'nom.string'            => 'Le nom doit être une chaîne de caractères.',
            'nom.max'               => 'Le nom ne peut pas dépasser 255 caractères.',

            'email.required'        => 'L\'adresse e-mail est obligatoire.',
            'email.email'           => 'L\'adresse e-mail n\'est pas valide.',

            'phone.required'        => 'Le numéro de téléphone est obligatoire.',
            'phone.string'          => 'Le numéro de téléphone doit être une chaîne de caractères.',

            'piece.required'        => 'Veuillez fournir une pièce d’identité valide.',
            'piece.file'            => 'La pièce d’identité doit être un fichier.',
            'piece.max'             => 'La pièce d’identité est trop volumineuse (max 2 Mo).',

            'photo.file'            => 'La photo d’identité doit être un fichier valide.',
            'photo.max'             => 'La photo d’identité est trop volumineuse (max 2 Mo).',

            'adresse.string'        => 'L\'adresse doit être une chaîne de caractères.',

            'premierDepos.required' => 'Le champ du premier dépôt est requis.',
            'premierDepos.numeric'  => 'Le premier dépôt doit être un nombre.',

            'service.required'      => 'Le champ service est requis.',
            'service.exists'        => 'Le service sélectionné est invalide.',
        ]);

        $service = Service::where('slug', $validated['service'])->firstOrFail();

        // Upload fichiers
        $piecePath = $request->file('piece')->store('pieces', 'public');
        $photoPath = $request->hasFile('photo') ? $request->file('photo')->store('photos', 'public') : null;

        $reference = "Synapse-" . date('Ymd') . "-" . strtoupper(Str::random(6));

        $serviceUser = service_user::create([
            'reference'      => $reference,
            'nom'            => $validated['nom'],
            'email'          => $validated['email'],
            'telephone'      => $validated['phone'],
            'photo_identite' => $piecePath,
            'piece_identite' => $photoPath,
            'premierDepot'   => $validated['premierDepos'] ?? null,
            'montant_depot'  => $service->prix ?? null,
            'adresse'        => $validated['adresse'] ?? null,
            'livraison'      => $request->has('livraison'),
            'etat'           => 'init',
            'user_id'        => Auth::user()->id,
            'service_id'     => $service->id,
        ]);

        $livraison    = $request->has('livraison') ? 50 : 0;
        $premierDepot = $validated['premierDepos'];
        $coutService  = $service->prix + $livraison + $premierDepot;

        dd($serviceUser->reference);
        return response()->json([
            'success'   => true,
            'id'        => $serviceUser->id,
            'slug'      => $service->slug,
            'service'   => $serviceUser->prix,
            'livraison' => $livraison,    // exemple de calcul
            'premier'   => $premierDepot, // exemple de calcul
            'total'     => $coutService,  // exemple de calcul
            'currency'  => $service->currency,
            'reference' => $serviceUser->reference,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Vérifie si un log identique existe déjà
        $exists = TransactionLog::where('reference', $request->reference)
            ->where('status', $request->status)
            ->where('message', $request->message)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Entrée déjà enregistrée.',
            ], 200); // 200 = pas une erreur, mais pas de doublon enregistré
        }

        // Si non existant, on enregistre
        TransactionLog::create([
            'reference' => $request->reference,
            'status'    => $request->status,
            'message'   => $request->message,
            'ip'        => $request->ip(),
            'user_id'   => auth()->id(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(service_user $service_user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(service_user $service_user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updateservice_userRequest $request, service_user $service_user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(service_user $service_user)
    {
        //
    }
}
