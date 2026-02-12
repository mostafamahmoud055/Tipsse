<div class="my-4 pb-2">
    <form method="GET" class="grid grid-cols-3 gap-4 w-full">
        {{-- Status Filter --}}
        <x-form.form-elements.select-inputs name="is_active" placeholder="All Status" :options="[
            1 => 'Active',
            0 => 'In Active',
        ]"
            class="col-span-3 md:col-span-2" :value="request('is_active')" {{-- يحافظ على القيمة بعد الـ submit --}} />

        {{-- Date Picker --}}
        <x-form.date-picker id="date_pick" name="date_pick" placeholder="Date Picker" :defaultDate="request('date_pick')"
            class="col-span-3 md:col-span-2" />


        {{-- Submit Button --}}
        <button type="submit"
            class="col-span-3 md:col-span-1 menu-item-active flex items-center justify-center gap-2 rounded-lg px-6 py-3 text-sm font-medium text-white">
            Apply
        </button>
    </form>
</div>
