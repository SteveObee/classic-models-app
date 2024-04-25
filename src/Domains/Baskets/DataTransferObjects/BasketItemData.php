<?php

namespace Domains\Baskets\DataTransferObjects;

use Spatie\LaravelData\Data;

class BasketItemData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $basket_id,
        public readonly string $product_code,
        public readonly string $price_each,
        public readonly int $quantity,
        public readonly ?string $item_sum
    ) {}

    public static function rules() : array {
        return [
            'basket_id' => ['required', 'integer'],
            'product_code' => ['required', 'string'],
            'price_each' => ['required', 'string'],
            'quantity' => ['required', 'integer'],
            'item_sum' => ['nullable', 'string']
        ];
    }
}
