<?php

namespace Domains\Baskets\Models;

use App\Casts\Currency;
use Database\Factories\BasketItemFactory;
use Domains\Products\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BasketItem extends Model
{
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return BasketItemFactory::new();
    }

    protected $fillable = [
        'id',
        'basket_id',
        'product_code',
        'price_each',
        'quantity'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i',
        'updated_at' => 'datetime:Y-m-d h:i'
    ];

    public function basket() : BelongsTo {
        return $this->belongsTo(Basket::class);
    }

    public function product() : HasOne {
        return $this->hasOne(Product::class, 'productCode', 'product_code');
    }
}