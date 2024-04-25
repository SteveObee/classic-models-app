<?php

namespace Domains\Baskets\Actions;

use Domains\Baskets\Models\BasketItem;

class DeleteBasketItemAction
{
    public static function execute($id) : void {
        $basketItem = BasketItem::find($id);
        
        $basketItem->delete();
    }
}
