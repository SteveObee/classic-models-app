<?php

namespace Database\Seeders;

use Domains\Products\Models\Product;
use Illuminate\Broadcasting\EncryptedPrivateChannel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTimestampSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::get()
            ->each(function (Product $product, int $key) {
                $newDate = fake()->dateTimeBetween('-1 years', 'now');

                $product->created_at = $newDate;
            });

        foreach ($products as $product) {
            $product->save();
        }
    }
}
