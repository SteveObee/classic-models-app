<?php

namespace Domains\Orders\Models;

use Domains\Orders\Models\OrderDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'orderNumber';

    protected $fillable = [
        'orderNumber',
        'orderDate',
        'requiredDate',
        'shippedDate',
        'status',
        'comments',
        'customerNumber'
    ];
    
    public function orderDetails() : HasMany {
        return $this->hasMany(OrderDetail::class, 'orderNumber', 'orderNumber')->orderBy('orderLineNumber');
    }
}
