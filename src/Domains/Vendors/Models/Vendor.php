<?php

namespace Domains\Vendors\Models;

use App\Builders\VendorBuilder;
use Database\Factories\VendorFactory;
use Domains\Products\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return VendorFactory::new();
    }

    public function newEloquentBuilder($query): VendorBuilder
    {
        return new VendorBuilder($query);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }
}
