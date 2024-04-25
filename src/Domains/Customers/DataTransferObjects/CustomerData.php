<?php

namespace Domains\Customers\DataTransferObjects;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class CustomerData extends Data
{
    public function __construct(
        public readonly ?Int $customerNumber,
        public readonly string $customerName,
        public readonly string $contactLastName,
        public readonly string $contactFirstName,
        public readonly string $phone,
        public readonly string $addressLine1,
        public readonly ?string $addressLine2,
        public readonly string $city,
        public readonly ?string $state,
        public readonly ?string $postalCode,
        public readonly string $country,
        public readonly ?Int $salesRepEmployeeNumber,
        public readonly ?string $creditLimit
    ) {
    }

    public static function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:50'],
            'contact_last_name' => ['required', 'string', 'max:50'],
            'contact_first_name' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', 'max:50'],
            'address_line1' => ['required', 'string', 'max:50'],
            'address_line2' => ['nullable', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:50'],
            'state' => ['nullable', 'string', 'max:50'],
            'postal_code' => ['nullable', 'string', 'max:15'],
            'country' => ['required', 'string', 'max:50'],
        ];
    }
}
