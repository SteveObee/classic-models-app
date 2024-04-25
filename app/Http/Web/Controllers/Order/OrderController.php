<?php

namespace App\Http\Web\Controllers\Order;

use App\Http\Web\Controllers\Controller;
use Domains\Baskets\Actions\EmptyBasketAction;
use Domains\Baskets\Models\Basket;
use Domains\Orders\Actions\UpsertOrderAction;
use Domains\Orders\DataTransferObjects\OrderData;
use Domains\Orders\Models\Order;
use Domains\Orders\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(Request $request) : Response {

        $per_page = $request->per_page ?? 5;
        $sort = $request->sort ?? 'desc';
        $statusOptions = Order::select('status')->distinct()->get()->pluck('status');
        $queryStatus = $request->has('status') ? explode(',', $request->status) : $statusOptions;

        $orders = Order::with('orderDetails')
            ->where([
                ['customerNumber', '=' , auth()->user()->customer_id]
            ])
            ->whereIn('status', $queryStatus)
            ->withSum('orderDetails as orderTotal', 'totalCost')
            ->orderBy('orderDate', $sort)
            ->paginate($per_page);

        return Inertia::Render('Orders',[
            'orders' => $orders,
            'sort_by' => $sort,
            'status_options' => $statusOptions,
            'query_status' => $queryStatus
        ]);
    }

    public function store(OrderData $data, OrderService $orderService) {
        $orderService->placeOrder($data, Auth::user());

        return to_route('order.confirmation');
    }
}
