<x-layouts.app :title="__('Master Menu - List')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-form-card :title="__('List Menu')">
                <x-table
                :create="auth()->user() ? ['url' => route('dashboard.menuItems.create'), 'label' => __('Buat Menu')] : null"
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
                        'menu_items_price' => $menu->formatted_price,
                        'menu_items_category' => $menu->menu_items_category,
                        'is_active' => @verbatim
                            $menu->is_active ? '<span class="bg-green-100 text-green-700 text-sm px-2 py-1 mx-px mb-2 rounded-md inline-block break-all">'.__('Active').'</span>' : '<span class="bg-red-100 text-red-700 text-sm px-2 py-1 mx-px mb-2 rounded-md inline-block break-all">'.__('In Active').'</span>'
                        @endverbatim,
                        'actions' => array_filter([
                            [
                                'name' => 'edit',
                                'url' => route('dashboard.menuItems.edit', $menu->encrypted_id),
                                'label' => view('icons.pencil-square')->render(),
                                'color' => 'blue'
                            ],
                            [
                                'name' => 'delete',
                                'url' => route('dashboard.menuItems.destroy', $menu->encrypted_id),
                                'label' => view('icons.trash')->render(),
                            ],
                        ]),
                    ];
                })"
                :pagination="$menus->links()"
                />
            </x-form-card>
        </div>
    </div>
</x-layouts.app>
