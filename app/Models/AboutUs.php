<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class AboutUs extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    protected $table = 'about_us';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'stat1_value',
        'stat1_label',
        'stat2_value',
        'stat2_label',
        'stat3_value',
        'stat3_label',
    ];

    public $translatable = ['title', 'subtitle', 'description', 'stat1_label', 'stat2_label', 'stat3_label'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('large')
            ->width(1200)
            ->height(900)
            ->performOnCollections('image');
    }

    /**
     * Get the singleton instance, creating it if it doesn't exist.
     */
    public static function instance(): static
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'title'      => ['hy' => 'Մեր Մասին', 'ru' => 'О нас', 'en' => 'About Us'],
                'subtitle'   => ['hy' => 'Մենք Սահմանում Ենք Ոսկի Նոր Հաֆանիշներ', 'ru' => 'Мы устанавливаем новые стандарты', 'en' => 'We Set New Standards'],
                'description' => ['hy' => 'Մեր ընկերությունը...', 'ru' => 'Наша компания...', 'en' => 'Our company...'],
                'stat1_value' => '50+',
                'stat1_label' => ['hy' => 'Ապրանքներ', 'ru' => 'Продуктов', 'en' => 'Products'],
                'stat2_value' => '40+',
                'stat2_label' => ['hy' => 'Գործընկերներ', 'ru' => 'Партнёров', 'en' => 'Partners'],
                'stat3_value' => '250+',
                'stat3_label' => ['hy' => 'Հաճախորդներ', 'ru' => 'Клиентов', 'en' => 'Clients'],
            ]
        );
    }

    public function getImageUrl(): string
    {
        return $this->getFirstMediaUrl('image', 'large') ?: asset('images/about-placeholder.jpg');
    }
}
