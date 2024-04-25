<?php

namespace Domains\Products\Actions;

use Domains\Products\Models\Product;

class DecreaseStockLevelAction
{
    public static function execute(String $productCode, Int $amount) : void {
        Product::where('productCode', $productCode)
            ->decrement('quantityInStock', $amount);
    }
}
