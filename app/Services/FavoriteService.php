<?php

namespace App\Services;

use App\Models\Produit;
use App\Models\Favorie; // Assurez-vous d'avoir un modèle pour la table Favorie
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    public function addToFavorites($productId)
    {
        $favorites = Session::get('favorites', []);

        if (!in_array($productId, $favorites)) {
            $favorites[] = $productId;
            Session::put('favorites', $favorites);

            // Sauvegarder en DB si l'utilisateur est connecté
            if (Auth::check()) {
                $created = Favorie::updateOrCreate([
                    'user_id' => Auth::id(),
                    'produit_id' => $productId,
                ]);

                return $created ? [true, 'Produit ajouté aux favoris avec succès.'] : [false, "Erreur lors de l'ajout aux favoris."];
            }else{
                return [false,"Merci de vous connecté pour mettre en favorie"];
            }

            return [true, 'Produit ajouté aux favoris dans la session.'];
        }

        return [false, 'Le produit est déjà dans les favoris.'];
    }

    public function removeFromFavorites($productId)
    {
        $favorites = Session::get('favorites', []);

        if (($key = array_search($productId, $favorites)) !== false) {
            unset($favorites[$key]);
            $favorites = array_values($favorites); // Reindex array
            Session::put('favorites', $favorites);

            // Supprimer de la DB si l'utilisateur est connecté
            if (Auth::check()) {
                $deleted = Favorie::where('user_id', Auth::id())
                                  ->where('produit_id', $productId)
                                  ->delete();
                return $deleted > 0 ? [true, 'Produit retiré des favoris avec succès.'] : [false, 'Erreur lors de la suppression en base de données.'];
            }

            return [true, 'Produit retiré des favoris dans la session.'];
        }

        return [false, "Le produit n'est pas dans les favoris."];
    }

    public function clearFavorites()
    {
        Session::forget('favorites');

        // Supprimer tous les favoris de la DB si l'utilisateur est connecté
        if (Auth::check()) {
            $deleted = Favorie::where('user_id', Auth::id())->delete();
            return $deleted > 0 ? [true, 'Tous les favoris ont été supprimés.'] : [false, 'Erreur lors de la suppression des favoris en base de données.'];
        }

        return [true, 'Tous les favoris ont été supprimés de la session.'];
    }

    public function getFavoritesDetails()
    {
        $favorites = Session::get('favorites', []);
        $result = [
            'items' => [],
            'favorites_count' => count($favorites),
        ];

        foreach ($favorites as $productId) {
            $product = Produit::find($productId);
            if ($product) {
                $result['items'][] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'desc' => $product->description,
                    'prix' => $product->prix,
                    'slug' => $product->slug,
                    'soldePrice' => $product->soldePrice,
                    'imageUrls' => $product->getImageUrlsAttribute(),
                ];
            }
        }
        return [true, $result]; // Toujours un tableau, même si vide
        // return count($result['items']) > 0 ? [true, $result] : [false, 'Aucun favori trouvé.'];
    }

    public function syncFavoritesFromDatabase()
    {
        if (Auth::check()) {
            $userId = Auth::id();

            // Récupérer les favoris en base de données
            $dbFavorites = Favorie::where('user_id', $userId)->pluck('produit_id')->toArray();

            // Récupérer les favoris en session
            $sessionFavorites = Session::get('favorites', []);

            // Ajouter à la base de données les favoris présents uniquement en session
            $allSynchronized = true;
            foreach ($sessionFavorites as $productId) {
                if (!in_array($productId, $dbFavorites)) {
                    $created = Favorie::create([
                        'user_id' => $userId,
                        'produit_id' => $productId,
                    ]);
                    if (!$created) {
                        $allSynchronized = false;
                    }
                }
            }

            // Mettre à jour la session avec tous les favoris (session + DB)
            $mergedFavorites = array_unique(array_merge($dbFavorites, $sessionFavorites));
            Session::put('favorites', $mergedFavorites);

            return $allSynchronized ? [true, 'Les favoris ont été synchronisés avec succès.'] : [false, 'Erreur lors de la synchronisation des favoris.'];
        }

        return [false, 'Utilisateur non authentifié.'];
    }
}
