<?php

namespace App\Services;

use App\Models\User;
use App\Models\Merchant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\MerchantApplication;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MerchantService
{
    /**
     * Apply for merchant (Create merchant + application)
     */
    public function apply(array $data, $user): MerchantApplication
    {
        return DB::transaction(function () use ($data, $user) {

            if ($user->merchant || $user->merchantApplication) {
                throw ValidationException::withMessages([
                    'merchant' => 'You already have an existing merchant application.',
                ]);
            }

            $merchant = Merchant::create([
                'business_name' => $data['business_name'],
                'email'         => $user->email,
                'phone'         => $data['phone'] ?? null,
                'user_id'       => $user->id,
                'is_active'     => false,
            ]);

            return MerchantApplication::create([
                'merchant_id'        => $merchant->id,
                'user_id'            => $user->id,
                'application_number' => $this->generateApplicationNumber(),
                'status'             => 'pending',
            ]);
        });
    }

    /**
     * Approve merchant application
     */
    public function approve(MerchantApplication $application): bool
    {
        return DB::transaction(function () use ($application) {

            if ($application->status !== 'pending') {
                throw new \Exception('Application already processed.');
            }

            $application->update([
                'status' => 'approved',
                'rejection_reason' => null,
            ]);

            $application->merchant->update([
                'is_active' => true,
            ]);

            $application->user->update([
                'status' => 'active',
            ]);

            return true;
        });
    }

    /**
     * Reject merchant application
     */
    public function reject(MerchantApplication $application, string $reason): bool
    {
        return DB::transaction(function () use ($application, $reason) {

            if ($application->status !== 'pending') {
                throw new \Exception('Application already processed.');
            }

            $application->update([
                'status' => 'rejected',
                'rejection_reason' => $reason,
            ]);

            return true;
        });
    }

    /**
     * Generate unique application number
     */
    private function generateApplicationNumber(): string
    {
        return 'APP-' . strtoupper(Str::random(10));
    }

    public function createNewMerchant(array $data): MerchantApplication
    {

        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'merchant_owner',
                'status' => $data['status'] ?? 'inactive',
            ]);

            $merchant = Merchant::create([
                'phone' => $data['phone'] ?? null,
                'user_id' => $user->id,
                'business_type' => $data['business_type'],
                'is_active' => $data['is_active'],
            ]);

            return MerchantApplication::create([
                'merchant_id' => $merchant->id,
                'user_id' => $user->id,
                'application_number' => $this->generateApplicationNumber(),
                'status' => 'pending',
            ]);
        });
    }

    public function editMerchant(MerchantApplication $application, array $data): MerchantApplication
    {
        return DB::transaction(function () use ($application, $data) {

            $user = $application->user;
            $merchant = $application->merchant;

            // Update User
            $user->update([
                'name'   => $data['name'],
                'email'  => $data['email'],
            ]);

            if (!empty($data['password'])) {
                $user->update([
                    'password' => Hash::make($data['password']),
                ]);
            }
            if (!empty($data['status'])) {
                $application->update([
                    'status' => $data['status'],
                ]);
            }
            if (!empty($data['is_active'])) {
                $merchant->update([
                    'is_active'     => $data['is_active'] ?? $merchant->is_active,
                ]);
            }

            // Update Merchant
            $merchant->update([
                'phone'         => $data['phone'] ?? $merchant->phone,
                'business_type' => $data['business_type'],
            ]);

            return $application;
        });
    }
}
