<?php

namespace Domains\Baskets\Actions;

use Domains\Baskets\DataTransferObjects\BasketData;
use Domains\Baskets\DataTransferObjects\BasketItemData;
use Domains\Baskets\Models\Basket;
use Domains\Baskets\Models\BasketItem;
use Domains\Guests\Actions\DeleteGuestBasketItemAction;
use Domains\Guests\Actions\RetreiveGuestBasketItemsAction;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PopulateNewBasketAction
{
    public static function execute(Basket $basket, Request $request) : Collection {
        $basketItems = RetreiveGuestBasketItemsAction::execute($request);

        $basketItems = $basketItems->map(function ($item) use ($basket) {
            $item['id'] = null;
            $item['basket_id'] = $basket->id;
            $item['product_code'] = $item['product']['productCode'];            
            $item['price_each'] = $item['product']['MSRP'];
            return $item;
        });

        $basketItems = BasketItemData::collect($basketItems);

        $basketItems->each( fn ($item) => BasketItem::create($item->toArray()));

        return $basketItems;
    }
}

