<?php

namespace App\Http\Web\Controllers\Basket;

use App\Http\Web\Controllers\Controller;
use Domains\Baskets\Actions\EmptyBasketAction;
use Domains\Baskets\Models\Basket;
use Domains\Baskets\Services\BasketService;
use Domains\Baskets\ViewModels\BasketViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class BasketController extends Controller
{
    public function __construct(
        protected BasketService $basketService
    ) {}

    public function index(Request $request) : Response {
        return Inertia::render('Basket', [
            'model' => new BasketViewModel(
                Auth::user() ?? null,
                $request,
                $this->basketService
                )
        ]);
    }

    public function empty(string $id) {
        EmptyBasketAction::execute($id);

        return back()->with([
            'message' => 'Basket Emptied',
            'timestamp' => now()
        ]);
    }

    public function emptyGuest() {
        $cookie = cookie('basket_items', null, -1);

        return back()->with([
            'message' => 'Basket Emptied',
            'timestamp' => now()
        ])->cookie($cookie);
    }
}
