<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Http;

class PayMongoService
{
    protected $secretKey;
    protected $baseUrl = 'https://api.paymongo.com/v1';

    public function __construct()
    {
        $this->secretKey = config('services.paymongo.secret_key');
    }

    protected function headers()
    {
        return [
            'Authorization' => 'Basic ' . base64_encode($this->secretKey . ':'),
            'Content-Type' => 'application/json',
        ];
    }

    public function createPaymentIntent($amount, $paymentMethodTypes = ['gcash'])
    {
        \Log::info('Creating PayMongo payment intent', ['amount' => $amount, 'payment_method_types' => $paymentMethodTypes]);

        $response = Http::withHeaders($this->headers())->post("{$this->baseUrl}/payment_intents", [
            'data' => [
                'attributes' => [
                    'amount' => $amount,
                    'payment_method_allowed' => $paymentMethodTypes,
                    'currency' => 'PHP',
                ],
            ],
        ]);

        \Log::info('PayMongo payment intent response', ['response' => $response->json()]);

        return $response->json();
    }

    public function createPaymentMethod($type, $details)
    {
        Log::info('Creating payment method payload', ['type' => $type, 'details' => $details]);

        $response = Http::withHeaders($this->headers())->post("{$this->baseUrl}/payment_methods", [
            'data' => [
                'attributes' => array_merge(['type' => $type], $details),
            ],
        ]);
    
        return $response->json();
    }
    
    
    

    public function attachPaymentMethodToIntent($paymentIntentId, $paymentMethodId)
    {
        $response = Http::withHeaders($this->headers())->post("{$this->baseUrl}/payment_intents/{$paymentIntentId}/attach", [
            'data' => [
                'attributes' => [
                    'payment_method' => $paymentMethodId,
                ],
            ],
        ]);

        return $response->json();
    }

    public function verifyWebhookSignature($payload, $signatureHeader, $secret)
    {
        $signatures = explode(',', $signatureHeader);
        $valid = false;

        foreach ($signatures as $signature) {
            if (hash_equals(hash_hmac('sha256', $payload, $secret), $signature)) {
                $valid = true;
                break;
            }
        }

        return $valid;
    }
}
