<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('body_part_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('body_part_id')->constrained()->onDelete('cascade');
            $table->unique(['product_id', 'body_part_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['body_part_id']);
            $table->dropColumn('body_part_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('body_part_id')->nullable()->constrained('body_parts')->onDelete('set null');
        });

        Schema::dropIfExists('body_part_product');
    }
};
