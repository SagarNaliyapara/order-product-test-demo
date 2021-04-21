<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        // fetch paginated products with quantity > 1
        $products = Product::query()
            ->where('quantity', '>', 1)
            ->paginate();

        return ProductResource::collection($products);
    }

    public function show(Product $product): ProductResource
    {
        // this will abort if quantity of product is 1 or less
        abort_if($product->quantity <= 1, 412, 'Out of stock');

        // return successfully
        return new ProductResource($product);
    }

    public function update(Product $product, Request $request): ProductResource
    {
        // validate given quantity
        $request->validate([
            'quantity' => 'required|numeric'
        ]);

        // update product quantity with given current available quantity
        $product->quantity = $request->quantity;
        $product->save();

        return new ProductResource($product);
    }
}
