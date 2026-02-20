<?php

namespace App\Services\Payments;

class PayPalGateway
{
    protected string $clientId;
    protected string $secret;

    public function __construct(protected array $config = [])
    {
        $this->clientId = config('services.paypal.client_id');

        $this->secret = config('services.paypal.client_secret');
    }

    public function pay(array $data): array
    {
        return [
            'status' => 'success',
            'amount' => $data['amount'],
            'employee_id' => $data['employee_id'],
            'payment_method' => 'paypal',
            'transaction_id' => uniqid('paypal_'),
        ];
    }
}
