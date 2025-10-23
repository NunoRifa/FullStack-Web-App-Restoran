<?php

use App\Models\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Buat user terverifikasi agar lolos middleware ['auth', 'verified']
    $this->user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    $this->actingAs($this->user);
});

test('user can view tables index', function () {
    Table::factory()->count(3)->create();

    $response = $this->get(route('dashboard.tables.index'));

    $response->assertStatus(200);
    $response->assertViewHas('tables');
});

test('user can access create page', function () {
    $response = $this->get(route('dashboard.tables.create'));

    $response->assertStatus(200);
    $response->assertViewIs('layouts.dashboard.master-table.create');
});

test('user can store new table', function () {
    $data = [
        'tables_id' => 'TBL-' . Str::random(5),
        'tables_name' => 'Meja VIP',
        'tables_capacity' => 4,
        'tables_location' => 'Area A',
        'tables_status' => Table::STATUS_AVAILABLE,
    ];

    $response = $this->post(route('dashboard.tables.store'), $data);

    $response->assertRedirect(route('dashboard.tables.index'));
    $this->assertDatabaseHas('tables', ['tables_name' => 'Meja VIP']);
});

test('store fails when validation fails', function () {
    $data = [
        'tables_id' => '', // invalid
        'tables_name' => '',
        'tables_capacity' => 0, // invalid min:1
        'tables_status' => 'InvalidStatus',
    ];

    $response = $this->post(route('dashboard.tables.store'), $data);

    $response->assertSessionHasErrors(['tables_id', 'tables_name', 'tables_capacity', 'tables_status']);
});

test('user can edit table', function () {
    $table = Table::factory()->create();

    $response = $this->get(route('dashboard.tables.edit', $table));

    $response->assertStatus(200);
    $response->assertViewIs('layouts.dashboard.master-table.edit');
    $response->assertViewHas('table');
});

test('user can update table', function () {
    $table = Table::factory()->create([
        'tables_name' => 'Old Name',
    ]);

    $response = $this->put(route('dashboard.tables.update', $table), [
        'tables_id' => $table->tables_id,
        'tables_name' => 'Updated Name',
        'tables_capacity' => 6,
        'tables_location' => 'Area B',
        'tables_status' => Table::STATUS_RESERVED,
    ]);

    $response->assertRedirect(route('dashboard.tables.index'));
    $this->assertDatabaseHas('tables', ['tables_name' => 'Updated Name']);
});

test('user can delete table', function () {
    $table = Table::factory()->create();

    $response = $this->delete(route('dashboard.tables.destroy', $table));

    $response->assertRedirect(route('dashboard.tables.index'));
    $this->assertDatabaseMissing('tables', ['tables_id' => $table->tables_id]);
});
