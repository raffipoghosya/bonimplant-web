<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'category_id',
        'body_part_id',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    public $translatable = ['title', 'description'];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function bodyPart(): BelongsTo
    {
        return $this->belongsTo(BodyPart::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('primary_image')
            ->singleFile()
            ->useFallbackUrl('/images/placeholder-product.jpg');

        $this->addMediaCollection('gallery');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400)
            ->height(400)
            ->sharpen(10)
            ->performOnCollections('primary_image', 'gallery');

        $this->addMediaConversion('large')
            ->width(1200)
            ->height(900)
            ->performOnCollections('primary_image', 'gallery');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getPrimaryImageUrl(): string
    {
        return $this->getFirstMediaUrl('primary_image', 'large') ?: asset('images/placeholder-product.jpg');
    }

    public function getPrimaryThumbUrl(): string
    {
        return $this->getFirstMediaUrl('primary_image', 'thumb') ?: asset('images/placeholder-product.jpg');
    }
}
