<?php

namespace Domains\Products\DataTransferObjects;

use Spatie\LaravelData\Data;

class ProductData extends Data
{
    public function __construct(
        public readonly string $productCode,
        public readonly string $productName,
        public readonly string $productLine,
        public readonly string $productScale,
        public readonly ?int $product_scale_id,
        public readonly string $productVendor,
        public readonly string $productDescription,
        public readonly int $quantityInStock,
        public readonly string $buyPrice,
        public readonly string $MSRP,
        public readonly ?int $vendor_id,
        public readonly ?int $image_id                
    ) {
    }
}
