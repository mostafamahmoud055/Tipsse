<?php

namespace App\Services;

use App\Models\User;
use App\Models\Branch;
use App\Models\Merchant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\MerchantApplication;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MerchantService
{
    public function getApplications(int $perPage = 15)
    {
        $query = MerchantApplication::with(['user', 'merchant']);

        // ==== فلتر بالبحث عن اسم المستخدم ====
        if ($search = request('search')) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // ==== فلتر بالـ status ====
        if ($status = request('status')) {
            $query->where('status', $status);
        }

        // ==== فلتر بالـ is_active للـ merchant ====
        if (!is_null(request('is_active'))) {
            $query->whereHas('merchant', function ($q) {
                $q->where('is_active', request('is_active'));
            });
        }

        // ==== فلتر بالتاريخ ====
        if ($date = request('date_pick')) {
            $query->whereDate('created_at', $date);
        }

        // ==== فلتر بالترتيب ====
        if ($sort = request('sort')) {
            if ($sort === 'newest') {
                $query->orderBy('created_at', 'desc');
            } elseif ($sort === 'oldest') {
                $query->orderBy('created_at', 'asc');
            }
        } else {
            $query->orderBy('created_at', 'desc'); // ترتيب افتراضي
        }

        return $query->paginate($perPage)->withQueryString();
    }


    public function getApplicationStats()
    {
        return MerchantApplication::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
        ")->first();
    }

    public function getMerchantBranchStats()
    {
        $merchantStats = Merchant::selectRaw("COUNT(*) as total")->first();
        $branchStats   = Branch::selectRaw("
            SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active,
            SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as inactive
        ")->first();

        return [
            'totalMerchants'   => $merchantStats->total,
            'activeBranches'   => $branchStats->active,
            'inactiveBranches' => $branchStats->inactive,
        ];
    }

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
                'name' => $data['name'],
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

            /*
        |--------------------------------------------------------------------------
        | Update User
        |--------------------------------------------------------------------------
        */
            $userData = [];

            if (array_key_exists('name', $data)) {
                $userData['name'] = $data['name'];
            }

            if (array_key_exists('email', $data)) {
                $userData['email'] = $data['email'];
            }

            if (!empty($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }

            if (!empty($userData)) {
                $user->update($userData);
            }

            /*
        |--------------------------------------------------------------------------
        | Update Application
        |--------------------------------------------------------------------------
        */
            if (array_key_exists('status', $data)) {
                $application->update([
                    'status' => $data['status'],
                ]);
            }

            /*
        |--------------------------------------------------------------------------
        | Update Merchant
        |--------------------------------------------------------------------------
        */
            $merchantData = [];

            if (array_key_exists('phone', $data)) {
                $merchantData['phone'] = $data['phone'];
            }

            if (array_key_exists('business_type', $data)) {
                $merchantData['business_type'] = $data['business_type'];
            }

            if (array_key_exists('is_active', $data)) {
                $merchantData['is_active'] = $data['is_active'];
            }

            if (!empty($merchantData)) {
                $merchant->update($merchantData);
            }

            return $application->refresh();
        });
    }

    
    public function deleteApplication($id)
    {
        return MerchantApplication::find($id)->delete();
    }
}
