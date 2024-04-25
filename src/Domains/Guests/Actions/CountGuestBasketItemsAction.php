<?php

namespace Domains\Guests\Actions;

use Illuminate\Http\Request;

class CountGuestBasketItemsAction
{
    public static function execute(Request $request) : Int {
        $basketItems = RetreiveGuestBasketItemsAction::execute($request);

        return $basketItems->count() ?? 0;
    }
}
