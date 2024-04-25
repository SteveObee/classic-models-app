<?php

namespace Domains\Guests\Actions;

use Illuminate\Http\Request;

class DeleteGuestBasketItemAction
{
    public static function execute(Int $id, Request $request) {
        $basketItems = RetreiveGuestBasketItemsAction::execute($request);
        
        $basketItems = $basketItems->reject( function ($item) use ($id) { 
            return $item["id"] == $id;
        })->values();

        return cookie('basket_items', serialize($basketItems->toArray()), strtotime( '+30 days' ));
    }
}
