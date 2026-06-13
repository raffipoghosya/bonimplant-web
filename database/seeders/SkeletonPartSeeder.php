<?php

namespace Database\Seeders;

use App\Models\SkeletonPart;
use Illuminate\Database\Seeder;

class SkeletonPartSeeder extends Seeder
{
    /**
     * Maps SVG element IDs (Russian, matching the individual bone SVG filenames)
     * to their correct Armenian medical terms.
     */
    public function run(): void
    {
        $parts = [
            // Jaw
            ['svg_element_id' => 'челюсть',                         'name_hy' => 'Ծնոտ'],

            // Spine sections
            ['svg_element_id' => 'шейный отдел позвоночника',       'name_hy' => 'Պարանոցային հատված'],
            ['svg_element_id' => 'грудной отдел позвоночника',      'name_hy' => 'Կրծքային հատված'],
            ['svg_element_id' => 'поясничный отдел позвоночника',   'name_hy' => 'Գոտկային հատված'],

            // Pelvis (two halves)
            ['svg_element_id' => 'таз1',                            'name_hy' => 'Կոնք'],
            ['svg_element_id' => 'таз2',                            'name_hy' => 'Կոնք'],

            // Clavicles
            ['svg_element_id' => 'ключица1',                        'name_hy' => 'Անրակ'],
            ['svg_element_id' => 'ключица2',                        'name_hy' => 'Անրակ'],

            // Humerus
            ['svg_element_id' => 'плечевая кость',                  'name_hy' => 'Բազկոսկր'],
            ['svg_element_id' => 'плечевая кость-1',                'name_hy' => 'Բազկոսկր'],

            // Forearm (ulna/radius)
            ['svg_element_id' => 'локтевая кость1',                 'name_hy' => 'Նախաբազուկ'],
            ['svg_element_id' => 'локтевая кость2',                 'name_hy' => 'Նախաբազուկ'],

            // Hands
            ['svg_element_id' => 'кисть1',                          'name_hy' => 'Դաստակ'],
            ['svg_element_id' => 'кисть2',                          'name_hy' => 'Դաստակ'],

            // Femur
            ['svg_element_id' => 'бедренная кость1',                'name_hy' => 'Ազդրոսկր'],
            ['svg_element_id' => 'бедренная кость2',                'name_hy' => 'Ազդրոսկր'],

            // Knee joints
            ['svg_element_id' => 'коленный сустав1',                'name_hy' => 'Ծնկան հոդ'],
            ['svg_element_id' => 'коленный сустав2',                'name_hy' => 'Ծնկան հոդ'],

            // Tibia/fibula (shin)
            ['svg_element_id' => 'большеберцовая кость1',           'name_hy' => 'Ոլոք'],
            ['svg_element_id' => 'большеберцовая кость2',           'name_hy' => 'Ոլոք'],

            // Feet
            ['svg_element_id' => 'стопа1',                          'name_hy' => 'Ոտնաթաթ'],
            ['svg_element_id' => 'стопа2',                          'name_hy' => 'Ոտնաթաթ'],
        ];

        foreach ($parts as $part) {
            SkeletonPart::updateOrCreate(
                ['svg_element_id' => $part['svg_element_id']],
                ['name_hy' => $part['name_hy'], 'is_active' => true]
            );
        }

        $this->command->info('✅ SkeletonPartSeeder: ' . count($parts) . ' parts seeded.');
    }
}
