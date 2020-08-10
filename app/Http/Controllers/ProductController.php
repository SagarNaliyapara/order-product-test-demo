<?php

namespace App\Http\Controllers;

use App\Product;

class ProductController extends Controller
{
    public function list()
    {
        $products = Product::query()->get();
        return view('product.list', compact('products'));
    }
}
