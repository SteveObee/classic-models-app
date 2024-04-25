<?php

use App\Models\ProductLine;
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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('product_line_id', 50)->collation('utf8mb4_0900_ai_ci')->nullable();
            $table->foreign('product_line_id')->references('productLine')->on('productlines');
            $table->json('src');
            $table->text('alt');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
