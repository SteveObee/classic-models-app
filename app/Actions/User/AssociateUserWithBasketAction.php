<?php

namespace App\Actions\User;

use App\Models\User;
use Domains\Baskets\Models\Basket;

class AssociateUserWithBasketAction
{
    public static function execute(User $user, Basket $basket) : User {
        $user->basket_id = $basket->id;
        $user->save();

        return $user;
    }
}
