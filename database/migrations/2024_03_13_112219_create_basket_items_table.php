<?php

use Domains\Baskets\Models\Basket;
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
        Schema::create('basket_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Basket::class)
                ->constrained();
            $table->string('product_code', 15)->collation('utf8mb4_0900_ai_ci');
            $table->foreign('product_code')->references('productCode')->on('products');
            $table->decimal('price_each', 10, 2);
            $table->integer('quantity');
            $table->decimal('item_sum', $precision = 10, $scale = 2)
                ->storedAs('price_each * quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basket_items');
    }
};
