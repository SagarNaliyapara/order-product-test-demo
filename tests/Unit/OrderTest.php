<?php

namespace Tests\Unit;

use App\Order;
use App\Product;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        Product::query()->truncate();
        Order::query()->truncate();
        factory(Product::class)->create();
        $orderService = new OrderService();
        $orderService->createOrder([
            'email' => 'test@email.com',
            'shipping_address_1' => 'test line1',
            'shipping_address_2' => 'test line2',
            'shipping_address_3' => 'test line3',
            'city' => 'city',
            'country_code' => 'test',
            'zip_postal_code' => 'testZip',
            'products' => [
                1, 2, 3,
            ],
            'quantities' => [
                3, 5, 8,
            ],
        ]);

        $this->assertEquals(1, Order::query()->count());
    }
}
