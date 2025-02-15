<?php

namespace App\Http\Controllers;

use App\Models\Favorie;
use App\Models\Produit;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function shop(Request $request): View
    {
        $nbr=$request->input('nbr');
        $nbrPage=9;
        $sort=$request->input('sort');
        $categorie_id=$request->input('categorie');

        $produits=Produit::query();
        if($sort || $nbr|| $categorie_id){
            $filter=$sort==="prix"?"asc":"desc";
            $produits=$produits->orderBy("soldePrice",$filter);
            if (is_numeric($nbr)) {
                $nbrPage=(int)$nbr;
            }
            if (is_numeric($categorie_id)||$categorie_id==="all") {
                if ($categorie_id!="all") {
                    $categorie_id=(int)$categorie_id;
                    $produits=$produits->whereHas('categories',function($query) use ($categorie_id){
                        $query->where('category_id', $categorie_id);
                    });
                }
            }
        }
        $categories=Category::get();
        $produits=$produits->paginate($nbrPage)->onEachSide(1);
        // dd($produits);

        return view("pages.shop",compact("produits","categories"));
    }
    public function show($lug) {

        $produit=Produit::where("slug", $lug)->first();
        return view("pages.produit",compact("produit"));
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
