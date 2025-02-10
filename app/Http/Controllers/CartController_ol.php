<?php
namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    // Afficher le panier
    public function index()
    {
        $cart = session()->get('cart', []);
        return response()->json([
            'status' => 'success',
            'message' => 'Panier récupéré avec succès.',
            'cart' => $cart
        ]);
    }
    public function details()
    {
        // Récupérer le panier de la session
        // $cart = session()->get('cart_detail', ['items' => [], 'sub_total' => 0]);

        // Optionnel : mettre à jour les détails du panier via le service CartService
        $cartService = new CartService();
        $updatedCart = $cartService->getCartDetails();

        // Sauvegarder les modifications dans la session si nécessaire
        session()->put('cart_detail', $updatedCart);

        // Retourner le panier sous forme de JSON
        return response()->json($updatedCart);
    }
    // Ajouter un produit au panier
    public function addToCart($id)
    {
        $Produit = Produit::findOrFail($id);
        $cart = session()->get('cart', []);
dd( $cart[$id]['items']['quantity']);
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $Produit->name,
                "price" => $Produit->price,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => "Le produit '{$Produit->name}' a été ajouté au panier.",
            'cart' => $cart
        ]);
    }

    // Supprimer un produit du panier
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return response()->json([
                'status' => 'success',
                'message' => 'Produit supprimé du panier avec succès.',
                'cart' => $cart
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Le produit n’existe pas dans le panier.'
        ]);
    }

    // Vider le panier
    public function clearCart()
    {
        session()->forget('cart');

        return response()->json([
            'status' => 'success',
            'message' => 'Le panier a été vidé avec succès.'
        ]);
    }
}
