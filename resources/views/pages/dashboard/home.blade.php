@extends('layouts.app')

@section('content')
    <div class="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-7 my-4">
        @include('layouts.statistics.card-statistics', [
            'title' => 'Merchants',
            'value' => $totalMerchants,
            'icon' => 'images/icons/Vector.png',
            'iconBg' => 'bg-icon-green',
        ])

        @include('layouts.statistics.card-statistics', [
            'title' => 'Business Types',
            'value' => $totalBusinessTypes,
            'icon' => 'images/icons/money_6786436 1.png',
            'iconBg' => 'bg-icon-yellow',
        ])

        @include('layouts.statistics.card-statistics', [
            'title' => 'Branches',
            'value' => $totalBranches,
        ])

        @include('layouts.statistics.card-statistics', [
            'title' => 'Employees',
            'value' => $totalEmployees,
            'icon' => 'images/icons/employee_11803025 1.png',
            'iconBg' => 'bg-icon-green',
        ])

        @include('layouts.statistics.card-statistics', [
            'title' => 'Tips',
            'value' => '$ ' . number_format($totalTips, 2),
            'icon' => 'images/icons/Clip path group.png',
            'iconBg' => 'bg-icon-red',
        ])


    </div>
    <div class="grid grid-cols-3 gap-4 pb-4">

        <div class="col-span-3 md:col-span-2">
            <x-tipssestate.statistics-chart />
        </div>

        <div class="col-span-3 md:col-span-1">
            <x-tipssestate.recent-tips :tips="$recentTips" />
        </div>

    </div>
    <div class="grid grid-cols-3 gap-4 pb-4">

        <div class="col-span-3 md:col-span-2">
           <x-tipssestate.recent-employees :employees="$recentEmployees" />

        </div>
        <div class="col-span-3 md:col-span-1">
            <div class="grid grid-cols-1 gap-4 pb-4">
                <x-tipssestate.card-section title="{{ $merchantsThisMonth }} Merchants This Month" />
                <x-tipssestate.card-section title="{{ $branchesThisMonth }} Branches This Month" />
                <x-tipssestate.card-section title="{{ $employeesThisMonth }} Employees This Month" />

            </div>
        </div>
    </div>
@endsection
