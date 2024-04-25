<?php

namespace Domains\Baskets\Actions;

use App\Models\User;
use Domains\Baskets\Models\Basket;

class CreateBasketAction
{
    public static function execute(User $user) : Basket {
        return Basket::create(['customer_id' => $user->customer_id]);
    }
}
