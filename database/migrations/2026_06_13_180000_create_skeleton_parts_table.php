<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skeleton_parts', function (Blueprint $table) {
            $table->id();
            $table->string('svg_element_id')->unique()->comment('Matches the id attribute on the <g>/<path> in allbody.svg');
            $table->string('name_hy')->comment('Armenian bone name shown in tooltip');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skeleton_parts');
    }
};
