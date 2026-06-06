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
            'name'       => ['hy' => 'Ортопедиа', 'ru' => 'Ортопедия', 'en' => 'Orthopedics'],
            'slug'       => 'orthopedics',
            'type'       => 'orthopedics',
            'sort_order' => 1,
            'icon_svg'   => null,
        ]);

        $traumatology = Category::create([
            'name'       => ['hy' => 'Վnasvanqabanutyun', 'ru' => 'Травматология', 'en' => 'Traumatology'],
            'slug'       => 'traumatology',
            'type'       => 'traumatology',
            'sort_order' => 2,
            'icon_svg'   => null,
        ]);

        $instruments = Category::create([
            'name'       => ['hy' => 'Gortsiqner', 'ru' => 'Инструменты', 'en' => 'Instruments'],
            'slug'       => 'instruments',
            'type'       => 'instruments',
            'sort_order' => 3,
            'icon_svg'   => null,
        ]);

        // Sub-categories
        Category::create([
            'name'       => ['hy' => 'Ոտnayin Hamarasharchutyun', 'ru' => 'Система коленного сустава', 'en' => 'Knee Joint System'],
            'slug'       => 'knee-joint',
            'type'       => 'orthopedics',
            'parent_id'  => $orthopedics->id,
            'sort_order' => 1,
        ]);

        Category::create([
            'name'       => ['hy' => 'Կnkayin Hamarasharchutyun', 'ru' => 'Система тазобедренного сустава', 'en' => 'Hip Joint System'],
            'slug'       => 'hip-joint',
            'type'       => 'orthopedics',
            'parent_id'  => $orthopedics->id,
            'sort_order' => 2,
        ]);

        Category::create([
            'name'       => ['hy' => 'Nnkaragits Plitaner', 'ru' => 'Костные пластины', 'en' => 'Bone Plates'],
            'slug'       => 'bone-plates',
            'type'       => 'traumatology',
            'parent_id'  => $traumatology->id,
            'sort_order' => 1,
        ]);

        // ── Body Parts ───────────────────────────────────────────────
        $bodyParts = [
            ['name' => ['hy' => 'Gndar / Vizi', 'ru' => 'Голова / шея', 'en' => 'Head / Neck'],   'slug' => 'head',        'skeleton_zone' => 'head',        'sort_order' => 1],
            ['name' => ['hy' => 'Qnut / Ogi stura', 'ru' => 'Туловище', 'en' => 'Torso'],          'slug' => 'torso',       'skeleton_zone' => 'torso',       'sort_order' => 2],
            ['name' => ['hy' => 'Veriny Verjabzhutyun', 'ru' => 'Верхние конечности', 'en' => 'Upper Limbs'], 'slug' => 'upper-limbs', 'skeleton_zone' => 'upper_limbs', 'sort_order' => 3],
            ['name' => ['hy' => 'Nerkin Verjabzhutyun', 'ru' => 'Нижние конечности', 'en' => 'Lower Limbs'],  'slug' => 'lower-limbs', 'skeleton_zone' => 'lower_limbs', 'sort_order' => 4],
        ];

        foreach ($bodyParts as $bp) {
            BodyPart::create($bp);
        }

        $lowerLimbs = BodyPart::where('slug', 'lower-limbs')->first();
        $upperLimbs = BodyPart::where('slug', 'upper-limbs')->first();
        $torso      = BodyPart::where('slug', 'torso')->first();

        // ── About Us ─────────────────────────────────────────────────
        AboutUs::firstOrCreate(['id' => 1], [
            'title'       => ['hy' => 'Մեr Mashin', 'ru' => 'О нас', 'en' => 'About Us'],
            'subtitle'    => [
                'hy' => 'Մenk Sahmannum Enk Oraki Nor Chafanishner',
                'ru' => 'Мы устанавливаем новые стандарты качества',
                'en' => 'We Set New Standards of Quality',
            ],
            'description' => [
                'hy' => '<p>Мer yntkerуtyune himnadrvел е mek navatakvi matutsel parzrkakvarg vaztnuvanits hamakvargter, orronk khamamatenden zamanakakits dikayne u anabtelakovni amnrutyune. Menk ogtnagordnum enk miayn lavakovi nyutere u zamanakakits tekhniologhiayner.</p><p>Мer yntkerуtyune himnadrvел е mek navatakvi matutsel parzrkakvarg vaztnuvanits hamakvargter, orronk khamamatenden zamanakakits dikayne u anabtelakovni amnrutyune.</p>',
                'ru' => '<p>Наша компания основана с целью предоставить хирургам высококачественных партнёров, которые соответствуют современному дизайну и безопасности. Мы используем только лучшие материалы и современные технологии.</p><p>Наша компания основана с целью предоставить хирургам высококачественных партнёров, которые соответствуют современному дизайну и безопасности.</p>',
                'en' => '<p>Our company was founded to provide surgeons with high-quality implant partners that meet modern design and safety standards. We use only the finest materials and cutting-edge technologies.</p><p>Our company was founded to provide surgeons with high-quality implant partners that meet modern design and safety standards.</p>',
            ],
            'stat1_value' => '50+',
            'stat1_label' => ['hy' => 'Апранкнер', 'ru' => 'Продуктов', 'en' => 'Products'],
            'stat2_value' => '40+',
            'stat2_label' => ['hy' => 'Гортшнкалнер', 'ru' => 'Партнёров', 'en' => 'Partners'],
            'stat3_value' => '250+',
            'stat3_label' => ['hy' => 'Хачорхортнер', 'ru' => 'Клиентов', 'en' => 'Clients'],
        ]);

        // ── News ──────────────────────────────────────────────────────
        $newsData = [
            [
                'title'             => ['hy' => 'Ускнрайн Импланtner', 'ru' => 'Костные имплантаты', 'en' => 'Bone Implants'],
                'short_description' => [
                    'hy' => 'Инновационные лнот-иmnер, Дтер нуkрayhn annnnutyun вернканgннman hamar.',
                    'ru' => 'Инновационные решения Дтер нуkрayhn annnnutyun вернканgнман гамар.',
                    'en' => 'Innovative solutions for your bone recovery and rehabilitation.',
                ],
                'description' => [
                    'hy' => '<p>Мer navatakvi noot-imer yev orthopaedic lnutner nerakayvum en medicinayi amboghjakan pahanjnavor tuylerin. Mez gntir nkati mez khmbutyan mashi, vori mej asume en ardyunakutyun, khakutyun yev angutyun.</p>',
                    'ru' => '<p>Наши инновационные изделия и ортопедические решения соответствуют полным медицинским требованиям. Обратите внимание на наши материалы, в которых гарантируется эффективность, качество и безопасность.</p>',
                    'en' => '<p>Our innovative products and orthopedic solutions meet full medical requirements. Pay attention to our materials, which guarantee effectiveness, quality and safety.</p>',
                ],
                'slug'         => 'bone-implants-' . Str::random(4),
                'published_at' => now()->subDays(2),
            ],
            [
                'title'             => ['hy' => 'Noor Ordiners', 'ru' => 'Новые продукты', 'en' => 'New Products'],
                'short_description' => [
                    'hy' => 'Мы рады представить наши новейшие имплантаты для лечения переломов.',
                    'ru' => 'Мы рады представить наши новейшие имплантаты для лечения переломов.',
                    'en' => 'We are pleased to introduce our newest implants for fracture treatment.',
                ],
                'description' => [
                    'hy' => '<p>Подробное описание новых продуктов на армянском языке.</p>',
                    'ru' => '<p>Подробное описание новых продуктов на русском языке. Наши имплантаты производятся по стандартам ISO.</p>',
                    'en' => '<p>Detailed description of new products in English. Our implants are manufactured to ISO standards.</p>',
                ],
                'slug'         => 'new-products-' . Str::random(4),
                'published_at' => now()->subDays(7),
            ],
            [
                'title'             => ['hy' => 'Медицинские инновации', 'ru' => 'Медицинские инновации', 'en' => 'Medical Innovations'],
                'short_description' => [
                    'hy' => 'BonImplant выходит на международный рынок с новой линейкой продуктов.',
                    'ru' => 'BonImplant выходит на международный рынок с новой линейкой продуктов.',
                    'en' => 'BonImplant enters the international market with a new product line.',
                ],
                'description' => [
                    'hy' => '<p>Armeniayum artvadrvats BonImplant entanike artak e nerkayacnum international shukayum.</p>',
                    'ru' => '<p>Армянская компания BonImplant выходит на международный рынок.</p>',
                    'en' => '<p>Armenian company BonImplant enters the international market.</p>',
                ],
                'slug'         => 'medical-innovations-' . Str::random(4),
                'published_at' => now()->subDays(14),
            ],
            [
                'title'             => ['hy' => 'ISO Certification', 'ru' => 'Сертификация ISO', 'en' => 'ISO Certification'],
                'short_description' => [
                    'hy' => 'BonImplant получил сертификат ISO 13485 для медицинских изделий.',
                    'ru' => 'BonImplant получил сертификат ISO 13485 для медицинских изделий.',
                    'en' => 'BonImplant has received ISO 13485 certification for medical devices.',
                ],
                'description' => [
                    'hy' => '<p>ISO 13485 сертификать ստացել ենք, ինку хватет на alnagitskova stugel tarber.</p>',
                    'ru' => '<p>Получение сертификата ISO 13485 подтверждает наше стремление к качеству и безопасности.</p>',
                    'en' => '<p>Receiving ISO 13485 certification confirms our commitment to quality and safety.</p>',
                ],
                'slug'         => 'iso-certification-' . Str::random(4),
                'published_at' => now()->subDays(21),
            ],
        ];

        foreach ($newsData as $data) {
            News::create($data);
        }

        // ── Products ──────────────────────────────────────────────────
        $productsData = [
            [
                'title'       => ['hy' => 'Կnkayin Hamarasharchutyun Hip Joint', 'ru' => 'Система тазобедренного сустава', 'en' => 'Hip Joint System'],
                'description' => [
                    'hy' => '<p>Мer navatakvi nnkayin hamarasharchутyune nakhagtsats e tarberim verkangnman armenarkhnoots hamar.</p>',
                    'ru' => '<p>Наша инновационная система тазобедренного сустава разработана для сложных реконструктивных операций.</p>',
                    'en' => '<p>Our innovative hip joint system is designed for complex reconstructive surgeries.</p>',
                ],
                'slug'        => 'hip-joint-system',
                'category_id' => $orthopedics->id,
                'body_part_id'=> $lowerLimbs?->id,
                'is_featured' => true,
            ],
            [
                'title'       => ['hy' => 'Tnkain Jon System', 'ru' => 'Система коленного сустава', 'en' => 'Knee Joint System'],
                'description' => [
                    'hy' => '<p>Мer tnkain jon sistemane navtntsum e mek khimatvakan endgrunelutyan.</p>',
                    'ru' => '<p>Наша система коленного сустава обеспечивает долгосрочную надёжность.</p>',
                    'en' => '<p>Our knee joint system provides long-term reliability and natural movement.</p>',
                ],
                'slug'        => 'knee-joint-system',
                'category_id' => $orthopedics->id,
                'body_part_id'=> $lowerLimbs?->id,
                'is_featured' => true,
            ],
            [
                'title'       => ['hy' => 'Nnkar Plita', 'ru' => 'Костная пластина', 'en' => 'Bone Plate'],
                'description' => [
                    'hy' => '<p>Мер nkar plitaner nakhagtsats en vorojayner khavaqvel.</p>',
                    'ru' => '<p>Наши костные пластины разработаны для стабилизации переломов.</p>',
                    'en' => '<p>Our bone plates are designed for fracture stabilization.</p>',
                ],
                'slug'        => 'bone-plate',
                'category_id' => $traumatology->id,
                'body_part_id'=> $upperLimbs?->id,
                'is_featured' => true,
            ],
            [
                'title'       => ['hy' => 'Nnkar Shur', 'ru' => 'Костный винт', 'en' => 'Bone Screw'],
                'description' => [
                    'hy' => '<p>Мер nnkar shurner nemashkharhin haytnvats en.</p>',
                    'ru' => '<p>Наши костные винты соответствуют международным стандартам.</p>',
                    'en' => '<p>Our bone screws meet international standards for strength and biocompatibility.</p>',
                ],
                'slug'        => 'bone-screw',
                'category_id' => $traumatology->id,
                'body_part_id'=> $torso?->id,
                'is_featured' => false,
            ],
            [
                'title'       => ['hy' => 'Zurchutyun Hastar', 'ru' => 'Хирургический набор', 'en' => 'Surgical Instrument Set'],
                'description' => [
                    'hy' => '<p>Мer zurchutyan hastar parvum en barcr kogekhanum.</p>',
                    'ru' => '<p>Наш хирургический набор выпускается в высококачественном исполнении.</p>',
                    'en' => '<p>Our surgical instrument set is manufactured to the highest quality standards.</p>',
                ],
                'slug'        => 'surgical-instrument-set',
                'category_id' => $instruments->id,
                'body_part_id'=> null,
                'is_featured' => false,
            ],
            [
                'title'       => ['hy' => 'Hognayin Sham', 'ru' => 'Позвоночный имплантат', 'en' => 'Spinal Implant'],
                'description' => [
                    'hy' => '<p>Мер hognayin shamer nakhagtsats en mugnayin verkangnman hamar.</p>',
                    'ru' => '<p>Наши позвоночные имплантаты разработаны для восстановления позвоночника.</p>',
                    'en' => '<p>Our spinal implants are designed for spinal reconstruction and stabilization.</p>',
                ],
                'slug'        => 'spinal-implant',
                'category_id' => $orthopedics->id,
                'body_part_id'=> $torso?->id,
                'is_featured' => true,
            ],
        ];

        foreach ($productsData as $data) {
            Product::create($data);
        }

        $this->command->info('✓ Database seeded successfully!');
        $this->command->info('  - 6 categories (3 main + 3 sub)');
        $this->command->info('  - 4 body parts');
        $this->command->info('  - 1 about us singleton');
        $this->command->info('  - 4 news items');
        $this->command->info('  - 6 products');
    }
}
