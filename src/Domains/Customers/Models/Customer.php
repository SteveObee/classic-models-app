<?php

namespace Domains\Customers\Models;

use Domains\Baskets\Models\Basket;
use Domains\Orders\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customerName',
        'contactLastName',
        'contactFirstName',
        'phone',
        'addressLine1',
        'addressLine2',
        'city',
        'state',
        'postalCode',
        'country'
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'customerNumber';

    protected $table = 'customers';

    /**
     * Get orders for the customer
     *
     */
    public function orders() : HasMany {
        return $this->hasMany(Order::class, 'customerNumber', 'customerNumber');
    }

    public function basket() : HasOne {
        return $this->hasOne(Basket::class, 'customer_id', 'customerNumber');
    }
}
