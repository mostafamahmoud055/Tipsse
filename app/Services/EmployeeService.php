<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    public function getEmployees(array $filters = [], int $perPage = 10)
    {
        $query = Employee::with(['user', 'branch']);

        $user = auth()->user();

        if ($user->role === 'merchant_owner') {
            $query->where('user_id', $user->id);
        }

        if (!empty($filters['search'])) {
            $query->where('name', 'like', "%{$filters['search']}%");
        }
        if (isset($filters['is_active']) && $filters['is_active'] !== '') {
            $query->where('is_active', $filters['is_active']);
        }

        if (!empty($filters['date_pick'])) {
            $query->whereDate('created_at', $filters['date_pick']);
        }
        if (!empty($filters['sort'])) {
            if ($filters['sort'] === 'newest') {
                $query->latest();
            } elseif ($filters['sort'] === 'oldest') {
                $query->oldest();
            }
        } else {
            $query->latest();
        }

        return $query->paginate($perPage)->withQueryString();
    }
    public function findById($id)
    {
        return Employee::with(['user', 'branch'])->findOrFail($id);
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
