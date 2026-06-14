<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use App\Models\BodyPart;
use App\Models\Category;
use App\Models\News;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Categories ──────────────────────────────────────────────
        $orthopedics = Category::create([
            'name'       => ['hy' => 'Օրթոպեդիա', 'ru' => 'Ортопедия', 'en' => 'Orthopedics'],
            'slug'       => 'orthopedics',
            'type'       => 'orthopedics',
            'sort_order' => 1,
            'icon_svg'   => null,
        ]);

        $traumatology = Category::create([
            'name'       => ['hy' => 'Վնասաբանություն', 'ru' => 'Травматология', 'en' => 'Traumatology'],
            'slug'       => 'traumatology',
            'type'       => 'traumatology',
            'sort_order' => 2,
            'icon_svg'   => null,
        ]);

        $instruments = Category::create([
            'name'       => ['hy' => 'Գործիքներ', 'ru' => 'Инструменты', 'en' => 'Instruments'],
            'slug'       => 'instruments',
            'type'       => 'instruments',
            'sort_order' => 3,
            'icon_svg'   => null,
        ]);

        Category::create([
            'name'       => ['hy' => 'Ծնկան հոդի համակարգ', 'ru' => 'Система коленного сустава', 'en' => 'Knee Joint System'],
            'slug'       => 'knee-joint',
            'type'       => 'orthopedics',
            'parent_id'  => $orthopedics->id,
            'sort_order' => 1,
        ]);

        Category::create([
            'name'       => ['hy' => 'Կոնքազդրային հոդի համակարգ', 'ru' => 'Система тазобедренного сустава', 'en' => 'Hip Joint System'],
            'slug'       => 'hip-joint',
            'type'       => 'orthopedics',
            'parent_id'  => $orthopedics->id,
            'sort_order' => 2,
        ]);

        Category::create([
            'name'       => ['hy' => 'Ոսկրի թիթեղներ', 'ru' => 'Костные пластины', 'en' => 'Bone Plates'],
            'slug'       => 'bone-plates',
            'type'       => 'traumatology',
            'parent_id'  => $traumatology->id,
            'sort_order' => 1,
        ]);

        // ── Body Parts (17 bones from translation dictionary) ──────
        $bodyPartsData = [
            ['name' => ['hy' => 'Ծնոտ', 'ru' => 'Челюсть', 'en' => 'Jaw'], 'slug' => 'jaw', 'skeleton_zone' => 'head', 'is_paired' => false, 'svg_element_ids' => ['челюсть'], 'sort_order' => 1],
            ['name' => ['hy' => 'Պարանոցային հատված', 'ru' => 'Шейный отдел позвоночника', 'en' => 'Cervical spine'], 'slug' => 'cervical-spine', 'skeleton_zone' => 'torso', 'is_paired' => false, 'svg_element_ids' => ['шейный отдел позвоночника'], 'sort_order' => 2],
            ['name' => ['hy' => 'Կրծքային հատված', 'ru' => 'Грудной отдел позвоночника', 'en' => 'Thoracic spine'], 'slug' => 'thoracic-spine', 'skeleton_zone' => 'torso', 'is_paired' => false, 'svg_element_ids' => ['грудной отдел позвоночника'], 'sort_order' => 3],
            ['name' => ['hy' => 'Գոտկային հատված', 'ru' => 'Поясничный отдел позвоночника', 'en' => 'Lumbar spine'], 'slug' => 'lumbar-spine', 'skeleton_zone' => 'torso', 'is_paired' => false, 'svg_element_ids' => ['поясничный отдел позвоночника'], 'sort_order' => 4],
            ['name' => ['hy' => 'Անրակ', 'ru' => 'Ключица', 'en' => 'Clavicle'], 'slug' => 'clavicle', 'skeleton_zone' => 'upper_limbs', 'is_paired' => true, 'svg_element_ids' => ['ключица1', 'ключица2'], 'sort_order' => 5],
            ['name' => ['hy' => 'Ուսահոդ', 'ru' => 'Плечевой сустав', 'en' => 'Shoulder joint'], 'slug' => 'shoulder-joint', 'skeleton_zone' => 'upper_limbs', 'is_paired' => true, 'svg_element_ids' => [], 'sort_order' => 6],
            ['name' => ['hy' => 'Բազկոսկր', 'ru' => 'Плечевая кость', 'en' => 'Humerus'], 'slug' => 'humerus', 'skeleton_zone' => 'upper_limbs', 'is_paired' => true, 'svg_element_ids' => ['плечевая кость', 'плечевая кость-1'], 'sort_order' => 7],
            ['name' => ['hy' => 'Ծղիկոսկր', 'ru' => 'Локтевая кость', 'en' => 'Ulna'], 'slug' => 'ulna', 'skeleton_zone' => 'upper_limbs', 'is_paired' => true, 'svg_element_ids' => ['локтевая кость1', 'локтевая кость2'], 'sort_order' => 8],
            ['name' => ['hy' => 'Ճաճանչոսկր', 'ru' => 'Лучевая кость', 'en' => 'Radius'], 'slug' => 'radius', 'skeleton_zone' => 'upper_limbs', 'is_paired' => true, 'svg_element_ids' => [], 'sort_order' => 9],
            ['name' => ['hy' => 'Դաստակ', 'ru' => 'Кисть', 'en' => 'Hand'], 'slug' => 'hand', 'skeleton_zone' => 'upper_limbs', 'is_paired' => true, 'svg_element_ids' => ['кисть1', 'кисть2'], 'sort_order' => 10],
            ['name' => ['hy' => 'Կոնք', 'ru' => 'Таз', 'en' => 'Pelvis'], 'slug' => 'pelvis', 'skeleton_zone' => 'lower_limbs', 'is_paired' => true, 'svg_element_ids' => ['таз1', 'таз2'], 'sort_order' => 11],
            ['name' => ['hy' => 'Կոնքազդրային հոդ', 'ru' => 'Тазобедренный сустав', 'en' => 'Hip joint'], 'slug' => 'hip-joint-bone', 'skeleton_zone' => 'lower_limbs', 'is_paired' => true, 'svg_element_ids' => [], 'sort_order' => 12],
            ['name' => ['hy' => 'Ազդրոսկր', 'ru' => 'Бедренная кость', 'en' => 'Femur'], 'slug' => 'femur', 'skeleton_zone' => 'lower_limbs', 'is_paired' => true, 'svg_element_ids' => ['бедренная кость1', 'бедренная кость2'], 'sort_order' => 13],
            ['name' => ['hy' => 'Ծնկան հոդ', 'ru' => 'Коленный сустав', 'en' => 'Knee joint'], 'slug' => 'knee-joint-bone', 'skeleton_zone' => 'lower_limbs', 'is_paired' => true, 'svg_element_ids' => ['коленный сустав1', 'коленный сустав2'], 'sort_order' => 14],
            ['name' => ['hy' => 'Ոլոք', 'ru' => 'Большеберцовая кость', 'en' => 'Tibia'], 'slug' => 'tibia', 'skeleton_zone' => 'lower_limbs', 'is_paired' => true, 'svg_element_ids' => ['большеберцовая кость1', 'большеберцовая кость2'], 'sort_order' => 15],
            ['name' => ['hy' => 'Նրբոլոք', 'ru' => 'Малоберцовая кость', 'en' => 'Fibula'], 'slug' => 'fibula', 'skeleton_zone' => 'lower_limbs', 'is_paired' => true, 'svg_element_ids' => [], 'sort_order' => 16],
            ['name' => ['hy' => 'Ոտնաթաթ', 'ru' => 'Стопа', 'en' => 'Foot'], 'slug' => 'foot', 'skeleton_zone' => 'lower_limbs', 'is_paired' => true, 'svg_element_ids' => ['стопа1', 'стопа2'], 'sort_order' => 17],
        ];

        foreach ($bodyPartsData as $bp) {
            BodyPart::create($bp);
        }

        $hipJoint   = BodyPart::where('slug', 'hip-joint-bone')->first();
        $kneeJoint  = BodyPart::where('slug', 'knee-joint-bone')->first();
        $humerus    = BodyPart::where('slug', 'humerus')->first();
        $thoracic   = BodyPart::where('slug', 'thoracic-spine')->first();

        // ── About Us ─────────────────────────────────────────────
        AboutUs::firstOrCreate(['id' => 1], [
            'title'       => ['hy' => 'Մեր մասին', 'ru' => 'О нас', 'en' => 'About Us'],
            'subtitle'    => [
                'hy' => 'Մենք սահմանում ենք որակի նոր չափանիշներ',
                'ru' => 'Мы устанавливаем новые стандарты качества',
                'en' => 'We Set New Standards of Quality',
            ],
            'description' => [
                'hy' => '<p>Մեր ընկերությունը հիմնադրված է մատուցել բարձրակարգ իմպլանտներ։</p>',
                'ru' => '<p>Наша компания основана с целью предоставить хирургам высококачественные имплантаты.</p>',
                'en' => '<p>Our company was founded to provide surgeons with high-quality implant partners.</p>',
            ],
            'stat1_value' => '50+',
            'stat1_label' => ['hy' => 'Ապրանքներ', 'ru' => 'Продуктов', 'en' => 'Products'],
            'stat2_value' => '40+',
            'stat2_label' => ['hy' => 'Գործընկերներ', 'ru' => 'Партнёров', 'en' => 'Partners'],
            'stat3_value' => '250+',
            'stat3_label' => ['hy' => 'Հաճախорդներ', 'ru' => 'Клиентов', 'en' => 'Clients'],
        ]);

        // ── News ──────────────────────────────────────────────────
        $newsData = [
            [
                'title'             => ['hy' => 'Ոսկրային իմպլանտներ', 'ru' => 'Костные имплантаты', 'en' => 'Bone Implants'],
                'short_description' => [
                    'hy' => 'Նորարարական լուծումներ ոսկրային վերականգման համար.',
                    'ru' => 'Инновационные решения для восстановления костей.',
                    'en' => 'Innovative solutions for your bone recovery and rehabilitation.',
                ],
                'description' => [
                    'hy' => '<p>Մեր նորարարական արտադրանքները համապատասխանում են բժշկական պահանջներին.</p>',
                    'ru' => '<p>Наши инновационные изделия соответствуют медицинским требованиям.</p>',
                    'en' => '<p>Our innovative products meet full medical requirements.</p>',
                ],
                'slug'         => 'bone-implants-' . Str::random(4),
                'published_at' => now()->subDays(2),
            ],
            [
                'title'             => ['hy' => 'Նոր արտադրանքներ', 'ru' => 'Новые продукты', 'en' => 'New Products'],
                'short_description' => [
                    'hy' => 'Ներկայացնում ենք մեր նոր իմպլանտները.',
                    'ru' => 'Мы рады представить наши новейшие имплантаты.',
                    'en' => 'We are pleased to introduce our newest implants.',
                ],
                'description' => [
                    'hy' => '<p>Մեր իմպլանտները արտադրվում են ISO ստանդարտներին համապատասխան.</p>',
                    'ru' => '<p>Наши имплантаты производятся по стандартам ISO.</p>',
                    'en' => '<p>Our implants are manufactured to ISO standards.</p>',
                ],
                'slug'         => 'new-products-' . Str::random(4),
                'published_at' => now()->subDays(7),
            ],
        ];

        foreach ($newsData as $data) {
            News::create($data);
        }

        // ── Products ────────────────────────────────────────────────
        $productsData = [
            [
                'title'       => ['hy' => 'Կոնքազդրային հոդի համակարգ', 'ru' => 'Система тазобедренного сустава', 'en' => 'Hip Joint System'],
                'description' => [
                    'hy' => '<p>Մեր կոնքազդրային հոդի համակարգը նախագծված է բարդ վիրահատությունների համար:</p>',
                    'ru' => '<p>Наша система тазобедренного сустава для реконструктивных операций.</p>',
                    'en' => '<p>Our hip joint system is designed for complex reconstructive surgeries.</p>',
                ],
                'slug'        => 'hip-joint-system',
                'category_id' => $orthopedics->id,
                'is_featured' => true,
                '_body_parts' => [$hipJoint?->id, $kneeJoint?->id],
            ],
            [
                'title'       => ['hy' => 'Ծնկան հոդի համակարգ', 'ru' => 'Система коленного сустава', 'en' => 'Knee Joint System'],
                'description' => [
                    'hy' => '<p>Մեր ծնկան հոդի համակարգը ապահովում է երկարաժամկետ հուսալիություն:</p>',
                    'ru' => '<p>Наша система коленного сустава обеспечивает надёжность.</p>',
                    'en' => '<p>Our knee joint system provides long-term reliability.</p>',
                ],
                'slug'        => 'knee-joint-system',
                'category_id' => $orthopedics->id,
                'is_featured' => true,
                '_body_parts' => [$kneeJoint?->id],
            ],
            [
                'title'       => ['hy' => 'Ոսկրի թիթեղնակ', 'ru' => 'Костная пластина', 'en' => 'Bone Plate'],
                'description' => [
                    'hy' => '<p>Մեր ոսկրի թիթեղնակները կոտրվածքների կայունացման համար:</p>',
                    'ru' => '<p>Наши костные пластины для стабилизации переломов.</p>',
                    'en' => '<p>Our bone plates are designed for fracture stabilization.</p>',
                ],
                'slug'        => 'bone-plate',
                'category_id' => $traumatology->id,
                'is_featured' => true,
                '_body_parts' => [$humerus?->id],
            ],
            [
                'title'       => ['hy' => 'Ոսկրի պտուրակ', 'ru' => 'Костный винт', 'en' => 'Bone Screw'],
                'description' => [
                    'hy' => '<p>Մեր պտուրակները համապատասխանում են միջազգային ստանդարտներին:</p>',
                    'ru' => '<p>Наши костные винты соответствуют международным стандартам.</p>',
                    'en' => '<p>Our bone screws meet international standards.</p>',
                ],
                'slug'        => 'bone-screw',
                'category_id' => $traumatology->id,
                'is_featured' => false,
                '_body_parts' => [$thoracic?->id],
            ],
            [
                'title'       => ['hy' => 'Վիրահատական գործիքների հավաքածու', 'ru' => 'Хирургический набор', 'en' => 'Surgical Instrument Set'],
                'description' => [
                    'hy' => '<p>Մեր վիրահատական գործիքների հավաքածուն բարձրագույն որակիով:</p>',
                    'ru' => '<p>Наш хирургический набор высококачественного исполнения.</p>',
                    'en' => '<p>Our surgical instrument set is manufactured to highest quality.</p>',
                ],
                'slug'        => 'surgical-instrument-set',
                'category_id' => $instruments->id,
                'is_featured' => false,
                '_body_parts' => [],
            ],
            [
                'title'       => ['hy' => 'Ողնաշարի իմպլանտ', 'ru' => 'Позвоночный имплантат', 'en' => 'Spinal Implant'],
                'description' => [
                    'hy' => '<p>Մեր ողնաշարի իմպլանտները ողնաշարի վերականգման համար:</p>',
                    'ru' => '<p>Наши позвоночные имплантаты для восстановления позвоночника.</p>',
                    'en' => '<p>Our spinal implants are designed for spinal reconstruction.</p>',
                ],
                'slug'        => 'spinal-implant',
                'category_id' => $orthopedics->id,
                'is_featured' => true,
                '_body_parts' => [$thoracic?->id],
            ],
        ];

        foreach ($productsData as $data) {
            $bodyPartIds = array_filter($data['_body_parts'] ?? []);
            unset($data['_body_parts']);
            $product = Product::create($data);
            if ($bodyPartIds) {
                $product->bodyParts()->attach($bodyPartIds);
            }
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('  - 6 categories (3 main + 3 sub)');
        $this->command->info('  - 17 body parts');
        $this->command->info('  - 1 about us singleton');
        $this->command->info('  - 2 news items');
        $this->command->info('  - 6 products');
    }
}
