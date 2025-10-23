<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Table;
use App\Http\Requests\Dashboard\TableStoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Exception;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortableColumns = ['tables_id', 'tables_name'];

        $tables = Table::applyFilters($request, $sortableColumns)->paginate(10);

        return view('layouts.dashboard.master-table.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.dashboard.master-table.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TableStoreRequest $request)
    {
        Table::create($request->validated());

        return redirect()->route('dashboard.tables.index')->with('success', 'Table created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table)
    {
        return view('layouts.dashboard.master-table.edit', compact('table'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TableStoreRequest $request, Table $table)
    {
        $table->update($request->validated());

        return redirect()->route('dashboard.tables.index')->with('success', 'Table update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        try {
            $table->delete();
            return redirect()->route('dashboard.tables.index')
                ->with('success', 'Table deleted successfully.');
        } catch (Exception $e) {
            return redirect()->route('dashboard.tables.index')
                ->with('error', 'Failed to delete table.');
        }
    }
}
