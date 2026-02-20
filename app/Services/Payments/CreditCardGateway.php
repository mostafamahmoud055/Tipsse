<?php

namespace App\Services\Payments;

class CreditCardGateway
{
    protected string $clientId;
    protected string $secret;
    public function __construct(protected array $config = [])
    {
        $this->clientId = config('services.credit_card.client_id');

        $this->secret = config('services.credit_card.client_secret');
    }

    public function pay(array $data): array
    {
        return [
            'status' => 'success',
            'amount' => $data['amount'],
            'employee_id' => $data['employee_id'],
            'payment_method' => 'credit_card',
            'transaction_id' => uniqid('cc_'),
        ];
    }
}
