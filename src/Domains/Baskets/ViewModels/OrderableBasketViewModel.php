<?php

namespace Domains\Baskets\ViewModels;

use App\Models\User;
use DateTime;
use Domains\Baskets\Models\Basket;
use Domains\Baskets\Services\BasketService;
use Domains\Customers\Models\Customer;
use Domains\Guests\Actions\RetreiveGuestBasketItemsAction;
use Domains\Guests\Services\GuestService;
use Domains\Shared\ViewModels\ViewModel;
use Illuminate\Http\Request;
use stdClass;

class OrderableBasketViewModel extends ViewModel
{
    public function __construct(
        public readonly BasketService $basketService,
        public readonly GuestService $guestService,
        public readonly User $user,
        public readonly Request $request) {
    }

    public function basket() : Array {
        if (!$this->user->customer_id) {
            return $this->guestService->basket($this->request)->toArray();
        }

        return Basket::where('customer_id', $this->user->customer_id)
            ->with('basketItems.product')
            ->withSum('basketItems as basket_total', 'item_sum')
            ->first()
            ->toArray(); 
    }

    public function dateOptions() {
        $dateArray = [];

        for ($date = 3; $date < 14; $date++) { 
            $dateObj = new stdClass();
            $dateNow = new DateTime();
            $modifiedDate = $dateNow->modify('+' . $date . ' day')->format('Y-m-d');

            $dateObj->value = $modifiedDate;
            $dateObj->text = $modifiedDate;
            array_push($dateArray, $dateObj);
        }

        return $dateArray;
    }

    public function basketItemCount() : Int {
        return $this->basketService->BasketItemsCount($this->user, $this->request);
    }

    public function customer() {
        return Customer::where('customerNumber', $this->user->customer_id)
            ->first();
    }
}
