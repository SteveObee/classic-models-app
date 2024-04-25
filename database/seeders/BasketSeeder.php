<?php

namespace Database\Seeders;

use Domains\Baskets\Models\Basket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $basket = new Basket();
        
        $basket->customer_id = 141;

        $basket->save();
    }
}
