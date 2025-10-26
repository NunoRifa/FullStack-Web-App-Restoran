<?php

use App\Models\User;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Buat user terverifikasi agar lolos middleware ['auth', 'verified']
    $this->user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->actingAs($this->user);
});

it('can access the index page', function () {
    $response = $this->get(route('dashboard.menuItems.index'));
    $response->assertStatus(200);
});

it('can create a menu item', function () {
    $data = [
        'menu_items_name' => 'Nasi Goreng',
        'menu_items_description' => 'Pedas dan enak',
        'menu_items_price' => 15000,
        'menu_items_category' => 'Makanan',
        'is_active' => 1,
    ];

    $response = $this->post(route('dashboard.menuItems.store'), $data);

    $response->assertRedirect(route('dashboard.menuItems.index'));
    $this->assertDatabaseHas('menu_items', [
        'menu_items_name' => 'Nasi Goreng',
    ]);
});

it('can open the edit page with encrypted id', function () {
    $menu = MenuItem::create([
        'menu_items_name' => 'Es Teh Manis',
        'menu_items_description' => 'Dingin menyegarkan',
        'menu_items_price' => 8000,
        'menu_items_category' => 'Minuman',
        'is_active' => 1,
    ]);

    $encryptedId = Crypt::encryptString($menu->menu_items_id);

    $response = $this->get(route('dashboard.menuItems.edit', $encryptedId));
    $response->assertStatus(200);
    $response->assertViewHas('menuItem');
});

it('can update menu item', function () {
    $menu = MenuItem::create([
        'menu_items_name' => 'Ayam Goreng',
        'menu_items_description' => 'Renyaak',
        'menu_items_price' => 20000,
        'menu_items_category' => 'Makanan',
        'is_active' => 1,
    ]);

    $data = [
        'menu_items_name' => 'Ayam Goreng Original',
        'menu_items_description' => 'Garing dan gurih',
        'menu_items_price' => 22000,
        'menu_items_category' => 'Makanan',
        'is_active' => 1,
    ];

    $response = $this->put(route('dashboard.menuItems.update', $menu->menu_items_id), $data);

    $response->assertRedirect(route('dashboard.menuItems.index'));
    $this->assertDatabaseHas('menu_items', [
        'menu_items_name' => 'Ayam Goreng Original',
    ]);
});

it('can delete a menu item with encrypted id', function () {
    $menu = MenuItem::create([
        'menu_items_name' => 'Jus Alpukat',
        'menu_items_description' => 'Segar banget',
        'menu_items_price' => 12000,
        'menu_items_category' => 'Minuman',
        'is_active' => 1,
    ]);

    $encryptedId = Crypt::encryptString($menu->menu_items_id);

    $response = $this->delete(route('dashboard.menuItems.destroy', $encryptedId));
    $response->assertRedirect(route('dashboard.menuItems.index'));

    $this->assertDatabaseMissing('menu_items', [
        'menu_items_id' => $menu->menu_items_id,
    ]);
});
