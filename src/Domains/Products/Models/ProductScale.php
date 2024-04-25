<?php

namespace Domains\Products\Models;

use App\Builders\ProductScaleBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductScale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['productScale'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'product_scale_id');
    }

    public function newEloquentBuilder($query): ProductScaleBuilder
    {
        return new ProductScaleBuilder($query);
    }
}
