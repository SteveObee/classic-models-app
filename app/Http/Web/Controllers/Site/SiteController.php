<?php 

namespace App\Http\Web\Controllers\Site;

use App\Http\Web\Controllers\Controller;
use Domains\Baskets\ViewModels\OrderableBasketViewModel;
use Domains\Baskets\Models\Basket;
use Domains\Baskets\Services\BasketService;
use Domains\Guests\Services\GuestService;
use Domains\Orders\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class SiteController extends Controller
{
    public function __construct(
        protected BasketService $basketService,
        protected GuestService $guestService
    ) {
    }

    public function checkout(Request $request) : Response {
        return Inertia::render('Checkout', [
            'model' => new OrderableBasketViewModel(
                $this->basketService,
                $this->guestService, 
                Auth::user(), 
                $request)
        ]);
    }

    public function confirmation(Request $request) : Response {
        return Inertia::render('Confirmation', [
            'order' => Order::where('customerNumber', Auth::user()->customer_id)->latest('created_at')->first(),
            'basket_item_count' => $this->basketService->BasketItemsCount($request->user(), $request)
        ]);
    }
}
