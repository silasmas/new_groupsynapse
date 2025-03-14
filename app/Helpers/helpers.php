<?php

use App\Models\Panier;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


// Get web URL
if (!function_exists('isActive')) {
    function isActive($menu)
    {
        if (Route::current()->getName() == $menu) {
            return 'active';
        }
    }
}
if (!function_exists('createRef')) {
    function createRef()
    {
        return 'REF-' . ((string) random_int(10000000, 99999999));;
    }
}
if (!function_exists('initRequeteFlexPay')) {
    function initRequeteFlexPay($type, $data, Commande $order)
    {
        $responseBody = "";
        if ($type == "mobile") {
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . env('FLEXPAY_API_TOKEN')
            ])->post(env('FLEXPAY_GATEWAY_MOBILE'), $data);

            $responseBody = $response->json();

            if ($responseBody['code'] == "0") {
                $order->update([
                    'provider_reference' => $responseBody['orderNumber'],
                    'etat' => 'En cours'
                ]);
                return [
                    "reponse" => true,
                    "message" => "Paiement en attente",
                    "reference" => $responseBody['orderNumber'],
                    "type" => "mobile",
                    "reference" => $order->reference,
                    "orderNumber" => $responseBody['orderNumber'],
                ];
            } else {
                return response()->json(
                    [
                        "reponse" => false,
                        "message" => "Échec de la transaction",
                    ]
                );
            }
        } else {
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . env('FLEXPAY_API_TOKEN')
            ])->post(env('FLEXPAY_GATEWAY_CARD'), $data);

            $responseBody = $response->json();
        }
        return $responseBody;
    }
}
if (!function_exists('generateUniqueReference')) {
    function generateUniqueReference()
    {
        do {
            $reference = 'ORD-' . strtoupper(Str::random(10));
        } while (Commande::where('reference', $reference)->exists());

        return $reference;
    }
}
if (!function_exists('formatPrix')) {
    function formatPrix($prix,  $currency = "USD")
    {


        // Définition du symbole de la devise
        $currencySymbol = ($currency == "USD") ? "$" : "FC";

        // Retourne le prix sans solde
        return number_format($prix, 2, ',', " ") . " " . $currencySymbol;
    }
}
if (!function_exists('is_solde')) {
    function is_solde($solde, $prix, $soldPrix,  $currency = "USD", $espace = "normal")
    {

        // Définition du symbole de la devise
        $currencySymbol = ($currency == "USD") ? "$" : "FC";

        switch ($solde) {
            case true:
                if ($espace == "normal") {
                    return number_format($soldPrix, 2, ',', " ") . "" . $currencySymbol;
                } else {
                    // dd($espace);
                    return number_format($prix, 2, ',', " ") . "" . $currencySymbol;
                }
            case false:
                if ($espace == "normal") {
                    return number_format($prix, 2, ',', " ") . "" . $currencySymbol;
                } else {
                    return "";
                }
            default:
                return "";

                break;
        }
    }
}
if (!function_exists('is_solde2')) {
    function is_solde2($solde, $prix, $soldPrix)
    {

        if ($solde) {
            // Retourne le prix en solde
            return (float) number_format($soldPrix, 2, ',', " ");
        } else {
            // Retourne le prix normal
            return (float) number_format($prix, 2, ',', " ");
        }
    }
}
if (!function_exists('formatPrix2')) {
    function formatPrix2($mode, $prix, $soldePrice, $currency = "USD")
    {
        $retour = "";

        // Définition du symbole de la devise
        $currencySymbol = ($currency == "USD") ? "$" : "FC";

        if ($mode == true) {
            // Retourne le prix soldé avec l'ancien prix barré
            return number_format($soldePrice, 2, ',', " ") . " " . $currencySymbol .
                " <del class='old-price'>" . number_format($prix, 0, ',', " ") . " " . $currencySymbol . "</del>";
        } elseif ($mode == false) {
            // Retourne le prix sans solde
            return number_format($prix, 2, ',', " ") . " " . $currencySymbol;
        }

        return $retour;  // Retourne une valeur vide si aucun mode valide n'est fourni
    }
}
if (!function_exists('formatPrix3')) {
    function formatPrix3($mode, $prix, $soldePrice, $currency = "USD")
    {
        $retour = "";

        // Définition du symbole de la devise
        $currencySymbol = ($currency == "USD") ? "$" : "FC";

        if ($mode == true) {
            // Retourne le prix soldé avec l'ancien prix barré
            return
                " <del class='old-price'>" . number_format($prix, 0, ',', " ") . " " . $currencySymbol . "</del>" .
                "<span class='new-price'>" . number_format($soldePrice, 2, ',', " ") . " " . $currencySymbol . " </span'>";
        } elseif ($mode == false) {
            // Retourne le prix sans solde
            return "<span class='new-price'>" . number_format($prix, 2, ',', " ") . " " . $currencySymbol . " </span'>";;
        }

        return $retour;  // Retourne une valeur vide si aucun mode valide n'est fourni
    }
}
if (!function_exists('reduction')) {
    function reduction(Produit $produit)
    {
        return (number_format((($produit->prix - $produit->soldePrice) / $produit->prix) * 100, 0));
    }
}
if (!function_exists('titre_site')) {

    function titre_site()
    {
        return  " | " . Session::get('settings')?->name;
    }
}
if (!function_exists('init_commande')) {

    function init_commande($panier)
    {
        // dd($panier);
        // 1. Créer une commande
        $commande = Commande::create([
            'reference' => createRef(),
            'user_id' => Auth::id(),
            'total' => 0, // Sera mis à jour plus tard
            'etat' => 'En attente',
            'livraison' => false,
        ]);

        // 2. Ajouter des produits du panier à la commande
        $total = 0;
        foreach ($panier as $item) {
            // dd($item->prixUnitaire);
            $prixTotal = $item->quantite * $item->prixUnitaire;

            $commande->produits()->attach($item->produit_id, [
                'quantite' => $item->quantite,
                'prix_unitaire' => $item->prixUnitaire,
                'prix_total' => $prixTotal,
            ]);

            $total += $prixTotal;
        }

        // 3. Mettre à jour le total de la commande
        $commande->update(['total' => $total]);

        return $commande;
    }
}
if (!function_exists('sendSms')) {

    function sendSms($phoneNumber, $message)
    {
        // URL de l'API de Keccel (remplacez par l'URL réelle)
        $apiUrl = env('SMS_URL');

        // Clé API ou identifiants d'authentification (remplacez par vos informations)
        $apiKey = env('SMS_TOKEN');

        // Données à envoyer
        $postData = [
            "token" => $apiKey,    // taken
            "to" => $phoneNumber,    // Numéro de téléphone du destinataire
            "from" => env('SMS_FROM'), // Optionnel : Nom ou numéro de l'expéditeur
            "message" => $message,   // Contenu du message
        ];

        // Initialisation de cURL
        $ch = curl_init();

        // Configuration de la requête
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData)); // Conversion des données en JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $apiKey", // Clé API incluse dans les en-têtes
        ]);

        // Exécuter la requête
        $response = curl_exec($ch);

        // Vérifier les erreurs
        if (curl_errno($ch)) {
            echo "Erreur cURL : " . curl_error($ch);
        }

        // Décoder la réponse
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Afficher la réponse pour débogage
        return [
            "status_code" => $responseCode,
            "response" => json_decode($response, true),
        ];
    }
}
