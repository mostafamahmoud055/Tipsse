<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BusinessType;
use App\Models\Employee;
use App\Models\Merchant;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        $user = auth()->user();
        $merchantId = $user->merchant?->user_id;

        /*
    |--------------------------------------------------------------------------
    | Base Queries
    |--------------------------------------------------------------------------
    */

        $merchantsQuery = Merchant::query();
        $branchesQuery  = Branch::query();
        $employeesQuery = Employee::query();

        // ✅ لو Merchant → يشوف بياناته بس
        if ($user->role === 'merchant_owner') {

            $merchantsQuery->where('user_id', $merchantId);

            $branchesQuery->where('merchant_id', $merchantId);

            $employeesQuery->whereHas('branch', function ($q) use ($merchantId) {
                $q->where('merchant_id', $merchantId);
            });
        }

        /*
    |--------------------------------------------------------------------------
    | Recently Added Employees
    |--------------------------------------------------------------------------
    */

        $recentEmployees = Employee::with('branch')
            ->when($user->role === 'merchant_owner', function ($q) use ($merchantId) {
                $q->whereHas('branch', function ($b) use ($merchantId) {
                    $b->where('merchant_id', $merchantId);
                });
            })
            ->latest()
            ->take(10)
            ->get();

        return view('pages.dashboard.home', [

            /*
        |--------------------------------------------------------------------------
        | Totals
        |--------------------------------------------------------------------------
        */

            'totalMerchants'     => $merchantsQuery->count(),
            'totalBusinessTypes' => BusinessType::count(),
            'totalBranches'      => $branchesQuery->count(),
            'totalEmployees'     => $employeesQuery->count(),
            'totalTips'          => 0,


            /*
        |--------------------------------------------------------------------------
        | This Month Statistics
        |--------------------------------------------------------------------------
        */

            'merchantsThisMonth' => (clone $merchantsQuery)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count(),

            'branchesThisMonth' => (clone $branchesQuery)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count(),

            'employeesThisMonth' => (clone $employeesQuery)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count(),

            /*
        |--------------------------------------------------------------------------
        | Recent Data
        |--------------------------------------------------------------------------
        */

            'recentEmployees' => $recentEmployees,
        ]);
    }
}
