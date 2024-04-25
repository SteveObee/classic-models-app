<?php

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
        Schema::table('productlines', function (Blueprint $table) {
            $table->string('pexels_collection_id', 10);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productlines', function (Blueprint $table) {
            $table->dropColumn('pexels_collection_id');
        });
    }
};
