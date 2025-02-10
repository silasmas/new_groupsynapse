<?php

namespace App\Services;

use App\Models\Produit;
use Illuminate\Support\Facades\Session;

class CartService
{
    // Ajouter un produit au panier
    public function addToCart($productId, $quantity)
    {
        if ($quantity < 1) {
            return [false, 'La quantité doit être supérieure à zéro.'];
        }

        $cart = Session::get('cart', []);
        // dd( is_numeric($cart[$productId]));
        if (isset($cart[$productId])&& is_numeric($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] =(int) $quantity;
        }

        Session::put('cart', $cart);

        return [true, 'Produit ajouté au panier avec succès.'];
    }

    // Supprimer un produit du panier
    public function removeFromCart($productId, $quantity)
    {
        $cart = Session::get('cart', []);

        if (!isset($cart[$productId])) {
            return [false, 'Le produit n\'existe pas dans le panier.'];
        }

        if ($cart[$productId] <= $quantity) {
            unset($cart[$productId]);
            $message = 'Produit supprimé du panier.';
        } else {
            $cart[$productId] -= $quantity;
            $message = 'Quantité mise à jour dans le panier.';
        }

        Session::put('cart', $cart);

        return [true, $message];
    }

    // Vider le panier
    public function clearCart()
    {
        Session::forget('cart');

        return [true, 'Le panier a été vidé avec succès.'];
    }

    // Obtenir les détails du panier
    public function getCartDetails()
    {
        $cart = Session::get('cart', []);
        $result = [
            'items' => [],
            'sub_total' => 0,
            'cart_count' => 0,
        ];

        foreach ($cart as $productId => $quantity) {
            // Vérification stricte si la quantité est bien numérique
        if (!is_numeric($quantity)) {
            continue; // Ignore les entrées invalides
        }
            $product = Produit::find($productId);
            if ($product) {
                $subTotal = (float) $product->prix * (float) $quantity;
                $result['items'][] = [
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'desc' => $product->description,
                        'prix' => $product->prix,
                        'slug' => $product->slug,
                        'soldePrice' => $product->soldePrice,
                        'imageUrls' => $product->imageUrls(),
                    ],
                    'quantity' =>(int) $quantity,
                    'sub_total' => $subTotal,
                ];
                $result['sub_total'] += (float) $subTotal;
                $result['cart_count'] += (int) $quantity;
            }
        }

        if (empty($result['items'])) {
            return [false, 'Votre panier est vide.',$result];
        }

        return [true, 'Détails du panier récupérés avec succès.', $result];
    }
}
