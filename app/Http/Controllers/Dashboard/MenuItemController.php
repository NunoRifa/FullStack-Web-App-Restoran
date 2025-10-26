<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\MenuItem;
use App\Http\Requests\Dashboard\MenuItemStoreRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

use Exception;

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

        return redirect()->route('dashboard.menuItems.index')->with('success', 'Table created successfully.');
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
    public function edit($encryptedId)
    {
        $id = Crypt::decryptString($encryptedId);
        $menuItem = MenuItem::findOrFail($id);

        return view('layouts.dashboard.master-menu.edit', compact('menuItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuItemStoreRequest $request, MenuItem $menuItem)
    {
        $menuItem->update($request->validated());

        return redirect()->route('dashboard.menuItems.index')->with('success', 'Menu update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decryptString($encryptedId);
            $menuItem = MenuItem::findOrFail($id);

            $menuItem->delete();
            return redirect()->route('dashboard.menuItems.index')->with('success', 'Menu deleted successfully.');
        } catch (Exception $e) {
            return redirect()->route('dashboard.menuItems.index')->with('error', 'Failed deleted successfully.');
        }
    }
}
