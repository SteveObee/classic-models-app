<?php

namespace Domains\Guests\Actions;

use Illuminate\Http\Request;

class AddGuestBasketItemAction
{
    public static function execute(Array $data, Request $request) {
        $basketItems = RetreiveGuestBasketItemsAction::execute($request);
        $data = array_merge(['id' => $basketItems->max('id') + 1], $data);

        $basketItems->push($data);

        return cookie('basket_items', serialize($basketItems), strtotime( '+30 days' ));
    }
}
