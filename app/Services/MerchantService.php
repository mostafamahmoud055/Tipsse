<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\MerchantApplication;
use Illuminate\Support\Facades\Hash;

class MerchantService
{

    private function baseApplicationQuery()
    {
        $query = MerchantApplication::query();

        $user = auth()->user();

        if ($user->role === 'merchant_owner') {
            $query->where('user_id', $user->id);
        }

        return $query;
    }

    public function getApplications(int $perPage = 15)
    {
        $query = $this->baseApplicationQuery()->with(['user']);

        $query
            ->when(request('search'), function ($q, $search) {
                $q->whereHas(
                    'user',
                    fn($uq) =>
                    $uq->where('name', 'like', "%{$search}%")
                );
            })

            ->when(
                request('status'),
                fn($q, $status) =>
                $q->where('status', $status)
            )

            ->when(!is_null(request('is_active')), function ($q) {
                $q->whereHas(
                    'user',
                    fn($mq) =>
                    $mq->where('is_active', request('is_active'))
                );
            })

            ->when(
                request('date_pick'),
                fn($q, $date) =>
                $q->whereDate('created_at', $date)
            )

            ->when(
                request('sort') === 'oldest',
                fn($q) => $q->orderBy('created_at', 'asc'),
                fn($q) => $q->orderBy('created_at', 'desc')
            );


        return $query->paginate($perPage)->withQueryString();
    }


    public function getApplicationStats()
    {
        return $this->baseApplicationQuery()
            ->selectRaw("COUNT(*) as total,
            SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
        ")->first();
    }

    public function getMerchantBranchStats()
    {
        $user = auth()->user();

        $merchantQuery = User::query();
        $branchQuery   = Branch::query();

        if ($user->role === 'merchant_owner') {
            $merchantQuery->where('id', $user->id);
            $branchQuery->where('user_id', $user->id);
        }

        $merchantStats = $merchantQuery->selectRaw("COUNT(*) as total")->first();

        $branchStats = $branchQuery->selectRaw("
            SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active,
            SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as inactive
        ")->first();

        return [
            'totalMerchants'   => $merchantStats->total,
            'activeBranches'   => $branchStats->active,
            'inactiveBranches' => $branchStats->inactive,
        ];
    }


    private function generateApplicationNumber(): string
    {
        return 'APP-' . strtoupper(Str::random(10));
    }

    public function createNewMerchant(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'merchant_owner',
                'phone' => $data['phone'] ?? null,
                'business_type' => $data['business_type'] ?? 'service',
                'national_id' => $data['national_id'] ?? null,
                'is_active' => $data['is_active'] ?? true,
            ]);



            MerchantApplication::create([
                'user_id' => $user->id,
                'user_id' => $user->id,
                'application_number' => $this->generateApplicationNumber(),
                'status' => 'pending',
            ]);
            return $user;
        });
    }

    public function editMerchant(MerchantApplication $application, array $data): MerchantApplication
    {
        return DB::transaction(function () use ($application, $data) {

            $user = $application->user;

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
                $user->update($merchantData);
            }

            return $application->refresh();
        });
    }


    public function deleteMerchant($id)
    {
        return User::find($id)->delete();
    }
}
