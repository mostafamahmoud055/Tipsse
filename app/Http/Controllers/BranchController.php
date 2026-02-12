<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Services\BranchService;

class BranchController extends Controller
{
    public function __construct(
        protected BranchService $branchService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'sort', 'is_active', 'date_pick']);
        $branches = $this->branchService->getBranches($filters, 15);

        return view('pages.branch.branches', compact('branches'));
    }

    public function show(Branch $branch)
    {

        $branch->load(['merchant']);
        return view('pages.branch.show-branch', compact('branch'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'merchant_id' => 'required|exists:merchants,id',
            'name'        => 'required|string|max:255',
            'is_active'      => 'required|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $this->branchService->create($request->all());

        return back()->with('success', 'Branch created successfully.');
    }

    public function update(Request $request, Branch $branch)
    {


        $request->validate([
            'merchant_id' => 'sometimes|exists:merchants,id',
            'name'        => 'required|string|max:255',
            'is_active'   => 'boolean',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_image' => 'nullable|boolean'
        ]);

        $this->branchService->update($branch, $request->all());

        return back()->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch)
    {
        $this->branchService->delete($branch);

        return back()->with('success', 'Branch deleted successfully.');
    }

    public function searchOwners(Request $request)
    {
        $search = $request->get('q');

        $merchant = Merchant::where('name', 'like', "%{$search}%")
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($merchant);
    }

    public function branches($merchantId)
    {
        $branches = Branch::where('merchant_id', $merchantId)->get();
        return response()->json($branches);
    }
}
