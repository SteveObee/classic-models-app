<?php

namespace Domains\Products\Models;

use App\Builders\ProductLineBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductLine extends Model
{
    use HasFactory;

    protected $table = 'productlines';

    protected $primaryKey = 'productLine';

    protected $keyType = 'string';

    public function getAllLinesWithProductCounts($productScales = []) : Collection {
        return $this->select('productLine')
            ->withCount(['products as productCount' => function ($query) use ($productScales) {
                $productScales ? $query->whereIn('product_scale_id', $productScales) : $query;
            }])
            ->get();
    }

    public function products(): HasMany {
        return $this->hasMany(Product::class, 'productLine', 'productLine');
    }

    public function newEloquentBuilder($query): ProductLineBuilder
    {
        return new ProductLineBuilder($query);
    }
}
