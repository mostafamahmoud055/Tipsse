<?php

namespace App\Services;

use App\Models\BusinessType;
use Illuminate\Pagination\LengthAwarePaginator;

class BusinessTypeService
{
    /**
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getBusinessTypes(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = BusinessType::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('name', 'like', "%{$search}%");
        }

        if (!empty($filters['sort'])) {
            if ($filters['sort'] === 'newest') {
                $query->orderBy('created_at', 'desc');
            } elseif ($filters['sort'] === 'oldest') {
                $query->orderBy('created_at', 'asc');
            }
        } else {
            $query->orderBy('created_at', 'desc'); // ترتيب افتراضي
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function createBusinessType(array $data): BusinessType
    {
        return BusinessType::create($data);
    }

    public function updateBusinessType(BusinessType $businessType, array $data): BusinessType
    {
        $businessType->update($data);
        return $businessType;
    }

    public function deleteBusinessType($id)
    {
        return BusinessType::find($id)->delete();
    }
}
