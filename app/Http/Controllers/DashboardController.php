<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BusinessType;
use App\Models\Employee;
use App\Models\Payment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();

        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth   = $now->copy()->endOfMonth();

        $user       = auth()->user();
        $merchantId = $user->id;
        $isMerchant = $user->role === 'merchant_owner';

        /*
    |--------------------------------------------------------------------------
    | Base Queries
    |--------------------------------------------------------------------------
    */

        $merchantsQuery = User::query();
        $branchesQuery  = Branch::query();
        $employeesQuery = Employee::query();

        if ($isMerchant) {
            $merchantsQuery->whereKey($merchantId);

            $branchesQuery->where('user_id', $merchantId);

            $employeesQuery->whereHas(
                'branch',
                fn($q) =>
                $q->where('user_id', $merchantId)
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Recently Added Employees
    |--------------------------------------------------------------------------
    */

        $recentEmployees = Employee::with('branch')
            ->when(
                $isMerchant,
                fn($q) =>
                $q->whereHas(
                    'branch',
                    fn($b) =>
                    $b->where('user_id', $merchantId)
                )
            )
            ->latest()
            ->limit(10)
            ->get();

        /*
    |--------------------------------------------------------------------------
    | Totals
    |--------------------------------------------------------------------------
    */

        $totalMerchants     = $merchantsQuery->count();
        $totalBranches      = $branchesQuery->count();
        $totalEmployees     = $employeesQuery->count();

        /*
    |--------------------------------------------------------------------------
    | This Month Statistics
    |--------------------------------------------------------------------------
    */
        $employeesThisMonth = (clone $employeesQuery)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();
        $merchantsThisMonth = (clone $merchantsQuery)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $branchesThisMonth = (clone $branchesQuery)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        /*
    |--------------------------------------------------------------------------
    | Recently Received Tips
    |--------------------------------------------------------------------------
    */

        $paymentsQuery = Payment::query();

        if ($isMerchant) {
            $paymentsQuery->where('user_id', $merchantId);
        }

        $recentTips = (clone $paymentsQuery)
            ->with(['employee.branch'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $totalTips = (clone $paymentsQuery)
            ->where('status', 'successful')
            ->sum('amount');

        $tipsThisMonth = (clone $paymentsQuery)
            ->where('status', 'successful')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        return view('pages.dashboard.home', compact(
            'totalMerchants',
            'totalBranches',
            'totalEmployees',
            'merchantsThisMonth',
            'branchesThisMonth',
            'employeesThisMonth',
            'recentEmployees',
            'recentTips'
        ) + [
            'totalBusinessTypes' => BusinessType::count(),
            'totalTips' => $totalTips,
            'tipsThisMonth' => $tipsThisMonth,
        ]);
    }
}
