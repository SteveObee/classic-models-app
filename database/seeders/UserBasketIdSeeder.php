<?php

namespace Database\Seeders;

use App\Models\User;
use Domains\Baskets\Models\Basket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserBasketIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()
            ->where('customer_id')
            ->each( function ($user) {
                $user->basket_id = Basket::where('customer_id', $user->customer_id)->first()->id;

                $user->save();
            });
    }
}
