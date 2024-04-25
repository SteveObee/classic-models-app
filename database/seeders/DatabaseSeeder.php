<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            VendorSeeder::class,
            ProductVendorIdSeeder::class,
            ProductTimestampSeeder::class,
            ProductScaleSeeder::class,
            ProductScaleIdSeeder::class,
            ProductLineSeeder::class,
            ImageSeeder::class,
            ProductImageSeeder::class,
            BasketSeeder::class,
            BasketItemSeeder::class,
            UserBasketIdSeeder::class
        ]);
    }
}
