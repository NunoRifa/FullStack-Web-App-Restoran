<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    const STATUS_AVAILABLE = 'Available';
    const STATUS_RESERVED = 'Reserved';
    const STATUS_OCCUPIED = 'Occupied';
    const STATUS_CLEANING = 'Cleaning';
    const STATUS_REPARATION = 'Reparation';

    const STATUSES = [
        self::STATUS_AVAILABLE,
        self::STATUS_RESERVED,
        self::STATUS_OCCUPIED,
        self::STATUS_CLEANING,
        self::STATUS_REPARATION,
    ];

    protected $fillable = [
        'tables_id',
        'tables_name',
        'tables_capacity',
        'tables_location',
        'tables_status'
    ];

    public function isAvailable(): bool
    {
        return $this->tables_status == self::STATUS_AVAILABLE;
    }

    public function isReserved(): bool
    {
        return $this->tables_status == self::STATUS_RESERVED;
    }

    public static function applyFilters($request, $sortableColumns)
    {
        $query = self::query();

        if ($request->filled('search')) {
            $query->where('tables_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('sort') && in_array($request->sort, $sortableColumns)) {
            $query->orderBy($request->sort, $request->get('direction', 'asc'));
        }

        return $query;
    }
}
