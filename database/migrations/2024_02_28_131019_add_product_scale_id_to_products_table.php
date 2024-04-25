<?php

use Database\Seeders\ProductScaleIdSeeder;
use Domains\Products\Models\ProductScale;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->after('productScale', function (Blueprint $table) {
                $table->foreignIdFor(ProductScale::class)
                    ->nullable()
                    ->constrained();
            });    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['product_scale_id']);
            $table->dropColumn('product_scale_id');
        });
    }
};
