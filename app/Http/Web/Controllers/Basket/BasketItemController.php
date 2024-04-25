<?php

namespace App\Http\Web\Controllers\Basket;

use App\Http\Web\Controllers\Controller;
use Domains\Baskets\Actions\DeleteBasketItemAction;
use Domains\Baskets\Actions\UpsertBasketItemAction;
use Domains\Baskets\DataTransferObjects\BasketItemData;
use Domains\Guests\Actions\DeleteGuestBasketItemAction;
use Domains\Guests\Actions\AddGuestBasketItemAction;
use Domains\Guests\Actions\CountGuestBasketItemsAction;
use Domains\Guests\Actions\UpdateGuestBasketItemAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BasketItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BasketItemData $data)
    {
        UpsertBasketItemAction::execute($data);

        return back()->with([
            'message' => 'Item Added to Basket',
            'timestamp' => now()
        ]);  
    }

    public function storeGuest(Request $request) {
        $data = $request->all();

        $cookie = AddGuestBasketItemAction::execute($data, $request);

        return back()->cookie($cookie)
            ->with([
                'message' => 'Item Added to Basket',
                'timestamp' => now()
            ]);    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BasketItemData $data, Request $request)
    {
        UpsertBasketItemAction::execute($data);

        return back()->with([
                'message' => 'Quantity Updated',
                'timestamp' => now()
            ]);    
    }

    public function updateGuest(Request $request) : RedirectResponse {
        $cookie = UpdateGuestBasketItemAction::execute($request);

        return back()->cookie($cookie)
            ->with([
                'message' => 'Quantity Updated',
                'timestamp' => now()
            ]);           
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : RedirectResponse
    {
        DeleteBasketItemAction::execute($id);

        return back()->with([
                'message' => 'Basket Item Removed',
                'timestamp' => now()
            ]);
    }

    public function destroyGuest(Int $id, Request $request) {
        $cookie = DeleteGuestBasketItemAction::execute($id, $request);

        return back()->cookie($cookie)
            ->with([
                'message' => 'Basket Item Removed',
                'timestamp' => now()
            ]);
    }
}
