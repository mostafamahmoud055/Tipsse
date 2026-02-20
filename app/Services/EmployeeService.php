<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        return DB::transaction(function () use ($data) {
            $imagePath = null;

            if (!empty($data['image'])) {
                $filename = Str::uuid() . '.' . $data['image']->getClientOriginalExtension();

                $imagePath = $data['image']->storeAs(
                    'employees',
                    $filename,
                    'local'
                );
            }
            $data['image'] = $imagePath;
            return Employee::create($data);
        });
    }

    public function update(Employee $employee, array $data)
    {
        return DB::transaction(function () use ($employee, $data) {

            if (!empty($data['image'])) {
                if ($employee->image && Storage::disk('local')->exists($employee->image)) {
                    Storage::disk('local')->delete($employee->image);
                }

                $filename = Str::uuid() . '.' . $data['image']->getClientOriginalExtension();
                $imagePath = $data['image']->storeAs('employees', $filename, 'local');

                $employee->image = $imagePath;
            }

            if (!empty($data['remove_image']) && $data['remove_image']) {
                if ($employee->image && Storage::disk('local')->exists($employee->image)) {
                    Storage::disk('local')->delete($employee->image);
                }
                $employee->image = null;
            }

            $employee->name = $data['name'];
            $employee->email = $data['email'];
            $employee->phone = $data['phone'] ?? $employee->phone;
            $employee->national_id = $data['national_id'] ?? $employee->national_id;
            $employee->branch_id = $data['branch_id'];
            $employee->is_active = $data['is_active'] ?? $employee->is_active;

            $employee->save();
            $employee->refresh(); // Refresh the employee model to get updated values

            return $employee;
        });
    }

    public function delete(Employee $employee)
    {
        DB::transaction(function () use ($employee) {
            $employee->delete();
        });
    }
}
