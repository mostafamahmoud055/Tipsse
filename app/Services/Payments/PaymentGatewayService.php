<?php

namespace App\Services\Payments;

use App\Enums\PaymentGatewayEnum;
use Illuminate\Support\Facades\Cache;
use App\Services\Payments\PayPalGateway;
use App\Services\Payments\StripeGateway;
use App\Services\Payments\CreditCardGateway;

class PaymentGatewayService
{


    public function getGateway(string $gateway)
    {
        $gatewayEnum = PaymentGatewayEnum::from($gateway);

        $gatewayModel = Cache::remember(
            "payment_gateway_{$gatewayEnum->value}",
            now()->addMinutes(30),
            fn() => $gatewayEnum,
        );

        if (!$gatewayModel) {
            return ["error" => "Gateway not found", "status" => 404];
        }

        return match ($gatewayEnum) {
            PaymentGatewayEnum::PAYPAL => new PayPalGateway(),
            PaymentGatewayEnum::CREDIT_CARD => new CreditCardGateway(),
            PaymentGatewayEnum::STRIPE => new StripeGateway(),
        };
    }
}
