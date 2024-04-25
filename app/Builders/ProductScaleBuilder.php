<?php

namespace App\Builders;

class ProductScaleBuilder extends AbstractBuilder
{
    public function countProducts(String $productLines = Null, String $searchString = Null) : Self 
    {
        return $this->withCount(['products as productCount' => function ($query) use ($productLines, $searchString) {
            $query->when($productLines, fn ($query) => $query->whereIn('productLine', explode(',', $productLines)));
            $query->when($searchString, fn ($query) => $query->whereLike('productName', $searchString)); 
        }]);
    }  
}
