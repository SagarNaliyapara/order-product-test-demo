<?php

namespace App\Http\Controllers;

use App\Notifications\VisitorNotification;
use App\Notifications\WarehouseNotification;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $order = Order::query()
            ->create(Arr::only($request->all(), [
                'email',
                'shipping_address_1',
                'shipping_address_2',
                'shipping_address_3',
                'city',
                'country_code',
                'zip_postal_code',
            ]));

        $products = $request->input('products', []);
        $quantities = $request->input('quantities', []);
        for ($product = 0; $product < count($products); $product++) {
            if ($products[$product] != '' && $quantities[$product] > 0) {
                $order->products()
                    ->attach($products[$product], ['quantity' => $quantities[$product]]);
            }
        }

        Notification::send('warehouse@example.org', new WarehouseNotification($request->all(), $products));
        Notification::send($request->email, new VisitorNotification($products));

        return redirect()->route('product.list')->with('success', 'Order created successfully.');
    }
}
