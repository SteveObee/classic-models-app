<?php

namespace App\Http\Web\Controllers\Customer;

use App\Http\Web\Controllers\Controller;
use Domains\Baskets\DataTransferObjects\BasketData;
use Domains\Baskets\Models\Basket;
use Domains\Customers\DataTransferObjects\CustomerData;
use Domains\Customers\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function __construct(protected CustomerService $customerService) {
    }

    public function store(CustomerData $data, Request $request) {
        $cookie = $this->customerService->create($data, $request);

        return back()->with([
            'message' => 'Address Stored',
            'timestamp' => now()
        ])->cookie($cookie);
    }

    public function basket(Int $id) : BasketData {
        $basket = Basket::where('customer_id', Auth::user()->customer_id)->first();

        return BasketData::from($basket);
    }
}
