<?php

namespace Domains\Baskets\Actions;

use Domains\Baskets\Models\Basket;

class EmptyBasketAction
{
    public static function execute($id) : void {
        $basket = Basket::find($id);
        
        $basket->basketItems()->delete();
    }
}
