<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Merchant>
 */
class MerchantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'business_type' => $this->faker->randomElement([
                'retail',
                'restaurant',
                'services',
                'online'
            ]),
            'is_active' => $this->faker->boolean(70),
        ];
    }
}
