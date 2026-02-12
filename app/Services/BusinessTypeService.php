<?php

namespace App\Services;

use App\Models\BusinessType;
use Illuminate\Pagination\LengthAwarePaginator;

class BusinessTypeService
{
    /**
     * استرجاع أنواع الأعمال مع الفلاتر والـ pagination
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getBusinessTypes(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = BusinessType::query();

        // ==== فلتر بالبحث ====
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('name', 'like', "%{$search}%");
        }

        // ==== فلتر بالترتيب ====
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

    /**
     * إنشاء BusinessType جديد
     */
    public function createBusinessType(array $data): BusinessType
    {
        return BusinessType::create($data);
    }

    /**
     * تحديث BusinessType موجود
     */
    public function updateBusinessType(BusinessType $businessType, array $data): BusinessType
    {
        $businessType->update($data);
        return $businessType;
    }

    /**
     * حذف BusinessType
     */
    public function deleteBusinessType($id)
    {
        return BusinessType::find($id)->delete();
    }
}
