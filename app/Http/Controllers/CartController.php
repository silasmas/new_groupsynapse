<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\PanierService;
use App\Services\FavoriteService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{

    public function commnder(Request $request)
    {
        $userId = Auth::id();
        // $reference= createRef();
        $panier = Panier::where('user_id', $userId)->get();
       $commande= init_commande($panier);
    //    $commande->load('produit');
        //  dd($commande);
        return view('pages.checkout',compact('commande',"panier"));
        // $inputs = [
        //     'transaction_type_id' => $request->toggleOption == 'mobile' ? 1 : 2,
        //     'amount' => $request->montant,
        //     'currency' => $request->monaie,
        //     'reference' => $reference,
        //     'other_phone' => $request->number,
        //     'app_url' => env("FLEXPAY_GATEWAY_CARD"),
        // ];

        // if ($request->toggleOption === "mobile") {

        //     $datas = [
        //         'type' => $request->toggleOption == 'mobile' ? 1 : 2,
        //         // 'provider_reference' => $request->montant,
        //         'phone' => $request->number,
        //         'chanel' => $request->toggleOption,
        //         // 'description' => $request->montant,
        //         'offrande_id' => $request->offrande_id,
        //         'currency' => $request->monaie,
        //         'reference' => $reference,
        //         'fullname' => $request->fullname,
        //         'numberPhone' => $request->phoneNumber,
        //         'pays' => $request->country,
        //     ];
        //     $init = Transaction::create($datas);

        //     if ($init) {
        //         // Create response by sending request to FlexPay
        //         $data = array(
        //             'merchant' => env("FLEXPAY_MARCHAND"),
        //             'type' => $inputs["transaction_type_id"],
        //             'phone' => $inputs["other_phone"],
        //             'reference' => $inputs["reference"],
        //             'amount' => $inputs['amount'],
        //             'currency' => $inputs['currency'],
        //             'callbackUrl' => env('APP_URL') . 'storeTransaction',
        //         );
        //         $data = json_encode($data);
        //         $ch = curl_init();

        //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //         curl_setopt($ch, CURLOPT_URL, env("FLEXPAY_GATEWAY_MOBILE"));
        //         curl_setopt($ch, CURLOPT_POST, true);
        //         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //             'Content-Type: application/json',
        //             'Authorization: Bearer ' . env('FLEXPAY_API_TOKEN')
        //         ));
        //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        //         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);

        //         $response = curl_exec($ch);

        //         if (curl_errno($ch)) {
        //             return response()->json(
        //                 [
        //                     'reponse' => false,
        //                     'msg' => 'Une erreur lors du traitement de votre requête'
        //                 ]
        //             );
        //         } else {
        //             curl_close($ch);

        //             $jsonRes = json_decode($response);
        //             $code = $jsonRes->code; // Push sending status
        //             if ($code != '0') {
        //                 return response()->json(
        //                     [
        //                         'reponse' => false,
        //                         'msg' => 'Impossible de traiter la demande, veuillez réessayer echec envoie du push'
        //                     ]
        //                 );
        //             } else {
        //                 $object = new stdClass();

        //                 $object->result_response = [
        //                     'message' => $jsonRes->message,
        //                     'order_number' => $jsonRes->orderNumber
        //                 ];
        //                 Log::info('retour info détails : ',   $object->result_response);

        //                 // // Register payment, even if FlexPay will
        //                 $payment = transaction::where([['order_number', $jsonRes->orderNumber], ['reference', $inputs["reference"]]])->first();

        //                 if (is_null($payment)) {
        //                     transaction::updateOrCreate(
        //                         ['reference' => $inputs["reference"]],
        //                         [
        //                             'order_number' => $jsonRes->orderNumber,
        //                             'amount' => $inputs['amount'],
        //                             'phone' => $inputs['other_phone'],
        //                             'currency' => $inputs['currency'],
        //                             'type_id' => $inputs["transaction_type_id"],
        //                         ]
        //                     );
        //                     return response()->json(
        //                         [
        //                             'reponse' => true,
        //                             'msg' => 'Veuillez validé votre paiement sur votre téléphone!',
        //                             'type' => "mobile",
        //                             'reference' => $inputs["reference"],
        //                             'orderNumber' => $jsonRes->orderNumber
        //                         ]
        //                     );
        //                 }
        //             }
        //         }
        //     } else {
        //         return response()->json(
        //             [
        //                 'reponse' => false,
        //                 'msg' => 'Erreur initialisation!'
        //             ]
        //         );
        //     }
        // } else {
        //     $body = json_encode(array(
        //         'authorization' => "Bearer " . env('FLEXPAY_API_TOKEN'),
        //         'merchant' => env('FLEXPAY_MARCHAND'),
        //         'reference' => $inputs['reference'],
        //         'amount' => $inputs['amount'],
        //         'currency' => $inputs['currency'],
        //         'description' => "Paiemen d'une contrevention",
        //         'callback_url' => env('APP_URL') . 'storeTransaction',
        //         'approve_url' =>  env('APP_URL') . 'paid/' . $inputs['reference'] . '/' . $inputs['amount'] . '/' . $inputs['currency'] . '/0',
        //         'cancel_url' =>  env('APP_URL') . 'paid/' . $inputs['reference'] . '/' . $inputs['amount'] . '/' . $inputs['currency'] . '/1',
        //         'decline_url' =>  env('APP_URL') . 'paid/' . $inputs['reference'] . '/' . $inputs['amount'] . '/' . $inputs['currency'] . '/2',
        //         'home_url' =>  env('APP_URL') . 'home',
        //     ));

        //     $curl = curl_init(env('FLEXPAY_GATEWAY_CARD'));

        //     curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //     $curlResponse = curl_exec($curl);


        //     $jsonRes = json_decode($curlResponse, true);
        //     $code = $jsonRes['code'];
        //     $message = $jsonRes['message'];

        //     if (!empty($jsonRes['error'])) {
        //         return response()->json(
        //             [
        //                 'reponse' => false,
        //                 'msg' => $jsonRes['message'],
        //                 'type' => "carte",
        //                 'data' => $jsonRes['error']
        //             ]
        //         );
        //     } else {
        //         if ($code != '0') {
        //             return response()->json(
        //                 [
        //                     'reponse' => false,
        //                     'msg' => $jsonRes['message'],
        //                     'type' => "carte",
        //                     'data' => $code
        //                 ]
        //             );
        //         } else {
        //             $url = $jsonRes['url'];
        //             $orderNumber = $jsonRes['orderNumber'];
        //             $object = new stdClass();

        //             $object->result_response = [
        //                 'message' => $message,
        //                 'order_number' => $orderNumber,
        //                 'type' => "carte",
        //                 'url' => $url
        //             ];

        //             // The donation is registered only if the processing succeed
        //             // $contre = contreventionUser::where('reference', $inputs["reference"])->first();
        //             // The donation is registered only if the processing succeed
        //             // $contre->update(['etat' => '1']);

        //             // // Register payment, even if FlexPay will
        //             $payment = transaction::where('order_number', $jsonRes['orderNumber'])->first();

        //             if (is_null($payment)) {
        //                 transaction::updateOrCreate(
        //                     ['reference' => $inputs["reference"]],
        //                     [
        //                         'order_number' => $jsonRes['orderNumber'],
        //                         'amount' => $inputs['amount'],
        //                         'phone' => $request->other_phone,
        //                         'currency' => $inputs['currency'],
        //                         'type_id' => $inputs["transaction_type_id"],
        //                     ]
        //                 );
        //             }
        //             // dd($jsonRes);
        //             return response()->json(
        //                 [
        //                     'reponse' => true,
        //                     'msg' => 'Vous serez rediriger pour payé dans quelques instant!',
        //                     'type' => "carte",
        //                     'reference' => $inputs["reference"],
        //                     'url' => $jsonRes['url']
        //                 ]
        //             );
        //         }
        //     }
        // }
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
        $prix=is_solde2($produit->isSpecialOffer,$produit->prix,(float) $produit->soldePrice);

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
