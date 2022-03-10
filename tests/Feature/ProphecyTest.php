<?php

namespace Tests\Feature;

use App\Models\BladeDirective;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Prophecy\PhpUnit\ProphecyTrait;
use Tests\TestCase;

class ProphecyTest extends TestCase
{
    use ProphecyTrait;


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        // Si se necesita que un metodo debe ser llamado
        $directive = $this->prophesize(BladeDirective::class);

        $directive->foo()->shouldBeCalled();

       $directive->reveal()->foo();

    }
}
