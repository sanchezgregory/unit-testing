<?php

namespace Tests\Unit;

use App\Models\ReverseArray;
use PHPUnit\Framework\TestCase;

class ReverseTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $string = "hola";
        $reverseArray = new ReverseArray($string);

        $this->assertEquals('aloh', $reverseArray->reverse(), 'No coinciden las palabras');
    }
}
