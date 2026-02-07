<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MerchantApplication;
use App\Services\MerchantService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MerchantApplicationController extends Controller
{
    public function __construct(private MerchantService $merchantService) {}

    /**
     * List all merchant applications
     */
public function index()
{
    $applications = MerchantApplication::with(['user', 'merchant'])
        ->paginate(15);

    if (request()->routeIs('merchant-application')) {
        return view('pages.merchant-application', compact('applications'));
    }

    return view('pages.merchant.merchants', compact('applications'));
}

    public function createNewMerchant(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^\+?\d{7,15}$/',
            'password' => 'required|string|min:6',
            'business_type' => 'required|string',
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
        $application->load(['user', 'merchant']);
        return view('pages.merchant.show-merchant', compact('application'));
    }

    /**
     * Apply for a merchant (admin creates merchant & application)
     */
    public function apply(Request $request)
    {
        $request->validate([
            'user_id'       => ['required', 'exists:users,id'],
            'business_name' => ['required', 'string', 'max:255'],
            'phone'         => ['nullable', 'string', 'max:20'],
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);

        try {
            $application = $this->merchantService->apply($request->only(['business_name', 'phone']), $user);

            return redirect()->back()->with('success', 'Merchant application created successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }

    /**
     * Approve merchant application
     */
    public function approve(MerchantApplication $application)
    {
        $this->merchantService->approve($application);

        return redirect()
            ->back()
            ->with('success', 'Merchant application approved successfully.');
    }

    /**
     * Reject merchant application
     */
    public function reject(Request $request, MerchantApplication $application)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'min:5'],
        ]);

        $this->merchantService->reject($application, $request->rejection_reason);

        return redirect()
            ->back()
            ->with('success', 'Merchant application rejected.');
    }

    public function edit(Request $request, MerchantApplication $application)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $application->user_id,
            'phone'         => 'nullable|regex:/^\+?\d{7,15}$/',
            'password'      => 'nullable|string|min:6',
            'business_type' => 'required|string',
            'is_active'     => 'boolean',
            'status'        => 'nullable|in:pending,approved,rejected',
        ]);

        $this->merchantService->editMerchant($application, $request->all());

        return redirect()
            ->back()
            ->with('success', 'Merchant updated successfully.');
    }
}
