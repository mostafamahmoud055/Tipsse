<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    public function getEmployees(array $filters = [], int $perPage = 10)
    {
        $query = Employee::with(['merchant', 'branch']);

        // فلترة بالبحث
        if (!empty($filters['search'])) {
            $query->where('name', 'like', "%{$filters['search']}%");
        }
    // ==== فلتر بالـ Status ====
    if (isset($filters['is_active']) && $filters['is_active'] !== '') {
        $query->where('is_active', $filters['is_active']);
    }

    // ==== فلتر بالـ Date ====
    if (!empty($filters['date_pick'])) {
        $query->whereDate('created_at', $filters['date_pick']);
    }
        // ترتيب حسب الاختيار
        if (!empty($filters['sort'])) {
            if ($filters['sort'] === 'newest') {
                $query->latest();
            } elseif ($filters['sort'] === 'oldest') {
                $query->oldest();
            }
        } else {
            $query->latest(); // افتراضي
        }

        return $query->paginate($perPage)->withQueryString();
    }
    public function findById($id)
    {
        return Employee::with(['merchant', 'branch'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Employee::create($data);
    }

    public function update($id, array $data)
    {
        $employee = $this->findById($id);
        $employee->update($data);
        return $employee;
    }

    public function delete($id)
    {
        $employee = $this->findById($id);
        return $employee->delete();
    }
}
