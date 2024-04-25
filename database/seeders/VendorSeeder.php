<?php

namespace Database\Seeders;

use Domains\Products\Models\Product;
use Domains\Vendors\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productsVendors= Product::select('productVendor')
            ->distinct()
            ->get()
            ->pluck('productVendor')
            ->toArray();

        foreach ($productsVendors as $key => $vendor) {
            Vendor::factory()->create([
                'vendorName' => $vendor
            ]);
        }
        
    }
}
