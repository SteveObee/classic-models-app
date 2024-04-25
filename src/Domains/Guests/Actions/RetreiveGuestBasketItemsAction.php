<?php

namespace Domains\Guests\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RetreiveGuestBasketItemsAction
{
    public static function execute(Request $request) : Collection {
        if (!$request->cookie('basket_items')) {
            return collect([]);
        }

        return collect(unserialize($request->cookie('basket_items')));
    }
}
