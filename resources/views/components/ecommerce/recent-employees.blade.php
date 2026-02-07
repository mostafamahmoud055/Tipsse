@props(['employees' => []])

@php
    $defaultEmployees = [
        [
            'id' => 1,
            'name' => 'Tianna Wilderman',
            'branch' => 'Kenton Hickle',
            'date' => '2024 Oct 23',
        ],
        [
            'id' => 2,
            'name' => 'Leora Jast',
            'branch' => 'Dr. Emil Gorczany',
            'date' => '2024 Oct 23',
        ],
        [
            'id' => 3,
            'name' => 'Alberta Marvin',
            'branch' => 'Christy Beer',
            'date' => '2024 Oct 23',
        ],
        [
            'id' => 4,
            'name' => 'Ms. Danielle Larson DVM',
            'branch' => 'Margie Schaefer',
            'date' => '2024 Oct 23',
        ],
        [
            'id' => 5,
            'name' => 'Prof. Lucio Kshlerin MD',
            'branch' => 'Alta Rosenbaum',
            'date' => '2024 Oct 23',
        ],
        [
            'id' => 6,
            'name' => 'Terry Kunze',
            'branch' => 'Mathilde Muller',
            'date' => '2024 Oct 23',
        ],
        [
            'id' => 7,
            'name' => 'Tevin Macejkovic',
            'branch' => 'Mathilde Muller',
            'date' => '2024 Oct 23',
        ],
        [
            'id' => 8,
            'name' => 'Brandyn Dibbert',
            'branch' => 'Heber Hintz',
            'date' => '2024 Oct 23',
        ],
        [
            'id' => 9,
            'name' => 'Dorian Kris I',
            'branch' => 'Prof. Vivien Mitchell Jr.',
            'date' => '2024 Oct 23',
        ],
        [
            'id' => 10,
            'name' => 'Janet Steuber',
            'branch' => 'Nikita Nitzsche V',
            'date' => '',
        ],
    ];

    $employeesList = !empty($employees) ? $employees : $defaultEmployees;
@endphp

<div
    class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
<div class="flex flex-col gap-2 my-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Recently Added Employees</h3>
    </div>

    <div class="flex items-center gap-3">
        <a style="cursor: pointer;" class="text-brand-400 inline-flex items-center py-2.5 font-medium">
            <span class="whitespace-nowrap">See More</span>
            {!! menu_icon('narrow-right-arrow') !!}
        </a>
    </div>
</div>


    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-800">
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 dark:text-gray-300">No.</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Employee</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Branch</th>
                    <th class="py-3 px-4 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employeesList as $employee)
                    <tr class="border-t border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="py-3 px-4 whitespace-nowrap">
                            <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                {{ $employee['id'] }}
                            </p>
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap">
                            <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                {{ $employee['name'] }}
                            </p>
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap">
                            <span class="text-gray-600 text-theme-sm dark:text-gray-400">
                                {{ $employee['branch'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 whitespace-nowrap">
                            <span class="text-gray-600 text-theme-sm dark:text-gray-400">
                                {{ $employee['date'] }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
