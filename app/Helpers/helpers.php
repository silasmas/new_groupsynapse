<?php

use App\Models\Panier;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Support\Facades\Auth;
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
// if (!function_exists('init_commande')) {

//     function init_commande($panier)
//     {
//         // dd($panier);
//         $cmd = "";
//         $ref = createRef();
//         for ($i = 0; $i < $panier->count(); $i++) {
//             $cmd = Commande::updateOrCreate(
//                 [
//                     'reference' => $ref, // Condition pour trouver une commande existante
//                     'produit_id' => $panier[$i]->produit_id,
//                     'user_id' => $panier[$i]->user_id,
//                     'etat' => "En attente",
//                 ],
//                 [
//                     'quantite' => $panier[$i]->quantite,
//                     'prixTotal' => $panier[$i]->prixTotal,
//                     'livraison' => false,
//                     'total' => $panier[$i]->prixTotal,

//                 ]
//             );
//         }


//         return $cmd;
//     }
// }
