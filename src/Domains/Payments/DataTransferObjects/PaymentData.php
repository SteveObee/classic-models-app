<?php

namespace Domains\Payments\DataTransferObjects;

use Carbon\Carbon;
use DateTime;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class PaymentData extends Data
{
    public function __construct(
        public readonly ?int $customerNumber,
        public readonly string $checkNumber,
        public readonly string $paymentDate,
        public readonly string $amount

    ) {
    }
}
