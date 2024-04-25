<?php

namespace Domains\Baskets\Models;

use App\Casts\Currency;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Basket extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id'
    ];

    public function basketItems() : HasMany {
        return $this->hasMany(BasketItem::class);
    }
}
