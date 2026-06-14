<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('body_parts', function (Blueprint $table) {
            $table->boolean('is_paired')->default(false)->after('skeleton_zone');
            $table->json('svg_element_ids')->nullable()->after('is_paired');
        });
    }

    public function down(): void
    {
        Schema::table('body_parts', function (Blueprint $table) {
            $table->dropColumn(['is_paired', 'svg_element_ids']);
        });
    }
};
