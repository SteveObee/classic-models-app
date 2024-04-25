<?php

namespace Domains\Guests\Actions;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;

class UpdateGuestBasketItemAction
{
    public static function execute(Request $request) : Cookie {
        $basketItems = RetreiveGuestBasketItemsAction::execute($request);

        $updatedBasket = $basketItems->map( function ($item) use ($request) {
            if ($item["id"] == $request->id) {
                return $item = $request->all();
            }

            return $item;
        });

        return cookie('basket_items', serialize($updatedBasket->toArray()));
    }
}
