<?php

namespace App\Services;

use App\Notifications\VisitorNotification;
use App\Notifications\WarehouseNotification;
use App\Order;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;

class OrderService
{
    public function createOrder($data)
    {
        $order = Order::query()
            ->create(Arr::only($data, [
                'email',
                'shipping_address_1',
                'shipping_address_2',
                'shipping_address_3',
                'city',
                'country_code',
                'zip_postal_code',
            ]));

        $products = $data['products'];
        $quantities = $data['quantities'];
        for ($product = 0; $product < count($products); $product++) {
            if ($products[$product] != '' && $quantities[$product] > 0) {
                $order->products()
                    ->attach($products[$product], ['quantity' => $quantities[$product]]);
            }
        }

        Notification::send('warehouse@example.org', new WarehouseNotification($data, $products));
        Notification::send($data['email'], new VisitorNotification($products));
    }
}