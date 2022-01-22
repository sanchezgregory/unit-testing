<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use Tests\TestCase;

class OrderTest extends TestCase
{

    protected $order;

    public function setUp(): void
    {
        $this->order = $this->createOrderWithProducts();
    }

    /** @test */
    public function order_has_products()
    {
        // $this->assertEquals('2', count($order->products()));  // it's good
        $this->assertCount('2' , $this->order->products()); // it's better

    }

    /** @test */
    public function order_can_determine_the_total_of_all_its_products()
    {
        $this->assertEquals(26, $this->order->total());
    }

    private function createOrderWithProducts()
    {
        $order = new Order();

        $product = new Product('asd1', 21);
        $product2 = new Product('asd2', 5);
        $order->add($product);
        $order->add($product2);

        return $order;
    }

}
