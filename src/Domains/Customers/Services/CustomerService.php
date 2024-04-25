<?php

namespace Domains\Customers\Services;

use App\Actions\User\AssociateUserWithBasketAction;
use App\Actions\User\AssociateUserWithCustomerAction;
use Domains\Baskets\Actions\PopulateNewBasketAction;
use Domains\Baskets\Actions\CreateBasketAction;
use Domains\Customers\Actions\CreateCustomerAction;
use Domains\Customers\DataTransferObjects\CustomerData;
use Domains\Guests\Actions\EmptyGuestBasketAction;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Http\Request;

class CustomerService
{
    public function create(CustomerData $data, Request $request) : Cookie {
        $customer = CreateCustomerAction::execute($data, $request);
        
        $user = AssociateUserWithCustomerAction::execute($request->user(), $customer);
        
        $basket = CreateBasketAction::execute($user);

        AssociateUserWithBasketAction::execute($request->user(), $basket);

        PopulateNewBasketAction::execute($basket, $request);

        return EmptyGuestBasketAction::execute();
    }
}
