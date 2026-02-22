<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use App\Services\BranchService;
use Illuminate\Http\Request;

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
        $branch->load([
            'user',
            'employees',
            'payments' => function($query) {
                $query->with(['employee'])
                    ->orderByDesc('created_at')
                    ->limit(10);
            }
        ]);
        return view('pages.branch.show-branch', compact('branch'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
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
            'user_id' => 'sometimes|exists:users,id',
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

        $user = User::where('name', 'like', "%{$search}%")
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($user);
    }

    public function branches($merchantId)
    {
        $branches = Branch::where('user_id', $merchantId)->get();
        return response()->json($branches);
    }
}
