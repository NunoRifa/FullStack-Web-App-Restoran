<x-layouts.app :title="__('Master Meja - Create')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-form-card :title="__('Buat Meja')">
                <form action="{{ route('dashboard.tables.store') }}" method="post">
                    @csrf
                    @method('post')

                    <div class="mb-4">
                        <x-input-label :value="__('Kode Meja:')" required />
                        <x-text-input id="tables_id" name="tables_id" type="text" autocomplete="off" />
                        <x-input-error :messages="$errors->get('tables_id')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label :value="__('Nama/Nomor Meja:')" required />
                        <x-text-input id="tables_name" name="tables_name" type="text" autocomplete="off" />
                        <x-input-error :messages="$errors->get('tables_name')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label :value="__('Kapasitas Meja:')" required />
                        <x-text-input id="table_capacity" name="tables_capacity" type="number" autocomplete="off" />
                        <x-input-error :messages="$errors->get('tables_capacity')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label :value="__('Lokasi Meja: (mis.: Indoor/Outdoor)')" />
                        <x-text-input id="table_location" name="tables_location" type="text" autocomplete="off" />
                        <x-input-error :messages="$errors->get('tables_location')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label :value="__('Status Meja:')" required />
                        <x-select-input :options="[
                            'Available' => 'Available',
                            'Reserved' => 'Reserved',
                            'Occupied' => 'Occupied',
                            'Cleaning' => 'Cleaning',
                            'Reparation' => 'Reparation',
                        ]" id="tables_status" name="tables_status" />
                        <x-input-error :messages="$errors->get('tables_status')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <a href="{{ route('dashboard.tables') }}">
                            <x-secondary-button>{{ __('Back') }}</x-secondary-button>
                        </a>
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </x-form-card>
        </div>
    </div>
</x-layouts.app>
