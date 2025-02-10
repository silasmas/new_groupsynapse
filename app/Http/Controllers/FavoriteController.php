<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use App\Services\FavoriteService;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function addFavorite($id)
    {
        // $productId = $request->input('product_id');
        [$success, $message] =$this->favoriteService->addToFavorites($id);
        // dd([$success, $message] );
         // Vérification des valeurs retournées
    if (!$success) {
        return response()->json([
            'reponse' => false,
            'message' => $message ?? 'Une erreur est survenue lors de l\'ajout aux favoris'
        ], 400);
    }

    return response()->json([
        'reponse' => true,
        'message' => $message ?? 'Produit ajouté aux favoris'
    ], 200);
    }

    public function removeFavorite($id)
    {
        $productId = $id;
        [$success, $message]= $this->favoriteService->removeFromFavorites($productId);

        return response()->json(['reponse' => $success, 'message' => $message]);

    }

    public function getFavorites()
    {
         $favorites = $this->favoriteService->getFavoritesDetails();
        //  dd( $favorites );
        // return response()->json($favorites);
        // // return view('favorites.index', ['favorites' => $favorites]);
        try {
            [$success, $response] = $favorites;

            if (!$success) {
                return response()->json([
                    'status' => 'error',
                    'message' => $response, // Message déjà préparé par le service
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $response,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur inattendue est survenue. Veuillez réessayer.',
                'details' => $e->getMessage(), // Détails pour débogage (optionnel)
            ], 500);
        }
    }
    public function updateProductBlock($id)
    {
        $produitSingle  = Produit::with(['favories' => function ($query) {
                            $query->where('user_id', auth()->id());
                        }])->findOrFail($id);

        // Retourne la vue partielle du produit
        return response()->json([
            'success' => true,
            'html' => view('parties.listeProd', compact('produitSingle'))->render()
        ]);
    }
}
