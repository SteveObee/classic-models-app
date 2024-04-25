<?php

namespace Domains\Orders\DataTransferObjects;

use Spatie\LaravelData\Data;

class OrderDetailData extends Data
{
    public function __construct(
        public ?int $orderNumber,
        public readonly string $productCode,
        public readonly int $quantityOrdered,
        public readonly string $priceEach,
        public readonly int $orderLineNumber,
        public readonly ?string $totalCost
    ) {
    }
}
