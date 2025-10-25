<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\MenuItem;
use App\Http\Requests\Dashboard\MenuItemStoreRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = ['menu_items_id', 'menu_items_name'];

        $menus = MenuItem::applyFilters($request, $sort)->paginate(10);

        return view('layouts.dashboard.master-menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.dashboard.master-menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuItemStoreRequest $request)
    {
        MenuItem::create($request->validated());

        return redirect()->route('dashboard.menu.index')->with('success', 'Table created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MenuItem $menuItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuItem $menuItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menuItem)
    {
        //
    }
}
