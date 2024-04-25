<?php

namespace App\Actions\User;

use App\Models\User;
use Domains\Customers\Models\Customer;

class AssociateUserWithCustomerAction
{
    public static function execute(User $user, Customer $customer) : User {
        $user->customer_id = $customer->customerNumber;
        $user->save();

        return $user;
    }
}
