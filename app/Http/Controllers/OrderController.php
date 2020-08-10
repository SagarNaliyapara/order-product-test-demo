<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @var \App\Services\OrderService
     */
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function create(Request $request)
    {
        $this->orderService->createOrder($request->all());
        return redirect()->route('product.list')->with('success', 'Order created successfully.');
    }
}
