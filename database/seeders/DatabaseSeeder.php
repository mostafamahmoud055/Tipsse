<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin user',
            'email' => 'admin@mail.com',
            'password' => Hash::make('123456'),
            'role' => 'super_admin',
            'email_verified_at' => Carbon::now(),
        ]);
        User::create([
            'name' => 'merchant user',
            'email' => 'merchant@mail.com',
            'password' => Hash::make('123456'),
            'role' => 'merchant_owner',
            'email_verified_at' => Carbon::now(),
        ]);
        User::factory()
            ->count(100)
            ->withMerchantApplication()
            ->create();
    }
}
