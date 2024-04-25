<?php

namespace Domains\Baskets\Actions;

use App\Models\User;
use Domains\Baskets\Models\Basket;

class CountBasketItemsAction
{
    public static function execute(User $user) {
        return Basket::where('customer_id', $user->customer_id)
            ->withCount('basketItems')
            ->first()
            ->basket_items_count;
    }
}
