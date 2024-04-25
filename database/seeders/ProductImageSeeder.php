<?php

namespace Database\Seeders;

use Domains\Images\Models\Image;
use Domains\Products\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = Image::select('id', 'product_line_id')
            ->get();

        Product::select('productCode', 'productLine')
            ->get()
            ->each( function ($product) use ($images) {
                $image = $images->where('product_line_id', $product->productLine)
                    ->random();

                $product->image_id = $image->id;

                $product->save();               
            });
    }
}
