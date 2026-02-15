<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $service;

    public function __construct(EmployeeService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'sort', 'is_active', 'date_pick']);
        $employees = $this->service->getEmployees($filters, 10);

        return view('pages.employee.employees', compact('employees'));
    }

    public function show(Employee $employee)
    {

        $employee->load(['merchant']);
        return view('pages.employee.show-employee', compact('employee'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'national_id' => 'required|string|max:50',
            'merchant_id' => 'required|exists:merchants,id',
            'branch_id' => 'required|exists:branches,id',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $data['is_active'] ?? false;

        $this->service->create($data);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully');
    }

    // صفحة تعديل موظف
    public function edit($id)
    {
        $employee = $this->service->findById($id);
        return view('employees.edit', compact('employee'));
    }

    // تحديث بيانات الموظف
    public function update(Request $request, $id)
    {
        $employee = $this->service->findById($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'nullable|string|max:20',
            'national_id' => 'nullable|string|max:50',
            'merchant_id' => 'required|exists:merchants,id',
            'branch_id' => 'required|exists:branches,id',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $data['is_active'] ?? false;

        $this->service->update($id, $data);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully');
    }
}
