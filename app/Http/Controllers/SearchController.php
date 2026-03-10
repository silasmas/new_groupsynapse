<?php

namespace App\Http\Controllers;

use App\Models\Branche;
use App\Models\Produit;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Recherche temps réel produits, services et branches.
     */
    public function search(Request $request): JsonResponse
    {
        $query = trim($request->input('q', ''));
        $limit = min((int) $request->input('limit', 10), 20);

        if (strlen($query) < 2) {
            return response()->json([
                'produits' => [],
                'services' => [],
                'branches' => [],
                'alternatives' => [],
                'suggestion' => null,
            ]);
        }

        $searchTerm = '%' . $query . '%';

        $branches = Branche::where('isActive', true)
            ->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm);
            })
            ->limit(5)
            ->with('categorie')
            ->get();

        $produits = Produit::where('isAvalable', true)
            ->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm);
            })
            ->limit($limit)
            ->get(['id', 'name', 'slug', 'prix', 'soldePrice', 'currency', 'imageUrls', 'isSpecialOffer']);

        $services = Service::where('active', true)
            ->where('disponible', true)
            ->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm);
            })
            ->limit($limit)
            ->get(['id', 'name', 'slug', 'prix', 'currency', 'image']);

        $alternatives = [];
        $suggestion = null;

        if ($produits->isEmpty() && $services->isEmpty() && $branches->isEmpty()) {
            $suggestion = 'Aucun résultat pour « ' . e($query) . ' ». Voici des suggestions :';
            $words = array_filter(preg_split('/\s+/', $query, -1, PREG_SPLIT_NO_EMPTY), fn ($w) => strlen($w) >= 2);
            $altProduits = collect();
            if (!empty($words)) {
                $altProduits = Produit::where('isAvalable', true)
                    ->where(function ($q) use ($words) {
                        foreach (array_slice($words, 0, 2) as $w) {
                            $q->orWhere('name', 'like', '%' . $w . '%')
                                ->orWhere('description', 'like', '%' . $w . '%');
                        }
                    })
                    ->limit($limit)
                    ->get(['id', 'name', 'slug', 'prix', 'soldePrice', 'currency', 'imageUrls']);
            }
            if ($altProduits->isEmpty()) {
                $altProduits = Produit::where('isAvalable', true)
                    ->where(function ($q) {
                        $q->where('isBestseler', true)->orWhere('isNewArivale', true);
                    })
                    ->limit($limit)
                    ->get(['id', 'name', 'slug', 'prix', 'soldePrice', 'currency', 'imageUrls']);
            }
            if ($altProduits->isEmpty()) {
                $altProduits = Produit::where('isAvalable', true)
                    ->inRandomOrder()
                    ->limit($limit)
                    ->get(['id', 'name', 'slug', 'prix', 'soldePrice', 'currency', 'imageUrls']);
            }

            $altServices = Service::where('active', true)->where('disponible', true)
                ->limit(ceil($limit / 2))
                ->get(['id', 'name', 'slug', 'prix', 'currency', 'image']);

            $altBranches = Branche::where('isActive', true)
                ->where('name', 'like', '%' . $query . '%')
                ->limit(3)
                ->with('categorie')
                ->get();

            $alternatives = [
                'produits' => $altProduits->map(fn ($p) => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'slug' => $p->slug,
                    'url' => route('showProduct', ['slug' => $p->slug]),
                    'prix' => $p->prix,
                    'soldePrice' => $p->soldePrice,
                    'currency' => $p->currency ?? '$',
                    'imageUrls' => $p->getImageUrlsAttribute(),
                    'type' => 'produit',
                ])->values()->all(),
                'services' => $altServices->map(fn ($s) => [
                    'id' => $s->id,
                    'name' => $s->name,
                    'slug' => $s->slug,
                    'url' => route('showService', ['slug' => $s->slug]),
                    'prix' => $s->prix,
                    'currency' => $s->currency ?? '$',
                    'image' => $s->image ? asset('storage/' . $s->image) : null,
                    'type' => 'service',
                ])->values()->all(),
                'branches' => $altBranches->map(fn ($b) => [
                    'id' => $b->id,
                    'name' => $b->name,
                    'url' => ($b->categorie->first() && $b->categorie->first()->type === 'service') ? route('services') : route('shop'),
                    'type' => 'branche',
                ])->values()->all(),
            ];
        }

        $branchesData = $branches->map(fn ($b) => [
            'id' => $b->id,
            'name' => $b->name,
            'url' => ($b->categorie->first() && $b->categorie->first()->type === 'service') ? route('services') : route('shop'),
            'type' => 'branche',
        ]);

        return response()->json([
            'produits' => $produits->map(fn ($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'url' => route('showProduct', ['slug' => $p->slug]),
                'prix' => $p->prix,
                'soldePrice' => $p->soldePrice,
                'currency' => $p->currency ?? '$',
                'imageUrls' => $p->getImageUrlsAttribute(),
                'type' => 'produit',
            ]),
            'services' => $services->map(fn ($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'slug' => $s->slug,
                'url' => route('showService', ['slug' => $s->slug]),
                'prix' => $s->prix,
                'currency' => $s->currency ?? '$',
                'image' => $s->image ? asset('storage/' . $s->image) : null,
                'type' => 'service',
            ]),
            'branches' => $branchesData,
            'alternatives' => $alternatives,
            'suggestion' => $suggestion,
        ]);
    }
}
