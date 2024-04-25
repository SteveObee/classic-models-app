<?php

namespace Domains\Products\ViewModels;

use App\Models\User;
use Domains\Baskets\Models\Basket;
use Domains\Baskets\Models\BasketItem;
use Domains\Baskets\Services\BasketService;
use Domains\Customers\Actions\CheckIfExistingCustomer;
use Domains\Guests\Actions\CountGuestBasketItemsAction;
use Domains\Guests\Actions\RetreiveGuestBasketItemsAction;
use Domains\Products\Models\Product;
use Domains\Shared\ViewModels\ViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductViewModel extends ViewModel
{
    public function __construct(
        public readonly Product $product,
        public readonly ?User $user,
        public readonly Request $request,
        public readonly BasketService $basketService
        ) {
    }

    public function product() : Product {
        return $this->product;
    }

    public function basketItem() : ?Array {
        if (!CheckIfExistingCustomer::execute($this->user)) {
            $basketItems = RetreiveGuestBasketItemsAction::execute($this->request);

            return $basketItems->where('product.productCode', $this->product->productCode)->first();
        }

        $basketItem = BasketItem::query()
            ->whereRelation('basket', 'customer_id', $this->user->customer_id)
            ->whereRelation('product', 'productCode', $this->product->productCode)
            ->first();

        return $basketItem ? $basketItem->toArray() : $basketItem;
    }

    public function basketItemCount() : Int {
        return $this->basketService->BasketItemsCount($this->user, $this->request);
    }
}
