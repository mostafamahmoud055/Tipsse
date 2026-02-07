    <div class="grid grid-cols-1 md:grid-cols-5 gap-10 my-4 pb-2">
        <div class="grid-cols-1 md:grid-cols-3 grid col-span-1 md:col-span-4 gap-10">
            <x-form.form-elements.select-inputs name="sort" placeholder="Status" :options="[
                'newest' => 'Newest',
                'oldest' => 'Oldest',
            ]" />

            <x-form.date-picker id="date_pick" name="date_pick" placeholder="Date Picker"
                defaultDate="{{ now()->format('Y-m-d') }}" />

            <x-form.form-elements.select-inputs name="sort" placeholder="Branch No." :options="[
                'newest' => 'Newest',
                'oldest' => 'Oldest',
            ]" />
        </div>
        <div class="col-span-1 md:col-span-1">
            <button type="submit"
                class="menu-item-active w-full flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white">
                Apply
            </button>
        </div>
    </div>