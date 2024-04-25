<?php

namespace Domains\Guests\Services;

use Domains\Guests\Actions\CalculateGuestBasketTotalAction;
use Domains\Guests\Actions\RetreiveGuestBasketItemsAction;
use GuzzleHttp\Promise\Each;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GuestService
{
    public function basket(Request $request) : Collection {
        $basket = collect(['basket_items' => []]);

        $basket->put('basket_items', RetreiveGuestBasketItemsAction::execute($request));
        
        return CalculateGuestBasketTotalAction::execute($basket);
    }
}
