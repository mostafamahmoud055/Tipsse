<?php

namespace App\Services\Payments;

class StripeGateway
{
    protected string $clientId;
    protected string $secret;
    public function __construct(protected array $config = [])
    {
        $this->clientId = config('services.stripe.client_id');

        $this->secret = config('services.stripe.client_secret');
    }

    public function pay(array $data): array
    {
        return [
            'status' => 'success',
            'amount' => $data['amount'],
            'employee_id' => $data['employee_id'],
            'payment_method' => 'stripe',
            'transaction_id' => uniqid('stripe_'),
        ];
    }
}
