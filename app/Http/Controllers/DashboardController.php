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

        // Recently Added Employees
        $recentEmployees = Employee::with('branch')
            ->latest()
            ->take(10)
            ->get();

        return view('pages.dashboard.home', [

            /*
            |--------------------------------------------------------------------------
            | Totals
            |--------------------------------------------------------------------------
            */

            'totalMerchants'      => Merchant::count(),
            'totalBusinessTypes'  => BusinessType::count(),
            'totalBranches'       => Branch::count(),
            'totalEmployees'      => Employee::count(),
            'totalTips'           => 0,


            /*
            |--------------------------------------------------------------------------
            | This Month Statistics
            |--------------------------------------------------------------------------
            */

            'merchantsThisMonth' => Merchant::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),

            'branchesThisMonth'  => Branch::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),

            'employeesThisMonth' => Employee::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),


            /*
            |--------------------------------------------------------------------------
            | Recent Data
            |--------------------------------------------------------------------------
            */

            'recentEmployees' => $recentEmployees,
        ]);
    }
}
