@props([
    'ButtonName' => '',
    'modalTitle' => '',
    'employee' => null,
    'updateStatus' => false,
])
@php
    $isEdit = !is_null($employee);
    $modalId = $isEdit ? 'employee-modal-' . $employee->id : 'employee-modal-create';
    $merchant_branches = $employee?->merchant?->branches;
    $inputId = 'merchant-search-' . $modalId;
    $resultsId = 'merchant-results-' . $modalId;
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
                    action="{{ $isEdit ? route('employees.update', $employee->id) : route('employees.store') }}">

                    @csrf
                    @if ($isEdit)
                        @method('PUT')
                    @endif
                    <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
                        <div class="col-span-2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Full Name<span class="text-error-500">*</span>
                            </label>
                            <input type="text" required name="name" placeholder="Ahmed"
                                value="{{ old('name', $employee?->name) }}"
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                        </div>


                        <div class="col-span-1">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Email<span class="text-error-500">*</span>
                            </label>
                            <input require type="email" name="email" placeholder="randomuser@pimjo.com"
                                value="{{ old('email', $employee?->email) }}"
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">

                        </div>

                        <div class="col-span-1">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Phone
                            </label>
                            <input type="text" required name="phone" placeholder="+09 363 398 46"
                                value="{{ old('phone', $employee?->phone) }}"
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">

                        </div>
                        {{-- Merchant Search --}}
                        <div class="relative w-full col-span-1 ">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Merchant<span class="text-error-500">*</span>
                            </label>
                            <input type="hidden" name="merchant_id" id="merchant_id-{{ $modalId }}"
                                value="{{ old('merchant_id', $employee?->merchant?->id) }}">
                            <input type="text" id="{{ $inputId }}" placeholder="Search merchant owner..."
                                name="merchant_name" value="{{ old('merchant_name', $employee?->merchant?->name) }}"
                                class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:border-brand-400 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                            <ul id="{{ $resultsId }}"
                                class="absolute z-50 mt-1 hidden w-full rounded-lg border border-gray-200 bg-white shadow dark:border-gray-700 dark:bg-gray-900">
                            </ul>
                        </div>


                        {{-- Branch Name --}}
<div class="col-span-1">
    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Branch Name<span class="text-error-500">*</span>
    </label>
    <select id="branch-select-{{ $modalId }}" name="branch_id"
        class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:border-brand-400 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
        <option value="">Select Branch...</option>
        @if ($merchant_branches)
            @foreach ($merchant_branches as $branch)
                <option value="{{ $branch->id }}"
                    {{ old('branch_id', $employee?->branch_id) == $branch->id ? 'selected' : '' }}>
                    {{ $branch->name }}
                </option>
            @endforeach
        @endif
    </select>
</div>

                        <div class="col-span-2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                National Id
                            </label>
                            <input type="text" required name="national_id" placeholder="22 88 99 363 398 46"
                                value="{{ old('phone', $employee?->national_id) }}"
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">

                        </div>


                        <div class="col-span-2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Password<span class="text-error-500">*</span>
                            </label>
                            <div x-data="{ showPassword: false }" class="relative">
                                <input require :type="showPassword ? 'text' : 'password'"
                                    {{ $isEdit ? '' : 'required' }} name="password" placeholder="Enter your password"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />

                                <span @click="showPassword = !showPassword"
                                    class="absolute top-1/2 right-4 z-30 -translate-y-1/2 cursor-pointer text-gray-500 dark:text-gray-400">
                                    <svg x-show="!showPassword" class="fill-current" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.0002 13.8619C7.23361 13.8619 4.86803 12.1372 3.92328 9.70241C4.86804 7.26761 7.23361 5.54297 10.0002 5.54297C12.7667 5.54297 15.1323 7.26762 16.0771 9.70243C15.1323 12.1372 12.7667 13.8619 10.0002 13.8619ZM10.0002 4.04297C6.48191 4.04297 3.49489 6.30917 2.4155 9.4593C2.3615 9.61687 2.3615 9.78794 2.41549 9.94552C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C13.5184 15.3619 16.5055 13.0957 17.5849 9.94555C17.6389 9.78797 17.6389 9.6169 17.5849 9.45932C16.5055 6.30919 13.5184 4.04297 10.0002 4.04297ZM9.99151 7.84413C8.96527 7.84413 8.13333 8.67606 8.13333 9.70231C8.13333 10.7286 8.96527 11.5605 9.99151 11.5605H10.0064C11.0326 11.5605 11.8646 10.7286 11.8646 9.70231C11.8646 8.67606 11.0326 7.84413 10.0064 7.84413H9.99151Z"
                                            fill="#98A2B3" />
                                    </svg>
                                    <svg x-show="showPassword" class="fill-current" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.63803 3.57709C4.34513 3.2842 3.87026 3.2842 3.57737 3.57709C3.28447 3.86999 3.28447 4.34486 3.57737 4.63775L4.85323 5.91362C3.74609 6.84199 2.89363 8.06395 2.4155 9.45936C2.3615 9.61694 2.3615 9.78801 2.41549 9.94558C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C11.255 15.3619 12.4422 15.0737 13.4994 14.5598L15.3625 16.4229C15.6554 16.7158 16.1302 16.7158 16.4231 16.4229C16.716 16.13 16.716 15.6551 16.4231 15.3622L4.63803 3.57709ZM12.3608 13.4212L10.4475 11.5079C10.3061 11.5423 10.1584 11.5606 10.0064 11.5606H9.99151C8.96527 11.5606 8.13333 10.7286 8.13333 9.70237C8.13333 9.5461 8.15262 9.39434 8.18895 9.24933L5.91885 6.97923C5.03505 7.69015 4.34057 8.62704 3.92328 9.70247C4.86803 12.1373 7.23361 13.8619 10.0002 13.8619C10.8326 13.8619 11.6287 13.7058 12.3608 13.4212ZM16.0771 9.70249C15.7843 10.4569 15.3552 11.1432 14.8199 11.7311L15.8813 12.7925C16.6329 11.9813 17.2187 11.0143 17.5849 9.94561C17.6389 9.78803 17.6389 9.61696 17.5849 9.45938C16.5055 6.30925 13.5184 4.04303 10.0002 4.04303C9.13525 4.04303 8.30244 4.17999 7.52218 4.43338L8.75139 5.66259C9.1556 5.58413 9.57311 5.54303 10.0002 5.54303C12.7667 5.54303 15.1323 7.26768 16.0771 9.70249Z"
                                            fill="#98A2B3" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div>

                            <div x-data="{ switcherToggle: {{ old('is_active', $employee?->employee?->is_active ?? false) ? 'true' : 'false' }} }">
                                <label
                                    class="flex cursor-pointer items-center gap-3 text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                    <div class="relative">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" class="sr-only"
                                            x-model="switcherToggle">

                                        <div class="block h-6 w-11 rounded-full"
                                            :class="switcherToggle ? 'menu-item-active dark:bg-brand-400' :
                                                'bg-gray-200 dark:bg-brand-400/10'">
                                        </div>

                                        <div :class="switcherToggle ? 'translate-x-full' : 'translate-x-0'"
                                            class="shadow-theme-sm absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white duration-300 ease-linear">
                                        </div>
                                    </div>
                                    Active
                                </label>
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
                            {{ $isEdit ? 'Update Employee' : 'Create Employee' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    (function() {
        const input = document.getElementById('{{ $inputId }}'); // input search للـ Merchant
        const results = document.getElementById('{{ $resultsId }}'); // قائمة النتائج
        const hidden = document.getElementById(
            'merchant_id-{{ $modalId }}'); // hidden field لتخزين الـ Merchant ID
        const branchSelect = document.getElementById('branch-select-{{ $modalId }}'); // select للفروع
        let timer;

        if (!input || !results || !hidden || !branchSelect) return;

        // البحث عن الـ Merchant
        input.addEventListener('input', function() {
            clearTimeout(timer);
            const q = this.value.trim();
            if (q.length < 2) {
                results.classList.add('hidden');
                return;
            }

            timer = setTimeout(async () => {
                try {
                    const res = await fetch(
                        `{{ route('branches.search-owners') }}?q=${encodeURIComponent(q)}`);
                    const data = await res.json();
                    results.innerHTML = '';

                    if (!data.length) {
                        results.innerHTML =
                            `<li class="px-4 py-2 text-sm text-gray-500">No results found</li>`;
                    } else {
                        data.forEach(user => {
                            const li = document.createElement('li');
                            li.textContent = user.name;
                            li.className =
                                'cursor-pointer px-4 py-2 text-sm text-gray-800 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-800';
                            li.onclick = async () => {
                                hidden.value = user.id;
                                input.value = user.name;
                                results.classList.add('hidden');

                                // جلب الفروع الخاصة بالـ Merchant المختار
                                branchSelect.innerHTML =
                                    '<option value="">Loading...</option>';
                                try {
                                    const resBranches = await fetch(
                                        `/merchants/${user.id}/branches`);
                                    const branches = await resBranches.json();
                                    branchSelect.innerHTML =
                                        '<option value="">Select Branch...</option>';
                                    branches.forEach(branch => {
                                        const option = document
                                            .createElement('option');
                                        option.value = branch.id;
                                        option.textContent = branch
                                            .name;
                                        branchSelect.appendChild(
                                            option);
                                    });
                                } catch (err) {
                                    console.error(err);
                                    branchSelect.innerHTML =
                                        '<option value="">Select Branch...</option>';
                                }
                            };
                            results.appendChild(li);
                        });
                    }

                    results.classList.remove('hidden');
                } catch (err) {
                    console.error(err);
                }
            }, 300);
        });
    })();
</script>
