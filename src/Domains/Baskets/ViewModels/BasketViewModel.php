<?php

namespace Domains\Baskets\ViewModels;

use App\Models\User;
use Domains\Baskets\Models\Basket;
use Domains\Baskets\Services\BasketService;
use Domains\Customers\Actions\CheckIfExistingCustomer;
use Domains\Guests\Actions\CountGuestBasketItemsAction;
use Domains\Guests\Services\GuestService;
use Domains\Shared\ViewModels\ViewModel;
use Illuminate\Http\Request;

class BasketViewModel extends ViewModel
{
    public function __construct(
        public readonly ?User $user,
        public readonly Request $request,
        public readonly BasketService $basketService)
    {
    }
    
    public function basket() : ?Array {
        if (!CheckIfExistingCustomer::execute($this->user)) {
            $guestService = new GuestService();
            $basket = $guestService->basket($this->request);
            return $basket->toArray();
        }
        
        return $this->user->basket
            ->load('basketItems.product')
            ->loadSum('basketItems as basket_total', 'item_sum')
            ->toArray();      
    }

    public function basketItemCount() : Int {
        return $this->basketService->BasketItemsCount($this->user, $this->request);
    }

    public function isCustomer() : Bool {
        return CheckIfExistingCustomer::execute($this->user) ? true : false;
    }
}
