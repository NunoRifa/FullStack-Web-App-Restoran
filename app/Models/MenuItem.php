<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public static function applyFilters($request, $sort)
    {
        $query = self::query();

        if ($search = $request->get('search')) {
            $query->where('menu_items_name', 'like', "%{$search}%");
        }

        $sorts = $request->get('sort', 'menu_items_name');
        $direction = in_array(strtolower($request->get('direction')), ['asc', 'desc'])
            ? $request->get('direction')
            : 'asc';

        if (in_array($sorts, $sort)) {
            $query->orderBy($sorts, $direction);
        }

        return $query;
    }

    public function getFormattedPriceAttribute(): string
    {
        if ($this->menu_items_price === null) {
            return '-';
        }

        return Str::of(number_format($this->menu_items_price, 0, ',', '.'))->prepend('Rp ');
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
