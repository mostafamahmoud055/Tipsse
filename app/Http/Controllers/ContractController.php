<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\MerchantApplication;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contractTerms = Contract::all();
        $user = auth()->user()->load('application:id,status,user_id');

        return view('pages.contract', ['user' => $user, 'contractTerms' => $contractTerms]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'condition' => ['required', 'string'],
        ]);

        Contract::create($validated);

        return back()->with('success', 'Contract condition created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'condition' => ['required', 'string'],
        ]);

        $contract->update($validated);

        return back()->with('success', 'Contract condition updated successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MerchantApplication $application)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);


        $application->update([
            'status' => $request->status
        ]);

        return back()->with(
            $request->status == 'approved' ? 'success' : 'warning',
            $request->status == 'approved'
                ? 'Contract accepted successfully'
                : 'Contract rejected successfully'
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();

        return back()->with('success', 'Contract condition deleted successfully');
    }

    public function downloadPDF()
    {
        // جلب البنود الخاصة بالعقد للـ Merchant
        $user = auth()->user();
        $contractTerms = Contract::all();

        $pdf = Pdf::loadView('contracts.pdf', [
            'merchant' => $user,
            'contractTerms' => $contractTerms,
        ]);

        return $pdf->download('merchant_contract_' . $user->id . '.pdf');
    }
}
