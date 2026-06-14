<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class BodyPart extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'skeleton_zone',
        'is_paired',
        'svg_element_ids',
        'sort_order',
        'is_active',
    ];

    public $translatable = ['name'];

    protected $casts = [
        'is_active' => 'boolean',
        'is_paired' => 'boolean',
        'svg_element_ids' => 'array',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
