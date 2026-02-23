            @if (auth()->user()->role === 'merchant_owner')
                <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Application Status</h3>
                    <div class="flex items-center ">
                        <span class="text-sm text-gray-600 dark:text-gray-400 mr-2">Status:</span>
                        <span
                            class="rounded-full px-3 py-1 text-xs font-bold
                                @if ($merchantApplicationStatus === 'approved') bg-green-50 text-green-600 dark:bg-green-500/10 dark:text-green-400
                                @elseif($merchantApplicationStatus === 'pending') bg-yellow-50 text-yellow-600 dark:bg-yellow-500/10 dark:text-yellow-400
                                @elseif($merchantApplicationStatus === 'rejected') bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400
                                @else bg-gray-50 text-gray-600 dark:bg-gray-500/10 dark:text-gray-400 @endif
                            ">
                            {{ ucfirst($merchantApplicationStatus) }}
                        </span>
                    </div>
                </div>
            @endif