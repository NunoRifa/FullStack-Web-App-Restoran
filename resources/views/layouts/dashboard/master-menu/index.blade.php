<x-layouts.app :title="__('Master Menu - List')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-form-card :title="__('List Menu')">
                <x-table
                :create="auth()->user() ? ['url' => route('dashboard.menu.create'), 'label' => __('Buat Menu')] : null"
                :headers="['id', 'menu_items_name', 'menu_items_price', 'menu_items_category', 'is_active']"
                :labels="[
                    'Kode Menu',
                    __('Nama Menu'),
                    __('Harga Menu'),
                    __('Kategori Menu'),
                    __('Status Menu'),
                    __('actions'),
                ]"
                :data="$menus->map(function($menu, $key) {
                    return [
                        'id' => $menu->menu_items_id,
                        'menu_items_name' => $menu->menu_items_name,
                        'menu_items_price' => $menu->menu_items_price,
                        'menu_items_category' => $menu->menu_items_category,
                        'is_active' => $menu->is_active,
                        'actions' => array_filter([
                            [
                                'name' => 'edit',
                                'url' => route('dashboard.menu.edit', $menu->menu_items_id),
                                'label' => view('icons.pencil-square')->render(),
                                'color' => 'blue'
                            ],
                            [
                                'name' => 'delete',
                                'url' => route('dashboard.menu.destroy', $menu->menu_items_id),
                                'label' => view('icons.trash')->render(),
                            ],
                        ]),
                    ];
                })"
                />
            </x-form-card>
        </div>
    </div>
</x-layouts.app>
