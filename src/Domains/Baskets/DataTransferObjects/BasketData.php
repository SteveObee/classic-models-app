<?php

namespace Domains\Baskets\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class BasketData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $customer_id,
        /** @var DataCollection<BasketItemData> */
        public readonly ?DataCollection $basket_items
    ) {}
}