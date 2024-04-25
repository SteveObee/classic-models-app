<?php

namespace Domains\Orders\Services;

use App\Models\User;
use Domains\Baskets\Actions\EmptyBasketAction;
use Domains\Baskets\Models\Basket;
use Domains\Orders\Actions\UpsertOrderAction;
use Domains\Orders\DataTransferObjects\OrderData;
use Domains\Products\Actions\DecreaseStockLevelAction;

class OrderService
{
    public function placeOrder(OrderData $data, User $user) {
        $order = UpsertOrderAction::execute($data);

        $order->orderDetails
            ->each( fn ($detail) => ( 
                DecreaseStockLevelAction::execute($detail->productCode, $detail->quantityOrdered)
            ));
        
        EmptyBasketAction::execute(
            Basket::where('customer_id', $user->customer_id)
                ->first()->id
            );      
    }
}
