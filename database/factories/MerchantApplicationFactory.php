<?php

namespace Database\Factories;

use App\Models\MerchantApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MerchantApplication>
 */
class MerchantApplicationFactory extends Factory
{
    protected $model = MerchantApplication::class;

    public function definition(): array
    {
        return [
            'application_number' => 'APP-' . now()->format('Ymd') . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'status' => 'pending',
        ];
    }
}