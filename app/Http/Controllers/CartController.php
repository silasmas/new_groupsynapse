<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\PanierService;
use App\Models\commande_produit;
use App\Services\FlexPayService;
use App\Services\FavoriteService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $flexPayService;

    public function __construct(FlexPayService $flexPayService)
    {
        $this->flexPayService = $flexPayService;
    }

    public function checkout(PanierService $cartService)
    {
        // Récupérer les détails du panier via le service PanierService
        $panier = $cartService->obtenirPanier();


        // Extraire les valeurs de la réponse

        $data = $panier['data'];
        $total = $panier['total'];
        $qty = $panier['quantite'];
        //   dd($panier['data']);
        return view('pages.checkout', compact('panier'));
    }
    public function createOrder(Request $request)
    {
        $userId = Auth::id();
        // dd($request->all());
        // Validation des données
        $request->validate([
            'channel' => 'required|in:mobile_money,card',
            'phone' => 'required_if:payment_method,mobile_money'
        ]);

        // Génération de la référence unique
        $reference = generateUniqueReference();
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
        // Lancement du paiement FlexPay
        return $this->initiatePayment($order, $request->phone);
    }
    public function initiatePayment(Commande $order, $phone)
    {

        $data = [];
        if ($order->channel === 'mobile_money') {
            $data = [
                "merchant" => env("FLEXPAY_MARCHAND"),
                "type" => $order->channel === 'mobile_money' ? "1" : "2",
                "phone" => $phone,
                "reference" => $order->reference,
                "amount" => $order->total,
                "currency" => $order->currency,
                "callbackUrl" => env('APP_URL') . '/payment.callback',
            ];
            $rep = initRequeteFlexPay("mobile", $data, $order);
            // dd($rep);
            return response()->json($rep);
        } else {

            $retour = $this->flexPayService->initiatePayment($order->total, $order->currency, $order->reference, "Achat de produits");
            //    dd($retour["rep"]);
            if ($retour['rep']) {
                $order->update([
                    'provider_reference' => $retour['orderNumber'],
                    'etat' => 'En cours'
                ]);
                return response()->json(["reponse" => $retour['rep'], "redirect_url" => $retour['url']], 200);
            } else {
                return response()->json(["reponse" => $retour['rep'], "message" => $retour['message']], 400);
            }
        }
        return response()->json(["error" => "Échec de la transaction"], 400);
    }

    public function checkTransactionStatus(Request $request)
    {
        $reference = $request->input('reference');

        // Construire l'URL avec le paramètre de requête
        $url = 'https://backend.flexpay.cd/api/rest/v1/check/' . urlencode($reference);

        $curl = curl_init($url);

        // Définir les options de cURL pour GET
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . env('FLEXPAY_API_TOKEN'),
        ]);

        // Exécuter la requête
        $curlResponse = curl_exec($curl);

        // Gérer les erreurs de cURL
        if (curl_errno($curl)) {
            $errorMessage = curl_error($curl);
            return response()->json(['error' => 'Erreur de connexion au service FlexPay'], 500);
        }

        curl_close($curl);

        // Valider et traiter la réponse JSON
        $jsonRes = json_decode($curlResponse, true);

        //   dd($jsonRes );
        // // Journaliser la réponse pour le débogage

        $transactionData = $jsonRes['transaction'];
        $transaction = Commande::where('reference', $transactionData['reference'])->first();
        switch ($jsonRes['transaction']["status"]) {
            case 0:
                // Trouver la transaction correspondante
                if ($transaction) {
                    $status = 'Payée';
                    // Mettre à jour l'état des données
                    $transaction->update([
                        'etat' => $status,
                        'amount_customer' => $transactionData['amountCustomer'],
                        'phone' => $transactionData['channel'],
                        'updated_at' => now()
                    ]);
                    $this->clearCartAfterPayment($transactionData['user_id']);
                    return response()->json([
                        'reponse' => true,
                        'message' => 'La transaction mis à été fait avec succès.',
                        'status' => $jsonRes['transaction']["status"],
                    ]);
                }
                break;
            case 1:
                $status = 'Annulée';
                $transaction->update([
                    'etat' => $status,
                    'updated_at' => now()
                ]);
                return response()->json([
                    'reponse' => false,
                    'status' => $jsonRes['transaction']["status"],
                    'message' => $jsonRes["message"],
                ]);
                break;
            case 2:
                $status = 'En attente';
                $transaction->update([
                    'etat' => $status,
                    'updated_at' => now()
                ]);

                return response()->json([
                    'reponse' => true,
                    'message' => $jsonRes["message"],
                    'orderNumber' => $transaction->provider_reference,
                    'status' => $jsonRes['transaction']["status"],
                    'url' => "attente",
                ]);
                break;
            default:
                return response()->json([
                    'reponse' => false,
                    'status' => $jsonRes['transaction']["status"],
                    'message' => $jsonRes["message"],
                ]);
                break;
        }

        // dd($jsonRes["transaction"]);
    }

    public function paid($reference, $amount, $currency, $status)
    {
        // Vérifier si la commande existe
        $order = Commande::where('reference', $reference)->first();
        $msg = "";
        if (!$order) {
            return response()->json(['error' => 'Commande non trouvée'], 404);
        }

        // Mettre à jour le statut en fonction de la réponse de FlexPay
        switch ($status) {
            case 'success':
                $order->etat = 'Payée'; // Paiement réussi
                $msg = 'Paiement réussi !';
                $rep = $this->clearCartAfterPayment($order->user_id);
                break;

            case 'cancel':
                $order->etat = 'Annulée'; // Paiement annulé par l'utilisateur
                $msg = 'Paiement annulé !';
                break;

            case 'decline':
                $order->etat = 'Annulée'; // Paiement refusé
                $msg = 'Paiement refusé !';
                break;

            default:
                return response()->json(['error' => 'Statut inconnu'], 400);
        }

        // Enregistrer les modifications
        $order->save();
        return redirect()->route('commandeStatus')->with([
            'order_details' => [
                'message' => $msg,
                'order_reference' => $reference,
                'amount' => $amount,
                'currency' => $currency,
                'status' => $order->etat,
                'order' => $order->provider_reference,
                'channel' => $order->channel
            ]
        ]);
    }


    public function clearCartAfterPayment($userId)
    {
        // Supprimer tous les articles du panier de l'utilisateur
        Panier::where('user_id', $userId)->delete();

        return response()->json(["reponse" => true, 'message' => 'Le panier a été vidé après le paiement']);
    }

    public function commandeStatus()
    {
        $order_details = session('order_details');
        //    dd($order_details);
        return view('pages.paid', compact('order_details'));
    }



    public function index(PanierService $cartService): View
    {
        // Récupérer les détails du panier via le service PanierService
        $result = $cartService->obtenirPanier();

        // Débogage des données pour vérification
        //  dd($result);

        // Extraire les valeurs de la réponse
        $rep = $result['reponse'];
        $msg = $result['message'];
        $data = $result['data'];
        $total = $result['total'];
        $qty = $result['quantite'];

        // Retourner la vue avec les données du panier
        return view("pages.cart", compact("rep", "msg", "data", "total", "qty"));
    }

    public function addToCart(PanierService $cartService, $id, $quantity = 1)
    {
        $produit = Produit::find($id);
        $prix = is_solde2($produit->isSpecialOffer, $produit->prix, (float) $produit->soldePrice);

        if ($produit) {
            $result = $cartService->ajouterAuPanier($id, $quantity, $prix);

            return response()->json([
                'reponse' => $result['reponse'],
                'message' => $result['message'],
                'data' => $result['data'],
                "total" => $result['total'],
                'grandTotal' => $result['grandTotal'],
                "qty" => $result['quantite']
            ]);
        }

        return response()->json([
            'reponse' => false,
            'message' => "Ce produit n'existe pas!!",
            'data' => null

        ]);
    }

    public function updateCart(PanierService $cartService, $id, $quantity, $type = "plus")
    {
        // Obtenir les détails du panier depuis le service
        // Vérifie si le produit est dans le panier de l'utilisateur
        $result = $cartService->mettreAJourQuantite($id, $quantity, $type);

        // Retourner la réponse JSON avec le message et le statut
        return response()->json([
            'reponse' => $result['reponse'],
            'message' => $result['message'],
            'total' => $result['data']->prixTotal,  // Total calculé pour l'article mis à jour
            'qty' => $result['data']->quantite,      // Quantité mise à jour
            'grandTotal' => $result['grandTotal'],      // Quantité mise à jour
            'qty' => $result['data']->quantite       // Quantité mise à jour
        ]);
    }


    public function details(PanierService $panierService)
    {
        // Obtenir les détails du panier depuis le service
        $result = $panierService->obtenirPanier();

        // Sauvegarder les modifications dans la session si nécessaire
        session()->put('cart_detail', [
            'reponse' => $result['reponse'],
            'message' => $result['message'],
            'data' => $result['data']
        ]);
        // dd($result['data']);
        // Retourner le panier sous forme de JSON
        return response()->json([
            'reponse' => $result['reponse'],
            'message' => $result['message'],
            'data' => $result['data']
        ]);
    }

    public function removeFromCart(PanierService $cartService, $id)
    {

        $result = $cartService->supprimerDuPanier($id);
        // dd($result);
        if (isset($result['data'])) {
            // Retourner la réponse JSON avec le message et le statut
            return response()->json([
                'reponse' => $result['reponse'],
                'message' => $result['message'],
                'total' => $result['data']->prixTotal,  // Total calculé pour l'article mis à jour
                'qty' => $result['data']->quantite,      // Quantité mise à jour
                'grandTotal' => $result['grandTotal'],      // Quantité mise à jour
                'qty' => $result['data']->quantite       // Quantité mise à jour
            ]);
        } else {
            // Retourner la réponse JSON avec le message et le statut
            return response()->json([
                'reponse' => $result['reponse'],
                'message' => $result['message']
            ]);
        }
    }
}
