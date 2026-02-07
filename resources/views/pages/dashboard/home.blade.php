@extends('layouts.app')

@section('content')
    <div class="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-7 my-4">
        @include('layouts.statistics.card-statistics', [
            'title' => 'Merchants',
            'value' => 202,
            'icon' => 'images/icons/Vector.png',
            'iconBg' => 'bg-icon-green',
            'percentage' => null,
            'period' => null,
        ])
        @include('layouts.statistics.card-statistics', [
            'title' => 'Business Types',
            'value' => 2356,
            'icon' => 'images/icons/money_6786436 1.png',
            'iconBg' => 'bg-icon-yellow',
            'percentage' => null,
            'period' => null,
        ])
        @include('layouts.statistics.card-statistics', [
            'title' => 'Branches',
            'value' => 58458,
            'icon' => null,
            'iconBg' => null,
            'percentage' => '+23%',
            'period' => 'since Last Month',
        ])
        @include('layouts.statistics.card-statistics', [
            'title' => 'Employees',
            'value' => 202,
            'icon' => 'images/icons/employee_11803025 1.png',
            'iconBg' => 'bg-icon-green',
            'percentage' => '+23%',
            'period' => 'since Last Month',
        ])
        @include('layouts.statistics.card-statistics', [
            'title' => 'Tips',
            'value' => '$2935',
            'icon' => 'images/icons/Clip path group.png',
            'iconBg' => 'bg-icon-red',
            'percentage' => null,
            'period' => null,
        ])

    </div>
    <div class="grid grid-cols-3 gap-4 pb-4">

        <div class="col-span-3 md:col-span-2">
            <x-ecommerce.statistics-chart />
        </div>

        <div class="col-span-3 md:col-span-1">
            <x-ecommerce.recent-tips />
        </div>

    </div>
    <div class="grid grid-cols-2 gap-4 pb-4">

        <div class="col-span-2 md:col-span-1">
            <x-ecommerce.recent-employees />
        </div>
        <div class="col-span-2 md:col-span-1">
            <div class="grid grid-cols-1 gap-4 pb-4">
                <x-ecommerce.card-section title="0 Merchents This Month" />
                <x-ecommerce.card-section title="0 Branches This Month" />
                <x-ecommerce.card-section title="0 Employees This Month" />
            </div>
        </div>
    </div>
@endsection
