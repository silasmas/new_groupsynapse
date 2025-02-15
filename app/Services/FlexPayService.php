<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FlexPayService
{
    protected $baseUrl;
    protected $merchant;
    protected $token;

    protected $apiUrl;
    protected $checkUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.flexpay.base_url');
        $this->merchant = config('services.flexpay.merchant');
        $this->token = config('services.flexpay.token');

        $this->apiUrl = env('FLEXPAY_GATEWAY_CARD');
        $this->checkUrl = env('FLEXPAY_GATEWAY_CHECK');
    }

    /**
     * Envoie une requête de paiement à FlexPay.
     */
    public function requestPayment($phone, $amount, $currency, $reference, $callbackUrl, $type = 1)
    {
        $url = "{$this->baseUrl}/paymentService";


        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->token}",
            'Content-Type' => 'application/json',
        ])->post($url, [
            'merchant' => $this->merchant,
            'type' => $type,
            'phone' => $phone,
            'reference' => $reference,
            'amount' => $amount,
            'currency' => $currency,
            'callbackUrl' => $callbackUrl,
        ]);

        return $response->json();
    }
    public function initiatePayment1($amount, $currency, $reference, $description)
    {
        $data = [
            'merchant' => $this->merchant,
            'reference' => $reference,
            'amount' => 50,
            'currency' => "USD",
            'language' => 'fr',
            'description' => $description,
            'callback_url' => env('APP_URL') . 'storeTransaction',
            'approve_url' =>  env('APP_URL') . 'paid/' . $reference . '/' . $amount . '/' . $currency . '/success',
            'cancel_url' =>  env('APP_URL') . 'paid/' . $reference . '/' . $amount . '/' . $currency . '/cancel',
            'decline_url' =>  env('APP_URL') . 'paid/' . $reference . '/' . $amount . '/' . $currency . '/decline',
            'home_url' =>  env('APP_URL') . 'home',
        ];
        //  dd($data);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJcL2xvZ2luIiwicm9sZXMiOlsiTUVSQ0hBTlQiXSwiZXhwIjoxNzkxOTk0Njg5LCJzdWIiOiJkMWQzNmEyZWYwNDE1NjA1ZTBkODkzZDZjZDk3OGQxZiJ9.B6JZxeFpJW8SN0sQRxMIeWe1c9qfCFkEDE7_lz4Yh3U"
        ])->post($this->apiUrl, $data);

        return $response->json();
    }

    public function initiatePayment($amount, $currency, $reference, $description)
    {
        $token = $this->token; // Récupération du token depuis l'ENV
        $merchant = $this->merchant;  // Récupération du code marchand
        $apiUrl = $this->apiUrl;     // URL de l'API FlexPay

        $body = json_encode([
            'authorization' => "Bearer $token",
            'merchant' => $merchant,
            'reference' => $reference,
            'amount' => $amount,
            'currency' => $currency,
            'description' => $description,
            'callback_url' => env('APP_URL') . '/storeTransaction',
            'approve_url' => env('APP_URL') . "/paid/$reference/$amount/$currency/success",
            'cancel_url' => env('APP_URL') . "/paid/$reference/$amount/$currency/cancel",
            'decline_url' => env('APP_URL') . "/paid/$reference/$amount/$currency/decline",
            'home_url' =>  env('APP_URL') . 'home',
        ]);

        // Initialisation de cURL
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

        // Exécution de la requête
        $curlResponse = curl_exec($curl);
        curl_close($curl);

        // Décodage de la réponse JSON
        $json = json_decode($curlResponse, true);
        // dd($json);
        if (isset($json['code']) && $json['code'] === "0") {
            // Redirection vers la page de paiement FlexPay
            return ["rep"=>true, "url"=>$json['url'],"orderNumber"=>$json['orderNumber'],"data"=>$json];
        }else{
            return ["rep"=>false, "message"=>$json['message'],'error' => 'Échec de l’initiation du paiement : '];
            // return back()->withErrors(['error' => 'Échec de l’initiation du paiement : ' . ($json['message'] ?? 'Erreur inconnue')]);
        }

    }

    /**
     * Vérifie l'état d'une transaction.
     */
    public function checkTransaction($orderNumber)
    {
        $url = "{$this->baseUrl}/check/{$orderNumber}";

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->token}",
        ])->get($url);

        return $response->json();
    }
}
