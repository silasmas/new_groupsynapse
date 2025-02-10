<?php

namespace App\Services;

use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;

class PanierService
{
    /**
     * Ajouter un produit au panier.
     *
     * @param int $produitId
     * @param int $quantite
     * @param double $prixUnitaire
     * @return array
     */
    public function ajouterAuPanier(int $produitId, int $quantite, float $prixUnitaire)
    {
         $userId = Auth::id();

        $panier = Panier::where('user_id', $userId)
                        ->where('produit_id', $produitId)
                        ->first();

        if ($panier) {
            $panier->quantite += $quantite;
            $panier->prixTotal = $panier->quantite * $prixUnitaire;
        } else {
            $panier = Panier::create([
                'user_id' => $userId,
                'produit_id' => $produitId,
                'quantite' => $quantite,
                'prixUnitaire' => $prixUnitaire,
                'prixTotal' => $quantite * $prixUnitaire,
            ]);
        }
        // Recalculer le grand total après mise à jour
        $grandTotal = Panier::where('user_id', $userId)->sum('prixTotal');

        $totalPrix = $panier->sum('prixTotal');
        $totalQuantite = $panier->sum('quantite');
        $panier->save();
        $panier->load('produit');
        return ['message' => 'Produit ajouté au panier', 'reponse' => true, 'data' => $panier,'total' => $totalPrix,
        'quantite' => $totalQuantite,"grandTotal"=>$grandTotal];
    }

    /**
     * Obtenir tous les produits du panier de l'utilisateur connecté.
     *
     * @return array
     */
    public function obtenirPanier()
    {
        $userId = Auth::id();
        $panier = Panier::where('user_id', $userId)->with('produit')->get();
       // Ajouter la première image au retour
    $panier->each(function ($item) {
        $item->produit->first_image = $item->produit->first_image;
    });
    $totalPrix = $panier->sum('prixTotal');
    $totalQuantite = $panier->sum('quantite');

    return [
        'message' => 'Contenu du panier récupéré',
        'reponse' => true,
        'data' => $panier,
        'total' => $totalPrix,
        'quantite' => $totalQuantite
    ];
    }

    /**
     * Supprimer un produit du panier.
     *
     * @param int $produitId
     * @return array
     */
    public function supprimerDuPanier(int $produitId)
    {
        $userId = Auth::id();
        Panier::where('user_id', $userId)->where('produit_id', $produitId)->delete();
        $panier = Panier::where('user_id', $userId)->first();
        // dd($panier?true:false);
        if ($panier==true) {
            $totalPrix = $panier->sum('prixTotal');
            $totalQuantite = $panier->sum('quantite');
            $grandTotal = Panier::where('user_id', $userId)->sum('prixTotal');
            return ['message' => 'Produit supprimé du panier', 'reponse' => true,
            'data' => $panier, 'grandTotal' => $grandTotal,'total' => $totalPrix,
            'quantite' => $totalQuantite];
        }else {
            return ['message' => 'Produit supprimé du panier, votre panier est vide!', 'reponse' => true, 'data' => null];

        }

    }

    /**
     * Mettre à jour la quantité d'un produit dans le panier.
     *
     * @param int $produitId
     * @param int $quantite
     * @return array
     */
    public function mettreAJourQuantite(int $produitId, int $quantite,string $type = 'plus')
    {
        if($quantite < 0) return ['message' => 'La quantité minimum est 1', 'reponse' => false, 'data' => null];

        $userId = Auth::id();
        $panier = Panier::where('user_id', $userId)->where('produit_id', $produitId)->first();
        if ($panier) {
            $totalPrix = $panier->sum('prixTotal');
            $totalQuantite = $panier->sum('quantite');
            $type=="plus"?$panier->quantite += $quantite:$panier->quantite -= $quantite;

            $panier->prixTotal = $totalQuantite * $panier->prixUnitaire;
            $panier->save();
            $panier->load('produit');

              // Recalculer le grand total après mise à jour
              $grandTotal = Panier::where('user_id', $userId)->sum('prixTotal');
            // dd($grandTotal);
              return ['message' => 'Quantité mise à jour', 'reponse' => true, 'data' => $panier, 'grandTotal' => $grandTotal,'total' => $totalPrix,
            'quantite' => $totalQuantite];

        }

        return ['message' => 'Produit non trouvé dans le panier', 'reponse' => false, 'data' => null];
    }

    /**
     * Vider le panier de l'utilisateur connecté.
     *
     * @return array
     */
    public function viderPanier()
    {
        $userId = Auth::id();
        Panier::where('user_id', $userId)->delete();

        return ['message' => 'Panier vidé avec succès', 'reponse' => true, 'data' => null];
    }
}
