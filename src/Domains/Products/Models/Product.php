<?php

namespace Domains\Products\Models;

use App\Builders\ProductBuilder;
use App\Casts\Currency;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'productCode';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    protected $casts = [
        'created_at' => 'datetime:Y-m-d'
    ];

    public function getForAggregation() : Collection {
        return $this->select('vendor_id', 'product_scale_id', 'productLine')->get();
    }

    public function vendorIdCounts() : Collection {
        return $this->countBy('vendor_id');
    }

    public function relatedProductLine() : BelongsTo {
        return $this->belongsTo(ProductLine::class, 'productLine', 'productLine');
    }

    public function newEloquentBuilder($query): ProductBuilder
    {
        return new ProductBuilder($query);
    }
}
