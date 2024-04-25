<?php

namespace Domains\Baskets\Actions;

use Domains\Baskets\DataTransferObjects\BasketItemData;
use Domains\Baskets\Models\BasketItem;

class UpsertBasketItemAction
{
    public static function execute(
        BasketItemData $data
    ) : BasketItem {
        return BasketItem::updateOrCreate(['id' => $data->id], $data->all());
    }
}
