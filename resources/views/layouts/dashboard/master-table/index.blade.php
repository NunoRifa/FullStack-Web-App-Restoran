<x-layouts.app :title="__('Master Meja - List')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-form-card :title="__('List Meja')">
                <x-table
                :create="auth()->user() ? ['url' => route('dashboard.tables.create'), 'label' => __('Buat Meja')] : null"
                :headers="['id', 'tables_name', 'tables_capacity', 'tables_location', 'tables_status']" :labels="[
                    'Kode Meja',
                    __('Nama/Nomor Meja'),
                    __('Kapasitas Meja'),
                    __('Lokasi Meja'),
                    __('Status'),
                    __('actions'),
                ]"
                :data="$tables->map(function($table, $key) {
                    return [
                        'id' => $table->tables_id,
                        'tables_name' => $table->tables_name,
                        'tables_capacity' => $table->tables_capacity,
                        'tables_location' => $table->tables_location,
                        'tables_status' => @verbatim
                            $table->tables_status === 'Available'
                                ? '<span class="bg-green-100 text-green-700 text-sm px-2 py-1 mx-px mb-2 rounded-md inline-block break-all">'.__('Available').'</span>'
                                : (
                                    $table->tables_status === 'Reserved'
                                        ? '<span class="bg-yellow-100 text-yellow-700 text-sm px-2 py-1 mx-px mb-2 rounded-md inline-block break-all">'.__('Reserved').'</span>'
                                        : (
                                            $table->tables_status === 'Cleaning'
                                                ? '<span class="bg-blue-100 text-blue-700 text-sm px-2 py-1 mx-px mb-2 rounded-md inline-block break-all">'.__('Cleaning').'</span>'
                                                : (
                                                    $table->tables_status === 'Reparation'
                                                        ? '<span class="bg-purple-100 text-purple-700 text-sm px-2 py-1 mx-px mb-2 rounded-md inline-block break-all">'.__('Reparation').'</span>'
                                                        : '<span class="bg-red-100 text-red-700 text-sm px-2 py-1 mx-px mb-2 rounded-md inline-block break-all">'.__('Occupied').'</span>'
                                                )
                                        )
                                )
                        @endverbatim,
                        'actions' => array_filter([
                            [
                                'name' => 'edit',
                                'url' => route('dashboard.tables.edit', $table->tables_id),
                                'label' => view('icons.pencil-square')->render(),
                                'color' => 'blue'
                            ],
                            [
                                'name' => 'delete',
                                'url' => route('dashboard.tables.destroy', $table->tables_id),
                                'label' => view('icons.trash')->render(),
                            ],
                        ]),
                    ];
                })"
                :pagination="$tables->links()"
                />
            </x-form-card>
        </div>
    </div>
</x-layouts.app>
