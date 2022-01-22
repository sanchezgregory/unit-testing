<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * ******* Execute test with vendor/bin/phpunit = run all tests********
     * ******* Execute test with vendor/bin/phpunit tests/Feature/ProductTest.php  = run this test only********
     */

    public function setUp(): void
    {
        $this->product = new Product('asd', '59');
    }

    /** @test */
    public function product_has_name()
    {
        $this->assertEquals('asd', $this->product->name());
    }

    /** @test */
    public function product_has_cost()
    {
        $this->assertEquals('59', $this->product->cost());
    }
}
