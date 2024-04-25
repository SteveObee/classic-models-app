<?php

namespace App\Http\Web\Controllers\Product;

use App\Http\Web\Controllers\Controller;
use Domains\Baskets\Services\BasketService;
use Domains\Guests\Actions\CountGuestBasketItemsAction;
use Domains\Products\Models\Product;
use Domains\Products\Models\ProductLine;
use Domains\Products\Models\ProductScale;
use Domains\Products\ViewModels\ProductViewModel;
use Domains\Vendors\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(
        protected Product $product,
        protected ProductLine $productLine,
        protected Vendor $vendor,
        protected ProductScale $productScale,
        protected BasketService $basketService) {
    }

    public function index(Request $request) {
        $productLines = $this->productLine
        ->select('productLine')
        ->countProducts($request->search_term, $request->product_scales)
        ->get();
        
        $vendors = $this->vendor
        ->select('id', 'vendorName')
        ->countProducts($request->product_scales, $request->product_lines, $request->search_term)
        ->get();
        
        $productScales = $this->productScale
        ->select('id', 'productScale')
        ->countProducts($request->product_lines, $request->search_term)
        ->orderBy('id')
        ->get();
        
        $products = $this->product->select('productName', 'productLine', 'productScale', 'productVendor', 'MSRP', 'productCode', 'created_at', 'image_id')
            ->when($request->search_term, fn ($query) => $query->whereLike('ProductName', $request->search_term))
            ->when($request->product_lines, fn ($query) => $query->whereIn('productLine', explode(',', $request->product_lines))) 
            ->when($request->vendor_ids, fn ($query) => $query->whereIn('vendor_id', explode(',', $request->vendor_ids))) 
            ->when($request->product_scales, fn ($query) => $query->whereIn('product_scale_id', explode(',', $request->product_scales))) 
            ->when($request->sort_method, 
                fn ($query) => $query->orderBy(explode(',', $request->sort_method)[0], explode(',', $request->sort_method)[1]),
                fn ($query) => $query->orderBy('created_at', 'desc'))
            ->paginate($request->per_page ?? 6);
        
        return Inertia::render('Products', [
            'products' => $products,
            'productLineOptions' => $productLines,
            'productVendorOptions' => $vendors,
            'productScaleOptions' => $productScales,
            'queryVendorIds' => $request->has('vendor_ids') ? $vendors->where('productCount', '>', 0)->whereIn('id', explode(',', $request->vendor_ids))->pluck('id') : $vendors->pluck('id'),
            'queryProductScaleIds' => $request->has('product_scales') ? explode(',', $request->product_scales) : $productScales->pluck('id'),
            'queryProductLines' => $request->has('product_lines') ? explode(',', $request->product_lines) : $productLines->pluck('productLine'),
            'querySortMethod' => $request->sort_method ? explode(',', $request->sort_method) : ['created_at', 'desc'],
            'searchTerm' => $request->search_term ?? '',
            'guestBasketItemCount' => $this->basketService->BasketItemsCount(Auth::user(), $request)
        ]);       
    }



    public function show(Product $product, Request $request) {
        
        return Inertia::render('Product', [
           'model' => new ProductViewModel($product, Auth::user(), $request, $this->basketService)
        ]);
    }
}
