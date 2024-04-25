<?php

namespace Database\Factories;

use Domains\Baskets\Models\BasketItem;
use Domains\Products\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BasketItem>
 */
class BasketItemFactory extends Factory
{
    protected $model = BasketItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomProduct = Product::all()->random();

        return [
            'basket_id' => 1,
            'product_code' => $randomProduct->productCode,
            'price_each' => $randomProduct->MSRP,
            'quantity' => rand(1,30)
        ];
    }
}
