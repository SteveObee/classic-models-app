<?php

namespace Domains\Guests\Actions;

use Illuminate\Support\Collection;

class CalculateGuestBasketTotalAction
{
    public static function execute(Collection $basket) : Collection {
        $basketItems = $basket->get('basket_items');

        if ($basketItems->isEmpty()) {
            return $basket;            
        }

        $basketItems = $basketItems->map( function (Array $item) {
                $item['item_sum'] = $item['quantity'] * $item['product']['MSRP'];
                return $item;
            });

        $basket->put('basket_items', $basketItems);
        $basket->put('basket_total', $basketItems->sum('item_sum'));

        return $basket;
    }
}
