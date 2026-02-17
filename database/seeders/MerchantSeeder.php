<?php

namespace Database\Seeders;

use App\Models\MerchantApplication;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class MerchantSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            // بيانات التجربة
            $data = [
                'name' => 'Merchant User',
                'email' => 'merchant@mail.com',
                'password' => Hash::make('123456'),
                'phone' => '+201234567890',
                'business_type' => 'service',
                'is_active' => true,
                'national_id' => '1234567890'
            ];

            // إنشاء User
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'role' => 'merchant_owner',
                'remember_token' => Str::random(10),
                'national_id' => $data['national_id'] ?? null,
                'phone' => $data['phone'] ?? null,
                'business_type' => $data['business_type'],
                'is_active' => $data['is_active'] ?? true,
                'email_verified_at' => Carbon::now(),
            ]);


            // Merchant Application
            MerchantApplication::create([
                'user_id' => $user->id,
                'application_number' => 'APP-' . now()->format('YmdHis'),
                'status' => 'pending',
            ]);
        });
    }
}
