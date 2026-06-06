<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class News extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'title',
        'short_description',
        'description',
        'slug',
        'published_at',
        'is_active',
    ];

    public $translatable = ['title', 'short_description', 'description'];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main_image')
            ->singleFile();

        $this->addMediaCollection('gallery');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(600)
            ->height(400)
            ->sharpen(10)
            ->performOnCollections('main_image', 'gallery');

        $this->addMediaConversion('card')
            ->width(800)
            ->height(530)
            ->performOnCollections('main_image');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getMainImageUrl(): string
    {
        return $this->getFirstMediaUrl('main_image', 'card') ?: asset('images/placeholder-news.jpg');
    }

    public function getMainThumbUrl(): string
    {
        return $this->getFirstMediaUrl('main_image', 'thumb') ?: asset('images/placeholder-news.jpg');
    }
}
