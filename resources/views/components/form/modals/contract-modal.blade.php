@props([
    'ButtonName' => '',
    'modalTitle' => '',
    'application' => null,
    'updateStatus' => false,
])
@php
    $isEdit = !is_null($application);
    $modalId = $isEdit
        ? 'merchant-modal-' . $application->id
        : 'merchant-modal-create';
@endphp

<div class="border-t border-gray-100 dark:border-gray-800">
    <div x-data="{ open: false }" :id="'{{ $modalId }}'">
        @if (!$isEdit)
            <button class="menu-item-active h-fit w-full md:w-auto rounded-lg px-4 py-3 text-sm font-medium text-white"
                @click="open = true">
                {{ $ButtonName }}
            </button>
        @else
            <button
                class="inline-flex Óitems-center justify-center rounded
              bg-yellow-50 px-2.5 py-1.5
              text-yellow-700 hover:bg-yellow-100
              dark:bg-yellow-500/15 dark:text-yellow-400 dark:hover:bg-yellow-500/25"
                @click="open = true">
                {!! menu_icon('edit-icon') !!}
            </button>
        @endif

        <div x-show="open" x-cloak
            class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto modal z-99999">

            <div class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]" @click="open = false"></div>
            <div @click.outside="open = false"
                class="relative w-full max-w-[584px] rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10">
                <!-- close btn -->
                <button @click="open = false"
                    class="group absolute right-3 top-3 z-999 flex h-9.5 w-9.5 items-center justify-center rounded-full bg-gray-200 text-gray-500 transition-colors hover:bg-gray-300 hover:text-gray-500 dark:bg-gray-800 dark:hover:bg-gray-700 sm:right-6 sm:top-6 sm:h-11 sm:w-11">
                    <svg class="transition-colors fill-current group-hover:text-gray-600 dark:group-hover:text-gray-200"
                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M6.04289 16.5413C5.65237 16.9318 5.65237 17.565 6.04289 17.9555C6.43342 18.346 7.06658 18.346 7.45711 17.9555L11.9987 13.4139L16.5408 17.956C16.9313 18.3466 17.5645 18.3466 17.955 17.956C18.3455 17.5655 18.3455 16.9323 17.955 16.5418L13.4129 11.9997L17.955 7.4576C18.3455 7.06707 18.3455 6.43391 17.955 6.04338C17.5645 5.65286 16.9313 5.65286 16.5408 6.04338L11.9987 10.5855L7.45711 6.0439C7.06658 5.65338 6.43342 5.65338 6.04289 6.0439C5.65237 6.43442 5.65237 7.06759 6.04289 7.45811L10.5845 11.9997L6.04289 16.5413Z"
                            fill=""></path>
                    </svg>
                </button>

                <h4 class="mb-6 text-lg font-medium text-gray-800 dark:text-white/90">
                    {{ $modalTitle }}
                </h4>
                <form method="POST"
                    action="{{ $isEdit ? route('merchants.edit', $application->id) : route('merchants.store') }}">

                    @csrf
                    @if ($isEdit)
                        @method('PUT')
                    @endif
                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
 
                            {{--  Drop Down  --}}
                            <div class="col-span-2">
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Business Type<span class="text-error-500">*</span>
                                </label>
                                <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                                    <select required name="status"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">

                                        <option disabled {{ old('status', $application?->status) ? '' : 'selected' }}>
                                            Select Type</option>

                                        <option value="pending"
                                            {{ old('status', $application?->status) == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="approved"
                                            {{ old('status', $application?->status) == 'approved' ? 'selected' : '' }}>
                                            Approved
                                        </option>
                                        <option value="rejected"
                                            {{ old('status', $application?->status) == 'rejected' ? 'selected' : '' }}>
                                            Rejected
                                        </option>
                                    </select>

                                    @error('business_type')
                                        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                                    @enderror


                                    <span
                                        class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                        <svg class="stroke-current" width="20" height="20"
                                            viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke=""
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
              


                    </div>

                    <div class="flex items-center justify-end w-full gap-3 mt-6">
                        <button @click="open = false" type="button"
                            class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200 sm:w-auto">
                            Close
                        </button>
                        <button type="submit"
                            class="menu-item-active h-fit w-full md:w-auto rounded-lg px-4 py-3 text-sm font-medium text-white">
                            {{ $isEdit ? 'Update Merchant' : 'Create Merchant' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
