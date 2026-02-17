<?php

namespace Database\Factories;

use App\Models\User;
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
            'remember_token' => Str::random(10),
            'role' => 'merchant_owner',
            'password' => Hash::make('password123'),
            'phone' => $data['phone'] ?? null,
            'business_type' => 'service',
            'is_active' => $data['is_active'] ?? true,
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

            MerchantApplication::factory()->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
