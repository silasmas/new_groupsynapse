<?php
namespace App\Providers;

use App\Models\Branche;
use App\Models\Category;
use App\Models\Produit;
use App\Services\CartService;
use App\Services\FavoriteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(FavoriteService $favoriteService): void
    {
        // Synchroniser les favoris depuis la DB si l'utilisateur est connecté
        $favoriteService->syncFavoritesFromDatabase();
        View::composer('*', function ($view) use ($favoriteService) {
            // $branches = Branche::orderBy('position')->where('isActive', true)->get();
            $branches = Branche::where('isActive', true)
                ->orderBy('position')
                ->with(['categorie' => function ($q) {
                    $q->where('isActive', true)
                        ->with([
                            'produits' => function ($query) {
                                $query->where('isAvalable', true);
                            },
                            'services' => function ($query) {
                                $query->where('active', true)
                                    ->where('disponible', true);
                            },
                        ]);
                }])
                ->get();

            // dd($branches[0]->categorie);
            $categories       = Category::where('isActive', true)->get();
            $favoritesDetails = "";

            $groupedProducts = Produit::with('categories') // Charger les catégories associées
                ->where(function ($query) {
                    $query->Where('isBestseler', true)
                        ->orWhere('isNewArivale', true)
                        ->orWhere('isSpecialOffer', true);
                })
                ->get()
                ->groupBy(function ($produit) {
                    // if ($produit->isAvalable) {
                    //     return 'Available';
                    // } else
                    if ($produit->isBestseler) {
                        return 'Top vente';
                    } elseif ($produit->isNewArivale) {
                        return 'Nouvel arrivage';
                    } elseif ($produit->isSpecialOffer) {
                        return 'Offre spéciale';
                    }
                    return 'Other';
                });
            if (Auth::check()) {
                $user = Auth::user();
                // dd($user->favories()->get());
                Session::put("favories", $user->favories()->get());

                $favoriteService = app(FavoriteService::class);
                $favoriteService->syncFavoritesFromDatabase();
                $favoritesDetails = $favoriteService->getFavoritesDetails();
                //   dd(session()->get("favories")[0]->imageUrls[2]);
            }
            Session::put("cart", (new CartService())->getCartDetails());
            //    dd( isset($favoritesDetails) && !empty($favoritesDetails) ? $favoritesDetails[1]['favorites_count'] : 0 );

            $view->with('groupedProducts', $groupedProducts);
            $view->with('branches', $branches);
            $view->with('categories', $categories);
            $view->with('favorites', $favoritesDetails);
        });
    }
}
