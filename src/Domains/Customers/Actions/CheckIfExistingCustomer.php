<?php

namespace Domains\Customers\Actions;

use App\Models\User;

class CheckIfExistingCustomer
{
    public static function execute(?User $user) : ?Int {
        return $user ? $user->customer_id : null;
    }
}
