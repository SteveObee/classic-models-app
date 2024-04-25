<?php

namespace Database\Seeders;

use Domains\Products\Models\Product;
use Domains\Products\Models\ProductScale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductScaleIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::get()
            ->each(function ($product, $key) {
                $productScaleId = ProductScale::select('id')
                    ->where('productScale', '=', $product->productScale)
                    ->get();

                $product->product_scale_id = $productScaleId->value('id');
            });

        foreach ($products as $product) {
            $product->save();
        }
    }
}
