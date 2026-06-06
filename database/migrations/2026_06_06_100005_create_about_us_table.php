<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // translatable
            $table->json('subtitle'); // translatable
            $table->json('description'); // translatable (rich text)
            // Stats
            $table->string('stat1_value')->default('50+');
            $table->json('stat1_label'); // translatable e.g. "Products"
            $table->string('stat2_value')->default('40+');
            $table->json('stat2_label');
            $table->string('stat3_value')->default('250+');
            $table->json('stat3_label');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
