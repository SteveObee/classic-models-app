<?php

namespace App\Builders;

class ProductLineBuilder extends AbstractBuilder 
{
    public function countProducts(String $searchString = Null, String $productScales = Null ) : Self 
    {
        return $this->withCount(['products as productCount' => function ($query) use ($productScales, $searchString) {
            $query->when($productScales, fn ($query) => $query->whereIn('product_scale_id', explode(',', $productScales))); 
            $query->when($searchString, fn ($query) => $query->whereLike('productName', $searchString)); 
        }]);
    }
}