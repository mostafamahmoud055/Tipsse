<div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-end">
    <x-form.select.multiple-select 
        name="status" 
        :options="[
            'approved' => 'Approved',
            'pending' => 'Pending',
            'rejection' => 'Rejection',
        ]" 
        class="w-full dark:text-white sm:w-auto"
    />

    <x-form.form-elements.select-inputs 
        name="sort" 
        placeholder="Sort by" 
        :options="[
            'newest' => 'Newest',
            'oldest' => 'Oldest',
        ]" 
        class="w-full sm:w-auto"
    />
</div>
