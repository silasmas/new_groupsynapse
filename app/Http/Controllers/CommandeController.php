<?php
namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    // Afficher le panier
    public function mesAchats()
    {
        $userId = Auth::id(); // Récupère l'ID de l'utilisateur connecté

        $commandes = Commande::with(['produits']) // Charge les produits liés via la table pivot
            ->where('user_id', $userId)
            ->where('etat', 'Payée')
            ->get();
        // dd($commandes[0]->produits[0]->slug);
        return view("pages.mesAchats", compact('commandes'));
    }

}
