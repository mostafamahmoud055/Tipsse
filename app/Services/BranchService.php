<?php

namespace App\Services;

use App\Models\Branch;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BranchService
{

    public function getBranches(array $filters = [], int $perPage = 15)
    {
        $query = Branch::with('user');

        $user = auth()->user();

        if ($user->role === 'merchant_owner') {
            $query->where('user_id', $user->id);
        }

        // ==== Search ====
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($mq) use ($search) {
                        $mq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // ==== Status ====
        if (isset($filters['is_active']) && $filters['is_active'] !== '') {
            $query->where('is_active', (int)$filters['is_active']);
        }

        // ==== Date ====
        if (!empty($filters['date_pick'])) {
            $query->whereDate('created_at', $filters['date_pick']);
        }

        // ==== Sorting ====
        $sort = $filters['sort'] ?? 'newest';
        $query->orderBy('created_at', $sort === 'oldest' ? 'asc' : 'desc');

        return $query->paginate($perPage)->withQueryString();
    }




    /**
     * Create new branch
     */
    public function create(array $data): Branch
    {
        return DB::transaction(function () use ($data) {

            $imagePath = null;

            if (!empty($data['image'])) {
                $filename = Str::uuid() . '.' . $data['image']->getClientOriginalExtension();

                $imagePath = $data['image']->storeAs(
                    'branches',
                    $filename,
                    'local'
                );
            }

            return Branch::create([
                'user_id' => $data['user_id'],
                'name'        => $data['name'],
                'is_active'   => $data['is_active'] ?? 0,
                'image'       => $imagePath,
            ]);
        });
    }

    /**
     * Update branch
     */
    public function update(Branch $branch, array $data)
    {
        return DB::transaction(function () use ($branch, $data) {

            if (!empty($data['image'])) {
                if ($branch->image && Storage::disk('local')->exists($branch->image)) {
                    Storage::disk('local')->delete($branch->image);
                }

                $filename = Str::uuid() . '.' . $data['image']->getClientOriginalExtension();
                $imagePath = $data['image']->storeAs('branches', $filename, 'local');

                $branch->image = $imagePath;
            }

            if (!empty($data['remove_image']) && $data['remove_image']) {
                if ($branch->image && Storage::disk('local')->exists($branch->image)) {
                    Storage::disk('local')->delete($branch->image);
                }
                $branch->image = null;
            }

            $branch->name      = $data['name'];
            $branch->is_active = $data['is_active'] ?? $branch->is_active;

            $branch->save();

            return $branch;
        });
    }


    /**
     * Delete branch
     */
    public function delete(Branch $branch): void
    {
        DB::transaction(function () use ($branch) {
            $branch->delete();
        });
    }
}
