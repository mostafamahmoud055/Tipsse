<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MerchantApplication;
use App\Services\MerchantService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MerchantApplicationController extends Controller
{
    public function __construct(private MerchantService $merchantService) {}

    /**
     * List all merchant applications
     */
    public function index()
    {
        $applications = $this->merchantService->getApplications(15);

        if (request()->routeIs('merchant-application')) {
            $stats = $this->merchantService->getApplicationStats();
            return view('pages.merchant-application', [
                'applications'         => $applications,
                'totalApplications'    => $stats->total,
                'approvedApplications' => $stats->approved,
                'pendingApplications'  => $stats->pending,
                'rejectedApplications' => $stats->rejected,
            ]);
        }

        if (request()->routeIs('contracts')) {
            return view('pages.contracts', [
                'applications' => $applications,
            ]);
        }

        $stats = $this->merchantService->getMerchantBranchStats();
        return view('pages.merchant.merchants', array_merge([
            'applications' => $applications,
        ], $stats));
    }



    public function createNewMerchant(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^\+?\d{7,15}$/',
            'national_id' => 'required|regex:/^\+?\d{7,15}$/',
            'password' => 'required|string|min:6',
            'business_type' => 'required|exists:business_types,name',
            'is_actve' => 'boolean'
        ]);



        $this->merchantService->createNewMerchant($request->all());

        return redirect()->back()->with('success', 'Merchant created and application submitted.');
    }

    /**
     * Show a single merchant application
     */
    public function show(MerchantApplication $application)
    {
        $application->load([
            'user.branches',
            'user.employees'
        ]);

        return view('pages.merchant.show-merchant', compact('application'));
    }


    public function edit(Request $request, MerchantApplication $application)
    {
        $request->validate([
            'name'          => 'nullable|string|max:255',
            'email' => [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($application->user_id),
            ],
            'phone'         => 'nullable|regex:/^\+?\d{7,15}$/',
            'password'      => 'nullable|string|min:6',
            'business_type' => 'required|exists:business_types,name',
            'is_active'     => 'boolean',
            'status'        => 'nullable|in:pending,approved,rejected',
            'national_id' => 'nullable|regex:/^\+?\d{7,15}$/',
            'is_actve' => 'boolean'
        ]);

        $this->merchantService->editMerchant($application, $request->all());

        return redirect()
            ->back()
            ->with('success', 'Merchant updated successfully.');
    }

    /**
     * Delete a merchant application
     */
    public function destroy(String $id)
    {

        $this->merchantService->deleteMerchant($id);

        return redirect()
            ->back()
            ->with('success', 'Merchant deleted successfully.');
    }
}
