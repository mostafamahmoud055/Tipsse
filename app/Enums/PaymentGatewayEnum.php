<?php

namespace App\Enums;

enum PaymentGatewayEnum: string
{
    case PAYPAL = 'paypal';
    case STRIPE = 'stripe';

    public function label(): string
    {
        return match ($this) {
            self::PAYPAL => 'PayPal',
            self::STRIPE => 'Stripe',
        };
    }

    public static function isValid(string $value): bool
    {
        return self::tryFrom($value) !== null;
    }
        public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
