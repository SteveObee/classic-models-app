<?php

namespace Domains\Orders\Actions;

use Domains\Orders\DataTransferObjects\OrderData;
use Domains\Orders\Models\Order;

class UpsertOrderAction
{
    public static function execute(
        OrderData $data
    ) : Order {

        foreach ($data->orderDetails as $detail) {
            $detail->orderNumber = $data->orderNumber;
        }

        $order = Order::updateOrCreate(
            [
                'orderNumber' =>  $data->orderNumber
            ],
            [
                ...$data->all()
            ]
        );

        $order = Order::find($data->orderNumber);

        $order->orderDetails()
            ->createMany($data->orderDetails->toArray());

        return $order;
    }
}
