<?php

namespace Domains\Customers\Actions;

use Domains\Customers\DataTransferObjects\CustomerData;
use Domains\Customers\Models\Customer;
use Illuminate\Http\Request;

class CreateCustomerAction
{
    public static function execute(CustomerData $data, Request $request) : Customer {
        $newCustomerNumber = Customer::max('customerNumber') + 1;
        $customer = new Customer($data->all());
        $customer->customerNumber = $newCustomerNumber;
        $customer->save();
            
        return Customer::find($newCustomerNumber);
    }
}
