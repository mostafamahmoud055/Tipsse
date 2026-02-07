<?php

namespace App\Http\Controllers;

use App\Models\BusinessType;
use Illuminate\Http\Request;

class BusinessTypeController extends Controller
{
    public function index()
    {
        $types = BusinessType::all();
        return view('pages.business-types', compact('types'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:business_types,name',
        ]);

        BusinessType::create($request->all());

        return redirect()->route('business_types.index')->with('success', 'Business Type created successfully.');
    }

    public function edit(BusinessType $businessType)
    {
        //
    }

    public function update(Request $request, BusinessType $businessType)
    {
        $request->validate([
            'name' => 'required|string|unique:business_types,name,' . $businessType->id,
        ]);

        $businessType->update($request->all());

        return redirect()->route('business_types.index')->with('success', 'Business Type updated successfully.');
    }

    public function destroy(BusinessType $businessType)
    {
        $businessType->delete();

        return redirect()->route('business_types.index')->with('success', 'Business Type deleted successfully.');
    }
}
