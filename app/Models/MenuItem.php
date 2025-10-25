<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
    ];

    protected $primaryKey = 'menu_items_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'menu_items_id',
        'menu_items_name',
        'menu_items_description',
        'menu_items_price',
        'menu_items_category',
        'is_active',
    ];

    protected $casts = [
        'menu_items_price' => 'integer',
        'is_active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->menu_items_id)) {
                $lastId = self::orderBy('menu_items_id', 'desc')->value('menu_items_id');
                $num = $lastId ? (int) str_replace('MNU-', '', $lastId) : 0;

                $model->menu_items_id = 'MNU-' . str_pad($num + 1, 4, 0, STR_PAD_LEFT);
            }
        });
    }

    public static function applyFilters($request, $sortableColumns)
    {
        $query = self::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('menu_items_name', 'like', "%{$search}%")
                ->orWhere('menu_items_category', 'like', "%{$search}%");
            });
        }

        $sorts = $request->get('sort', 'menu_items_name');

        if ($sorts === 'id') {
            $sorts = 'menu_items_id';
        }

        $direction = strtolower($request->get('direction', $request->get('order', 'asc')));

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        if (in_array($sorts, $sortableColumns)) {
            $query->orderBy($sorts, $direction);
        }

        return $query;
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->menu_items_price === null) {
            return '-';
        }

        return 'Rp ' . number_format($this->menu_items_price, 0, ',', '.');
    }

    public function isActive(): bool
    {
        return $this->is_active === self::STATUS_ACTIVE;
    }

    public function isInActive(): bool
    {
        return $this->is_active === self::STATUS_INACTIVE;
    }
}
