<?php

namespace App\Services\Payments;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Employee;

class StripeGateway
{
    public function __construct()
    {
        // ضع الـ API Key بتاعك هنا أو في .env
        Stripe::setApiKey(config('services.stripe.secret_key'));
    }

    public function pay(string $amount, Employee $employee): array
    {
        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'mode' => 'payment',
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => "Payment for {$employee->name}",
                        ],
                        'unit_amount' => intval($amount * 100), // Stripe بيحسب بالمليم
                    ],
                    'quantity' => 1,
                ]],
                'success_url' => route('payments.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'  => route('payments.cancel'),
            ]);

            // رجع الـ URL عشان تعمل redirect
            return [
                'status' => 'pending',
                'transaction_id' => $session->id,
                'checkout_url' => $session->url,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'failed',
                'error' => $e->getMessage(),
            ];
        }
    }
}
