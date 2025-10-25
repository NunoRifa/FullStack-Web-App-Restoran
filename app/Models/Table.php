<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

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

    protected $primaryKey = 'tables_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tables_id',
        'tables_name',
        'tables_capacity',
        'tables_location',
        'tables_status',
    ];

    protected $casts = [
        'tables_capacity' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->tables_id)) {
                $lastId = self::orderBy('tables_id', 'desc')->value('tables_id');
                $num = $lastId ? (int) str_replace('TBL-', '', $lastId) : 0; // Ambil angka terakhir (misalnya dari "TBL-0042" -> 42)

                $model->tables_id = 'TBL-' . str_pad($num + 1, 4, 0, STR_PAD_LEFT);
            }
        });
    }

    public static function applyFilters($request, $sortableColumns)
    {
        $query = self::query();

        if ($search = $request->get('search')) {
            $query->where('tables_name', 'like', "%{$search}%");
        }

        if ($sort = $request->get('sort')) {
            $direction = in_array(strtolower($request->get('direction')), ['asc', 'desc'])
                ? $request->get('direction')
                : 'asc';

            if (in_array($sort, $sortableColumns)) {
                $query->orderBy($sort, $direction);
            }
        }

        return $query;
    }

    public function isAvailable(): bool
    {
        return $this->tables_status === self::STATUS_AVAILABLE;
    }

    public function isReserved(): bool
    {
        return $this->tables_status === self::STATUS_RESERVED;
    }
}
