<?php

namespace Database\Seeders;

use Domains\Products\Models\Product;
use Domains\Products\Models\ProductScale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductScaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productScales= Product::select('productScale')
            ->distinct()
            ->get()
            ->pluck('productScale')
            ->toArray();

        foreach ($productScales as $key => $scale) {
            ProductScale::create([
                'productScale' => $scale
            ]);
        }
    }
}
