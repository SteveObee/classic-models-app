<?php

namespace Database\Seeders;

use Domains\Baskets\Models\BasketItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasketItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $basketItems = BasketItem::factory()->count(5)->make();

        $basketItems->each( fn ($basketItem) => $basketItem->save() );
    }
}
