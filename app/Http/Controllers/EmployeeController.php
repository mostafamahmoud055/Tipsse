<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

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
        $employee->load(['user', 'branch']); // جلب بيانات الفرع أيضاً

        // رابط QR Code يشير لصفحة الدفع
        $renderer = new ImageRenderer(
            new RendererStyle(200), // حجم صغير للعرض
            new SvgImageBackEnd()   // صيغة SVG
        );
        $writer = new Writer($renderer);

        $qrCodeSvg = $writer->writeString(route('employees.pay', $employee->id));

        return view('pages.employee.show-employee', compact('employee', 'qrCodeSvg'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'national_id' => 'required|string|max:50',
            'user_id' => 'required|exists:users,id',
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
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')->ignore($employee->id),
            ],
            'phone' => 'nullable|string|max:20',
            'national_id' => 'nullable|string|max:50',
            'user_id' => 'required|exists:users,id',
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
    public function generateQr($id)
    {
        $employee = $this->service->findById($id);

        // رابط QR Code يشير لصفحة الدفع
        $renderer = new ImageRenderer(
            new RendererStyle(300), // حجم أكبر للتحميل
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);

        $qrCodeSvg = $writer->writeString(route('employees.pay', $employee->id));

        return response($qrCodeSvg, 200)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'inline; filename="employee-' . $employee->id . '-qrcode.svg"');
    }


    public function paymentPage(Employee $employee)
    {
        $employee->load(['user', 'branch']);
        return view('pages.employee.payment', compact('employee'));
    }
}
