<?php

namespace App\Http\Controllers;

use App\Models\Favorie;
use App\Models\Produit;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index() {
        return view("pages.home");
    }
    public function contact() {
        return view("pages.contact");
    }
    public function favories() {
        return view("pages.favories");
    }
    public function about() {
        return view("pages.about");
    }
    public function branches() {
        return view("pages.services");
    }
    public function shop(Request $request)
    {
        $nbr=$request->input('nbr');
        $nbrPage=9;
        $sort=$request->input('sort');
        $categorie_id=$request->input('categorie');
        $search=$request->input('q');

        $produits=Produit::query()->where('isAvalable', true);
        if (!empty($search)) {
            $produits=$produits->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }
        if (is_numeric($categorie_id) || $categorie_id === 'all') {
            if ($categorie_id !== 'all') {
                $categorie_id = (int) $categorie_id;
                $produits = $produits->whereHas('categories', function ($query) use ($categorie_id) {
                    $query->where('category_id', $categorie_id);
                });
            }
        }
        if ($sort) {
            if ($sort === 'prix_asc') {
                $produits = $produits->orderBy('soldePrice', 'asc');
            } elseif ($sort === 'prix_desc') {
                $produits = $produits->orderBy('soldePrice', 'desc');
            } elseif ($sort === 'nom_asc') {
                $produits = $produits->orderBy('name', 'asc');
            } elseif ($sort === 'nom_desc') {
                $produits = $produits->orderBy('name', 'desc');
            } elseif ($sort === 'nouveautes') {
                $produits = $produits->orderBy('created_at', 'desc');
            } else {
                $produits = $produits->orderBy('soldePrice', 'asc');
            }
        } else {
            $produits = $produits->orderBy('created_at', 'desc');
        }
        if (is_numeric($nbr) && $nbr >= 6 && $nbr <= 24) {
            $nbrPage = (int) $nbr;
        }
        $categories = Category::where('type', 'produit')->where('isActive', true)->get();
        $categoryIds = $categories->pluck('id');
        $counts = $categoryIds->isNotEmpty()
            ? DB::table('category_produit')
                ->join('produits', 'produits.id', '=', 'category_produit.produit_id')
                ->whereIn('category_produit.category_id', $categoryIds)
                ->where('produits.isAvalable', true)
                ->selectRaw('category_produit.category_id, count(*) as cnt')
                ->groupBy('category_produit.category_id')
                ->pluck('cnt', 'category_id')
            : collect();
        $categories->each(fn ($c) => $c->produits_count = $counts[$c->id] ?? 0);
        $categories = $categories->sortByDesc('produits_count')->values();
        $produits = $produits->with(['categories'])->withAvg('comments as avg_rating', 'rating')->paginate($nbrPage)->withQueryString()->onEachSide(2);
        $totalSansCategorie = Produit::where('isAvalable', true)
            ->when(!empty($search), fn ($q) => $q->where('name', 'like', '%'.$search.'%')->orWhere('description', 'like', '%'.$search.'%'))
            ->count();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('parties.shop-products', compact('produits'))->render(),
                'pagination' => $produits->links('pagination::bootstrap-5')->toHtml(),
                'total' => $produits->total(),
                'from' => $produits->firstItem(),
                'to' => $produits->lastItem(),
            ]);
        }

        return view("pages.shop", compact("produits", "categories", "totalSansCategorie"));
    }
    public function show($lug)
    {
        $produit = Produit::where('slug', $lug)->with(['categories'])->withAvg('comments as avg_rating', 'rating')->firstOrFail();
        $similarProducts = Produit::where('isAvalable', true)
            ->where('id', '!=', $produit->id)
            ->when($produit->categories->isNotEmpty(), function ($q) use ($produit) {
                $catIds = $produit->categories->pluck('id');
                $q->whereHas('categories', fn ($q2) => $q2->whereIn('category_id', $catIds));
            })
            ->withAvg('comments as avg_rating', 'rating')
            ->inRandomOrder()
            ->limit(8)
            ->get();
        if ($similarProducts->count() < 4) {
            $extra = Produit::where('isAvalable', true)
                ->whereNotIn('id', $similarProducts->pluck('id')->push($produit->id))
                ->withAvg('comments as avg_rating', 'rating')
                ->inRandomOrder()
                ->limit(8 - $similarProducts->count())
                ->get();
            $similarProducts = $similarProducts->merge($extra);
        }
        $metaDescription = \Illuminate\Support\Str::limit(strip_tags($produit->description ?? ''), 160) ?: config('seo.defaults.description');
        $images = $produit->getImageUrlsAttribute();
        $metaImage = $images[0] ?? asset('assets/img/logo/logosynapse.png');
        $titre = $produit->name;
        return view('pages.produit', compact('produit', 'similarProducts', 'metaDescription', 'metaImage', 'titre'));
    }
    public function addFavorie($id) {
        // dd(Auth::user()->id);
        $message=[];
        $favorie=Favorie::where([["produit_id",$id],["user_id",Auth::user()->id ]])->first();
        if ($favorie) {
            $message= ["reponse"=>false,"message"=>"Ce produit se trouve déjà dans vos favories!"];
        }else{
            $fav=Favorie::create([
                "produit_id"=>$id,
               "user_id"=>Auth::user()->id
            ]);
            if ($fav) {
                $message= ["reponse"=>true,"message"=>"Le produit est ajouter dans vos favories!"];
            }else{
                $message= ["reponse"=>false,"message"=> "Une erreur s'est produit"];
            }

        }
        return redirect()->back()->with("retour",$message);
    }
}
