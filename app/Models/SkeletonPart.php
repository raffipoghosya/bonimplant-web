<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SkeletonPart extends Model
{
    protected $fillable = [
        'svg_element_id',
        'name_hy',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope: only active parts.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Returns a flat associative array keyed by svg_element_id,
     * ready to be JSON-encoded and injected into the frontend.
     *
     * e.g. ['челюсть' => ['name_hy' => 'Ծնոտ'], ...]
     */
    public static function forFrontend(): array
    {
        return static::active()
            ->get(['svg_element_id', 'name_hy'])
            ->keyBy('svg_element_id')
            ->map(fn ($part) => ['name_hy' => $part->name_hy])
            ->toArray();
    }
}
