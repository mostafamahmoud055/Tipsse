@props(['products' => []])

@php
    $defaultProducts = [
        [
            'name' => 'Prof. Lucio Kshlerin MD',
            'variants' => 2,
            'image' => 'images/icons/g3196.png',
            'Desc' => 'Branch: Alta Rosenbaum',
            'status' => 'Delivered',
            'price' => '$120.00',
        ],
        [
            'name' => 'Prof. Lucio Kshlerin MD',
            'variants' => 1,
            'image' => 'images/icons/g3196.png',
            'Desc' => 'Branch: Alta Rosenbaum',
            'status' => 'Pending',
            'price' => '$80.00',
        ],
        [
            'name' => 'Prof. Lucio Kshlerin MD',
            'variants' => 2,
            'image' => 'images/icons/g3196.png',
            'Desc' => 'Branch: Alta Rosenbaum',
            'status' => 'Delivered',
            'price' => '$150.00',
        ],
        [
            'name' =>'Prof. Lucio Kshlerin MD',
            'variants' => 2,
            'image' => 'images/icons/g3196.png',
            'Desc' => 'Branch: Alta Rosenbaum',
            'status' => 'Canceled',
            'price' => '$60.00',
        ],
        [
            'name' => 'Prof. Lucio Kshlerin MD',
            'variants' => 1,
            'image' => 'images/icons/g3196.png',
            'Desc' => 'Branch: Alta Rosenbaum',
            'status' => 'Delivered',
            'price' => '$200.00',
        ],
    ];

    $productsList = !empty($products) ? $products : $defaultProducts;

    // Helper function for status classes
    $getStatusClasses = function ($status) {
        $baseClasses = 'rounded-full px-2 py-0.5 text-theme-xs font-medium';

        return match ($status) {
            'Delivered' => $baseClasses .
                ' bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500',
            'Pending' => $baseClasses . ' bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-orange-400',
            'Canceled' => $baseClasses . ' bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500',
            default => $baseClasses . ' bg-gray-50 text-gray-600 dark:bg-gray-500/15 dark:text-gray-400',
        };
    };
@endphp

<div
    class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
<div class="flex flex-col gap-2 my-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Recent Tips</h3>
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
            <tbody>
                @foreach ($productsList as $product)
                    <tr class="border-t border-gray-100 dark:border-gray-800">
                        <td class="py-3 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="h-[50px] w-[50px] overflow-hidden rounded-md">
                                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" />
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                        {{ $product['name'] }}
                                    </p>
                                    <span class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $product['Desc'] }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td class="py-3 whitespace-nowrap">
                            <span class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                {{ $product['price'] }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
