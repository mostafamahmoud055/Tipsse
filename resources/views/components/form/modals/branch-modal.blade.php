@props([
    'ButtonName' => '',
    'modalTitle' => '',
    'branch' => null,
])

@php
    $isEdit = !is_null($branch);
    $modalId = $isEdit ? 'branch-modal-' . $branch->id : 'branch-modal-create';
    $imageUrl = $isEdit && $branch->image ? route('image.show', ['path' => $branch->image]) : '';

    $inputId = 'merchant-search-' . $modalId;
    $resultsId = 'merchant-results-' . $modalId;
@endphp

<div class="border-t border-gray-100 dark:border-gray-800">
    <div x-data="{ open: false }" id="{{ $modalId }}">

        {{-- Button --}}
        @if (!$isEdit)
            <button class="menu-item-active h-fit w-full md:w-auto rounded-lg px-4 py-3 text-sm font-medium text-white"
                @click="open = true">
                {{ $ButtonName }}
            </button>
        @else
            <button
                class="inline-flex items-center justify-center rounded bg-yellow-50 px-2.5 py-1.5
                text-yellow-700 hover:bg-yellow-100 dark:bg-yellow-500/15 dark:text-yellow-400 dark:hover:bg-yellow-500/25"
                @click="open = true">
                {!! menu_icon('edit-icon') !!}
            </button>
        @endif

        {{-- Modal --}}
        <div x-show="open" x-cloak class="fixed inset-0 z-99999 flex items-center justify-center p-5 overflow-y-auto">

            <div class="fixed inset-0 bg-gray-400/50 backdrop-blur-[32px]" @click="open = false"></div>

            <div @click.outside="open = false"
                class="relative w-full max-w-[584px] rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10">

                {{-- Close --}}
                <button @click.prevent="open = false"
                    class="absolute right-3 top-3 flex h-10 w-10 items-center justify-center rounded-full
                    bg-gray-200 text-gray-500 hover:bg-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                    ✕
                </button>

                <h4 class="mb-6 text-lg font-medium text-gray-800 dark:text-white/90">
                    {{ $modalTitle }}
                </h4>

                <form method="POST"
                    action="{{ $isEdit ? route('branches.update', $branch->id) : route('branches.store') }}"
                    enctype="multipart/form-data">

                    @csrf
                    @if ($isEdit)
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                        {{-- Image Upload --}}
                        <div id="drop_zone_{{ $modalId }}"
                            class="col-span-2 cursor-pointer rounded-lg border-2 border-dashed
                            border-gray-300 p-6 text-center dark:border-gray-700">

                            <span id="drop_text_{{ $modalId }}"
                                class="block text-sm text-gray-600 dark:text-gray-400">
                                {{ $imageUrl ? '' : 'Drop an image or click to select' }}
                            </span>

                            <input type="file" name="image" id="file_input_{{ $modalId }}" accept="image/*"
                                hidden>

                            <img id="preview_{{ $modalId }}" src="{{ $imageUrl }}"
                                class="mx-auto mt-3 max-w-[50%] rounded-lg"
                                style="display: {{ $imageUrl ? 'block' : 'none' }}">
                        </div>

                        @if ($imageUrl)
                            <div class="col-span-2 text-center">
                                <button type="button" id="remove_image_{{ $modalId }}"
                                    class="mt-2 rounded bg-red-50 px-3 py-1 text-sm text-red-700 hover:bg-red-100">
                                    Remove Image
                                </button>
                            </div>
                        @endif
                        <input type="hidden" name="remove_image" id="remove_image_input_{{ $modalId }}"
                            value="0">

                        {{-- Branch Name --}}
                        <div class="col-span-2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Branch Name<span class="text-error-500">*</span>
                            </label>
                            <input type="text" required name="name" placeholder="Startup"
                                value="{{ old('name', $branch?->name) }}"
                                class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800">
                        </div>

                        {{-- Merchant Search --}}
                        <div class="relative w-full col-span-2 my-4">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Merchant<span class="text-error-500">*</span>
                            </label>
                            <input type="hidden" name="merchant_id" id="merchant_id-{{ $modalId }}"
                                value="{{ old('merchant_id', $branch?->merchant?->id) }}">
                            <input type="text" id="{{ $inputId }}" placeholder="Search merchant owner..."
                                name="merchant_name" value="{{ old('merchant_name', $branch?->merchant?->name) }}"
                                class="h-11 w-full rounded-lg border border-gray-300 px-4 text-sm focus:border-brand-400 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white" />
                            <ul id="{{ $resultsId }}"
                                class="absolute z-50 mt-1 hidden w-full rounded-lg border border-gray-200 bg-white shadow dark:border-gray-700 dark:bg-gray-900">
                            </ul>
                        </div>

                        {{-- Active --}}
                        <div x-data="{ switcherToggle: {{ old('is_active', $branch?->is_active ?? false) ? 'true' : 'false' }} }" class="mt-2">
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
                        {{-- Actions --}}
                        <div class="col-span-2 flex justify-end gap-3 pt-4">
                            <button type="button" @click.prevent="open = false"
                                class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] sm:w-auto">
                                Close
                            </button>
                            <button type="submit"
                                class="menu-item-active h-fit w-full md:w-auto rounded-lg px-4 py-3 text-sm font-medium text-white">
                                {{ $isEdit ? 'Update Branch' : 'Create Branch' }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Image upload --}}
<script>
    (function() {
        const id = '{{ $modalId }}';
        const dropZone = document.getElementById('drop_zone_' + id);
        const input = document.getElementById('file_input_' + id);
        const preview = document.getElementById('preview_' + id);
        const text = document.getElementById('drop_text_' + id);
        const remove = document.getElementById('remove_image_' + id);

        if (!dropZone || !input) return;

        dropZone.addEventListener('click', () => input.click());
        input.addEventListener('change', e => {
            previewFile(e.target.files[0]);
            document.getElementById('remove_image_input_{{ $modalId }}').value = 0;
        });

        function previewFile(file) {
            if (!file || !file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                text.textContent = '';
                if (remove) remove.style.display = 'inline-block';
            };
            reader.readAsDataURL(file);
        }

        if (remove) {
            remove.addEventListener('click', () => {
                preview.src = '';
                preview.style.display = 'none';
                input.value = '';
                text.textContent = 'Drop an image or click to select';
                remove.style.display = 'none';
                document.getElementById('remove_image_input_{{ $modalId }}').value = 1;

            });
        }
    })();

    {{-- Merchant search --}}
        (function() {
            const input = document.getElementById('{{ $inputId }}');
            const results = document.getElementById('{{ $resultsId }}');
            const hidden = document.getElementById('merchant_id-{{ $modalId }}');
            let timer;

            if (!input || !results || !hidden) return;

            input.addEventListener('input', function() {
                clearTimeout(timer);
                const q = this.value.trim();
                if (q.length < 2) {
                    results.classList.add('hidden');
                    return;
                }

                timer = setTimeout(async () => {
                    const res = await fetch(
                        `{{ route('branches.search-owners') }}?q=${encodeURIComponent(q)}`);
                    const data = await res.json();
                    results.innerHTML = '';

                    data.forEach(user => {
                        const li = document.createElement('li');
                        li.textContent = user.name;
                        li.className =
                            'cursor-pointer px-4 py-2 text-sm text-gray-800 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-800';
                        li.onclick = () => {
                            hidden.value = user.id;
                            input.value = user.name;
                            results.classList.add('hidden');
                        };
                        results.appendChild(li);
                    });

                    results.classList.remove('hidden');
                }, 300);
            });
        })();
</script>
