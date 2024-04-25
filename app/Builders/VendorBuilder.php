<?php

namespace App\Builders;

class VendorBuilder extends AbstractBuilder 
{
    public function countProducts(String $productScales = Null, String $productLines = Null, String $searchString = Null) : Self 
    {
        return $this->withCount(['products as productCount' => function ($query) use ($productScales, $productLines, $searchString) {
            $query->when($productScales, fn ($query) => $query->whereIn('product_scale_id', explode(',', $productScales))); 
            $query->when($productLines, fn ($query) => $query->whereIn('productLine', explode(',', $productLines)));
            $query->when($searchString, fn ($query) => $query->whereLike('productName', $searchString)); 
        }]);
    }    
}
