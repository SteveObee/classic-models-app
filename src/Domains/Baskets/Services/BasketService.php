<?php

namespace Domains\Baskets\Services;

use App\Models\User;
use Domains\Baskets\Actions\CountBasketItemsAction;
use Domains\Guests\Actions\CountGuestBasketItemsAction;
use Illuminate\Http\Request;

class BasketService
{
    public function BasketItemsCount(?User $user, Request $request) {
        $customer = $user ? $user->customer_id : null;

        if (!$customer) {
            return CountGuestBasketItemsAction::execute($request);
        }

        return CountBasketItemsAction::execute($user);
    }
}
