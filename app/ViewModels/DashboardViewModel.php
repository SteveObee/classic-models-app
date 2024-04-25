<?php

namespace App\ViewModels;

use App\Models\User;
use Domains\Customers\Models\Customer;
use Domains\Orders\Models\Order;

class DashboardViewModel extends ViewModel
{
    public function __construct(
        protected User $user
    ) {
    }

    public function user() : User {
        return $this->user;
    }

    public function customer() : ?Customer {
        return Customer::where('customerNumber', $this->user->customer_id)->first();
    }

    public function currentOrders() : Int {
        return Order::query()
            ->where('customerNumber', $this->user->customer_id)
            ->whereNotIn('status', ['shipped', 'cancelled'])
            ->count();
    }

    public function completedOrders() : Int  {
        return Order::query()
            ->where('customerNumber', $this->user->customer_id)
            ->whereIn('status', ['shipped', 'cancelled'])
            ->count();
    }
}
