<?php

namespace Tests\Unit;

use App\Models\Checkout;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
//use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use DatabaseTransactions;
    protected $product;

    public function setUp():void
    {
        parent::setUp();
        //Artisan::call('migrate:fresh --env=testing');
        $this->createProducts();
    }

    public function testCase_1()
    {
        $pricing_rules = [
            'FR1' => ['getOneFree'],
            'SR1' => ['bulk_discount', '3' , '4.50']
        ];

        $co = new Checkout($pricing_rules);
        $co->scan('FR1');
        $co->scan('FR1');
        $co->scan('FR1');
        $co->scan('SR1');
        $co->scan('CF1');

        $this->assertEquals(22.45, $co->getFinalCost(), 'No coinciden los totales');

    }
    public function testCase_2()
    {
        $pricing_rules = [
            'FR1' => ['getOneFree'],
            'SR1' => ['bulk_discount', '3' , '4.50']
        ];

        $co = new Checkout($pricing_rules);
        $co->scan('FR1');
        $co->scan('FR1');

        $this->assertEquals(3.11, $co->getFinalCost(), 'No coinciden los totales');
    }

    public function testCase_3()
    {
        $pricing_rules = [
            'FR1' => ['getOneFree'],
            'SR1' => ['bulk_discount', '3' , '4.50']
        ];

        $co = new Checkout($pricing_rules);
        $co->scan('SR1');
        $co->scan('SR1');
        $co->scan('FR1');
        $co->scan('SR1');

        $this->assertEquals(16.61, $co->getFinalCost(), 'No coinciden los totales');
    }

    private function createProducts()
    {
        $prod1 = new Product();
        $prod1->product_code = "FR1";
        $prod1->name = 'Fruit tea';
        $prod1->price = 3.11;
        $prod1->save();

        $prod1 = new Product();
        $prod1->product_code = "SR1";
        $prod1->name = 'Strawberries';
        $prod1->price = 5.00;
        $prod1->save();

        $prod1 = new Product();
        $prod1->product_code = "CF1";
        $prod1->name = 'Coffee';
        $prod1->price = 11.23;
        $prod1->save();
    }
}
