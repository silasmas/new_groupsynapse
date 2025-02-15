<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\commande_produit;
use Illuminate\Http\Request;
use App\Services\PanierService;
use App\Services\FlexPayService;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    protected $flexPayService;

    public function __construct(FlexPayService $flexPayService)
    {
        $this->flexPayService = $flexPayService;
    }

    /**
     * Lance un paiement.
     */
    public function initiatePayment(Request $request)
    {
        $userId = Auth::id();
        $request->validate([
            'phone' => 'required|string',
            'total' => 'required|numeric|min:1',
            'currency' => 'required|string|in:CDF,USD',
            'channel' => 'required|in:mobile_money,card',
        ]);

        $reference = generateUniqueReference(); // Générer une référence unique
        $callbackUrl = route('payment.callback'); // URL de retour
        // Création de la commande
        $order = Commande::create([
            'user_id' => $userId,
            'reference' => $reference,
            'total' => $request->total,
            'channel' => $request->channel,
            'currency' => $request->currency,
        ]);
        $cartService = new PanierService();
        $panier = $panier = $cartService->obtenirPanier();
        // Ajout des produits
        foreach ($panier["data"] as $product) {
            // dd($product->prixUnitaire);
            Commande_produit::create([
                'commande_id' => $order->id,
                'produit_id' => $product['produit_id'],
                'quantite' => $product['quantite'],
                'prix_unitaire' => $product->prixUnitaire,
                'prix_total' => $product['quantite'] * $product->prixUnitaire,
            ]);
        }
        $response = $this->flexPayService->requestPayment(
            $request->phone,
            $request->amount,
            $request->currency,
            $reference,
            $callbackUrl
        );
        dd($response);
        return response()->json($response);
    }

    /**
     * Vérifie le statut d'une transaction.
     */
    public function checkPaymentStatus(Request $request)
    {
        $request->validate(['orderNumber' => 'required|string']);

        $response = $this->flexPayService->checkTransaction($request->orderNumber);

        return response()->json($response);
    }

    /**
     * Gère le retour du paiement (callback).
     */
    public function paymentCallback(Request $request)
    {
        \Log::info('Callback reçu:', $request->all());

        // Mettez à jour votre base de données selon le statut de la transaction
        return response()->json(['message' => 'Callback reçu'], 200);
    }
}
