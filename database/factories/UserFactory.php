<?php

namespace Database\Factories;

use App\Models\Merchant;
use Illuminate\Support\Str;
use App\Models\MerchantApplication;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'national_id' => $this->faker->numerify('##############'),
            'role' => 'merchant_owner',
            'password' => Hash::make('password123'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }


    public function superAdmin(): static
    {
        return $this->state(fn() => [
            'role' => 'super_admin',
        ]);
    }

    public function withMerchantApplication(): static
    {
        return $this->afterCreating(function ($user) {

            $merchant = Merchant::factory()->create([
                'user_id' => $user->id,
                'name' => $user->name,
            ]);

            MerchantApplication::factory()->create([
                'user_id' => $user->id,
                'merchant_id' => $merchant->id,
            ]);
        });
    }
}
