@props(['options' => [], 'selected' => null])

<div x-data="{
    open: false,
    selected: '{{ $selected }}',
    options: @js($options),

    selectedLabel() {
        return this.selected && this.options[this.selected] ?
            this.options[this.selected] :
            '';
    },

    selectItem(key) {
        this.selected = key;
        this.open = false;
    }
}" class="relative w-full">
    <!-- Display Selected Value -->
    <div @click="open = !open" x-ref="button"
        class="appearance-none w-full ps-3 pe-3 h-10 py-2 text-base sm:text-sm leading-[1.375rem]
           rounded-lg shadow-xs bg-white dark:bg-zinc-800 dark:disabled:bg-white/[7%]
           text-zinc-700 dark:text-zinc-300 disabled:text-zinc-500 dark:disabled:text-zinc-400
           border border-zinc-200 border-b-zinc-300/80 dark:border-white/10
           cursor-pointer flex items-center justify-between">
        <span x-text="selectedLabel() || '{{ __('Select...') }}'"
            class="text-sm text-zinc-700 dark:text-zinc-300 disabled:text-zinc-500 dark:disabled:text-zinc-400 has-[option.placeholder:checked]:text-zinc-400 dark:has-[option.placeholder:checked]:text-zinc-400"></span>
        <span class="text-zinc-500">&#9662;</span>
    </div>

    <!-- Dropdown Menu -->
    <template x-teleport="body">
        <div x-show="open" x-transition.origin.top.left @click.away="open = false" x-ref="dropdown"
            x-init="$watch('open', value => {
                if (value && $refs.button) {
                    const rect = $refs.button.getBoundingClientRect();
                    $refs.dropdown.style.top = `${rect.bottom + window.scrollY}px`;
                    $refs.dropdown.style.left = `${rect.left + window.scrollX}px`;
                    $refs.dropdown.style.width = `${rect.width}px`;
                }
            })"
            class="fixed z-[9999] bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-white/10
               rounded-md shadow-lg p-2 max-h-40 overflow-y-auto">
            <template x-for="(label, key) in options" :key="key">
                <div @click="selectItem(key)"
                    class="p-2 hover:bg-zinc-100 dark:hover:bg-zinc-600 rounded-md cursor-pointer">
                    <span x-text="label"></span>
                </div>
            </template>
        </div>
    </template>



    <!-- Hidden Input for Form Submission -->
    <input type="hidden" name="{{ $attributes->get('name') }}" :value="selected">
</div>
