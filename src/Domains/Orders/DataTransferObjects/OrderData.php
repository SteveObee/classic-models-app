<?php

namespace Domains\Orders\DataTransferObjects;

use Domains\Orders\Models\Order;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;

class OrderData extends Data
{
    public int|Optional $orderNumber;
    public string|Optional $orderDate;

    public function __construct(
        public readonly string $requiredDate,
        public readonly ?string $shippedDate,
        public readonly string $status,
        public readonly ?string $comments,
        public readonly int $customerNumber,
        /** @var ?DataCollection<OrderDetailData> */
        public readonly ?DataCollection $orderDetails
    ) {
        $this->orderNumber = Order::max('orderNumber') + 1;
        $this->orderDate = date('Y-m-d');
    }
}
