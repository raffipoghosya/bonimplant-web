<?php

namespace Database\Seeders;

use App\Models\BodyPart;
use Illuminate\Database\Seeder;

class BodyPartSeeder extends Seeder
{
    public function run(): void
    {
        BodyPart::query()->delete();

        $bodyParts = [
            ['hy' => 'Ծնոտ', 'ru' => 'Челюсть', 'en' => 'Jaw', 'is_paired' => false, 'slug' => 'jaw', 'zone' => 'head', 'svg' => ['jaw']],
            ['hy' => 'Պարանոցային հատված', 'ru' => 'Шейный отдел позвоночника', 'en' => 'Cervical spine', 'is_paired' => false, 'slug' => 'cervical-spine', 'zone' => 'torso', 'svg' => ['cervical-spine']],
            ['hy' => 'Կրծքային հատված', 'ru' => 'Грудной отдел позвоночника', 'en' => 'Thoracic spine', 'is_paired' => false, 'slug' => 'thoracic-spine', 'zone' => 'torso', 'svg' => ['thoracic-spine']],
            ['hy' => 'Գոտկային հատված', 'ru' => 'Поясничный отдел позвоночника', 'en' => 'Lumbar spine', 'is_paired' => false, 'slug' => 'lumbar-spine', 'zone' => 'torso', 'svg' => ['lumbar-spine']],
            ['hy' => 'Անրակ', 'ru' => 'Ключица', 'en' => 'Clavicle', 'is_paired' => true, 'slug' => 'clavicle', 'zone' => 'torso', 'svg' => ['clavicle-l', 'clavicle-r']],
            ['hy' => 'Ուսահոդ', 'ru' => 'Плечевой сустав', 'en' => 'Shoulder joint', 'is_paired' => true, 'slug' => 'shoulder-joint', 'zone' => 'upper_limbs', 'svg' => ['shoulder-l', 'shoulder-r']],
            ['hy' => 'Բազկոսկր', 'ru' => 'Плечевая кость', 'en' => 'Humerus', 'is_paired' => true, 'slug' => 'humerus', 'zone' => 'upper_limbs', 'svg' => ['humerus-l', 'humerus-r']],
            ['hy' => 'Ծղիկոսկր', 'ru' => 'Локтевая кость', 'en' => 'Ulna', 'is_paired' => true, 'slug' => 'ulna', 'zone' => 'upper_limbs', 'svg' => ['ulna-l', 'ulna-r']],
            ['hy' => 'Ճաճանչոսկր', 'ru' => 'Лучевая кость', 'en' => 'Radius', 'is_paired' => true, 'slug' => 'radius', 'zone' => 'upper_limbs', 'svg' => ['radius-l', 'radius-r']],
            ['hy' => 'Դաստակ', 'ru' => 'Кисть', 'en' => 'Hand', 'is_paired' => true, 'slug' => 'hand', 'zone' => 'upper_limbs', 'svg' => ['hand-l', 'hand-r']],
            ['hy' => 'Կոնք', 'ru' => 'Таз', 'en' => 'Pelvis', 'is_paired' => true, 'slug' => 'pelvis', 'zone' => 'lower_limbs', 'svg' => ['pelvis-l', 'pelvis-r']],
            ['hy' => 'Կոնքազդրային հոդ', 'ru' => 'Тазобедренный сустав', 'en' => 'Hip joint', 'is_paired' => true, 'slug' => 'hip-joint', 'zone' => 'lower_limbs', 'svg' => ['hip-l', 'hip-r']],
            ['hy' => 'Ազդրոսկր', 'ru' => 'Бедренная кость', 'en' => 'Femur', 'is_paired' => true, 'slug' => 'femur', 'zone' => 'lower_limbs', 'svg' => ['femur-l', 'femur-r']],
            ['hy' => 'Ծնկան հոդ', 'ru' => 'Коленный сустав', 'en' => 'Knee joint', 'is_paired' => true, 'slug' => 'knee-joint', 'zone' => 'lower_limbs', 'svg' => ['knee-l', 'knee-r']],
            ['hy' => 'Ոլոք', 'ru' => 'Большеберцовая кость', 'en' => 'Tibia', 'is_paired' => true, 'slug' => 'tibia', 'zone' => 'lower_limbs', 'svg' => ['tibia-l', 'tibia-r']],
            ['hy' => 'Նրբոլոք', 'ru' => 'Малоберцовая кость', 'en' => 'Fibula', 'is_paired' => true, 'slug' => 'fibula', 'zone' => 'lower_limbs', 'svg' => ['fibula-l', 'fibula-r']],
            ['hy' => 'Ոտնաթաթ', 'ru' => 'Стопа', 'en' => 'Foot', 'is_paired' => true, 'slug' => 'foot', 'zone' => 'lower_limbs', 'svg' => ['foot-l', 'foot-r']],
        ];

        foreach ($bodyParts as $index => $part) {
            BodyPart::create([
                'name' => [
                    'en' => $part['en'],
                    'ru' => $part['ru'],
                    'hy' => $part['hy'],
                ],
                'slug' => $part['slug'],
                'skeleton_zone' => $part['zone'],
                'is_paired' => $part['is_paired'],
                'svg_element_ids' => $part['svg'],
                'sort_order' => $index,
                'is_active' => true,
            ]);
        }
    }
}
