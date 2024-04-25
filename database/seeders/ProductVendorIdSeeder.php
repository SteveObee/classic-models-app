<?php

namespace Database\Seeders;

use Domains\Products\Models\Product;
use Domains\Vendors\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductVendorIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::get()
            ->each(function ($product, $key) {
                $vendorId = Vendor::select('id')
                    ->where('vendorName', '=', $product->productVendor)
                    ->get();

                $product->vendor_id = $vendorId->value('id');
            });

        foreach ($products as $product) {
            $product->save();
        }
    }
}
