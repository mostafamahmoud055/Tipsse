<?php

namespace App\Http\Controllers;

use App\Models\BusinessType;
use App\Services\BusinessTypeService;
use Illuminate\Http\Request;

class BusinessTypeController extends Controller
{
    protected BusinessTypeService $service;

    public function __construct(BusinessTypeService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'sort']);
        $types = $this->service->getBusinessTypes($filters, 15);

        return view('pages.business-types', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:business_types,name',
        ]);

        $this->service->createBusinessType($request->all());

        return redirect()->route('business_types.index')
            ->with('success', 'Business Type created successfully.');
    }

    public function update(Request $request, BusinessType $businessType)
    {
        $request->validate([
            'name' => 'required|string|unique:business_types,name,' . $businessType->id,
        ]);

        $this->service->updateBusinessType($businessType, $request->all());

        return redirect()->route('business_types.index')
            ->with('success', 'Business Type updated successfully.');
    }

    public function destroy(String $id)
    {
        $this->service->deleteBusinessType($id);

        return redirect()->route('business_types.index')
            ->with('success', 'Business Type deleted successfully.');
    }
}
