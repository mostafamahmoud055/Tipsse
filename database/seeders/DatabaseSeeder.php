<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Database\Seeders\ContractSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

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
        $this->call([
            MerchantSeeder::class,
            ContractSeeder::class,
        ]);
        User::factory()
            ->count(100)
            ->withMerchantApplication()
            ->create();
    }
}
