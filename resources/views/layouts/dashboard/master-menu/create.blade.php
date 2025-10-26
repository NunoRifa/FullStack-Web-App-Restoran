<x-layouts.app :title="__('Master Menu - Create')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-form-card :title="__('Buat Menu')">
                <form action="{{ route('dashboard.menuItems.store') }}" method="post">
                    @csrf
                    @method('post')

                    <div class="mb-4">
                        <x-input-label :value="__('Nama Menu:')" required />
                        <x-text-input id="menu_items_name" name="menu_items_name" type="text" value="{{ old('menu_items_name') }}" autocomplete="off" />
                        <x-input-error :messages="$errors->get('menu_items_name')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label :value="__('Deskripsi Menu:')" required />
                        <x-textarea id="menu_items_description" name="menu_items_description" rows="3" autocomplete="off">
                            {{ old('menu_items_description') }}
                        </x-textarea>
                        <x-input-error :messages="$errors->get('menu_items_description')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label :value="__('Harga Menu:')" required />
                        <x-text-input id="menu_items_price" name="menu_items_price" type="number" step="50" value="{{ old('menu_items_price') }}" autocomplete="off" />
                        <x-input-error :messages="$errors->get('menu_items_price')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label :value="__('Kategori Menu:')" required />
                        <x-text-input id="menu_items_category" name="menu_items_category" type="text" value="{{ old('menu_items_category') }}" autocomplete="off" />
                        <x-input-error :messages="$errors->get('menu_items_category')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label :value="__('Status Menu:')" required />
                        <x-select-input :options="[
                            1 => 'Active',
                            0 => 'In Active',
                        ]" id="is_active" name="is_active" selected="{{ old('is_active') }}" />
                        <x-input-error :messages="$errors->get('is_active')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('dashboard.menuItems.index') }}">
                            <x-secondary-button>{{ __('Back') }}</x-secondary-button>
                        </a>
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </x-form-card>
        </div>
    </div>
</x-layouts.app>
