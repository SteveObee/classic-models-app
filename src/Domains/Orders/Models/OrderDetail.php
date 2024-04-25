<?php

namespace Domains\Orders\Models;

use App\Casts\Currency;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Thiagoprz\CompositeKey\HasCompositeKey;

class OrderDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'orderNumber';

    protected $table = 'orderdetails';

    protected $fillable = [
        'orderNumber',
        'productCode',
        'quantityOrdered',
        'priceEach',
        'orderLineNumber'
    ];

    public function order() : BelongsTo {
        return $this->belongsTo(Order::class, 'orderNumber');
    }
}
