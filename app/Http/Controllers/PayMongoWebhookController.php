<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PayMongoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayMongoWebhookController extends Controller
{
    protected $paymongo;

    public function __construct(PayMongoService $paymongo)
    {
        $this->paymongo = $paymongo;
    }

    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $signatureHeader = $request->header('Paymongo-Signature');
        $secret = config('services.paymongo.webhook_secret');

        if (!$this->paymongo->verifyWebhookSignature($payload, $signatureHeader, $secret)) {
            Log::warning('PayMongo webhook signature verification failed.');
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        $event = json_decode($payload, true);

        if (!$event || !isset($event['data']['attributes']['status'])) {
            Log::warning('PayMongo webhook invalid payload.');
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $paymentIntentId = $event['data']['id'];
        $status = $event['data']['attributes']['status'];

        $order = Order::where('transaction_id', $paymentIntentId)->first();

        if (!$order) {
            Log::warning("Order not found for payment intent ID: {$paymentIntentId}");
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($status === 'succeeded') {
            $order->payment_status = 'paid';
            $order->save();
        } elseif ($status === 'failed') {
            $order->payment_status = 'failed';
            $order->save();
        }

        return response()->json(['message' => 'Webhook handled'], 200);
    }
}
