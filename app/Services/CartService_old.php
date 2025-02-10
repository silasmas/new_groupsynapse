<?php

namespace App\Services;

use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService_old
{
    public function addToCart(int $productId, int $quantity)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cartItem = Panier::where('user_id', $user->id)->where('product_id', $productId)->first();

            if ($cartItem) {
                $cartItem->quantity += (int) $quantity;
                $cartItem->save();
            } else {
                Panier::create([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
            return [true, 'Produit ajouté au panier avec succès.'];
        } else {
            $cart = Session::get('cart', []);
            if (!is_array($cart)) {
                $cart = [];
            }
            $cart[$productId] = isset($cart[$productId]) ? (int) $cart[$productId] + (int) $quantity : (int) $quantity;
            Session::put('cart', $cart);
            return [true, 'Produit ajouté au panier de session avec succès.'];
        }
    }

    public function removeFromCart(int $productId, int $quantity)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cartItem = Panier::where('user_id', $user->id)->where('product_id', $productId)->first();

            if ($cartItem) {
                if ($cartItem->quantity <= $quantity) {
                    $cartItem->delete();
                } else {
                    $cartItem->quantity -= (int) $quantity;
                    $cartItem->save();
                }
            }
            return [true, 'Produit retiré du panier avec succès.'];
        } else {
            $cart = Session::get('cart', []);
            if (isset($cart[$productId])) {
                if ($cart[$productId] <= $quantity) {
                    unset($cart[$productId]);
                } else {
                    $cart[$productId] -= $quantity;
                }
                Session::put('cart', $cart);
            }
            return [true, 'Produit retiré du panier de session avec succès.'];
        }
    }

    public function clearCart()
    {
        if (Auth::check()) {
            $user = Auth::user();
            Panier::where('user_id', $user->id)->delete();
            return [true, 'Panier vidé avec succès.'];
        } else {
            Session::forget('cart');
            return [true, 'Panier de session vidé avec succès.'];
        }
    }

    public function getCartDetails()
    {
        $result = [
            'items' => [],
            'sub_total' => 0,
            'cart_count' => 0,
        ];

        if (Auth::check()) {
            $user = Auth::user();
            $cartItems = Panier::where('user_id', $user->id)->get();

            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                if ($product) {
                    $subTotal = (float) trim((string) $product->prix) * (int) $cartItem->quantity;
                    $result['items'][] = [
                        'product' => $this->formatProduct($product),
                        'quantity' => $cartItem->quantity,
                        'sub_total' => $subTotal,
                    ];
                    $result['sub_total'] += $subTotal;
                    $result['cart_count'] += $cartItem->quantity;
                }
            }
        } else {
            $cart = Session::get('cart', []);
            foreach ($cart as $productId => $quantity) {
                $product = Produit::find($productId);
                if ($product) {
                    $subTotal = (float) trim((string) $product->prix) * (int) $quantity;
                    $result['items'][] = [
                        'product' => $this->formatProduct($product),
                        'quantity' => $quantity,
                        'sub_total' => $subTotal,
                    ];
                    $result['sub_total'] +=(int) $subTotal;
                    $result['cart_count'] +=(int) $quantity;
                }
            }
        }

        return [true, 'Détails du panier récupérés avec succès.', $result];
    }

    private function formatProduct(Produit $product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'desc' => $product->description,
            'prix' => $product->prix,
            'slug' => $product->slug,
            'soldePrice' => $product->soldePrice,
            'imageUrls' => $product->imageUrls(),
        ];
    }
}
