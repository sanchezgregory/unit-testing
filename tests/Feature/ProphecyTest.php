<?php

namespace Tests\Feature;

use App\Models\BladeDirective;
use App\Models\RussianCache;
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
        // Es una instancia de Prophesize object relacionada a BladeDirective
        // Si se necesita que sea la clase propiamente se concatena ->reveal() al final.
        $directive = $this->prophesize(BladeDirective::class);

        $directive->foo()->shouldBeCalled(); // Se espera que el metodo foo sea llamado (profetiza)

        $directive->reveal()->foo();  // Ejecutamos el metodo realmente (revelacion)
    }

    public function test_example_2()
    {
        // Si se necesita que un metodo debe ser llamado
        $directive = $this->prophesize(BladeDirective::class);
        // Obligamos a retornar foobar, pero no se debe hacer en un test
        $directive->foo('bar')->shouldBeCalled()->willReturn('foobar'); // Se espera que el metodo foo reciba bar como parametro y retorne foobar
        $response = $directive->reveal()->foo('bar');  // Ejecutamos el metodo realmente con el parametro bar
        $this->assertEquals('foobar', $response); // esperamos que retorne foobar
    }

    public function test_example_3()
    {
        // Crear un aprophecy con dependencia de la clase RussianCache
        $cache = $this->prophesize(RussianCache::class);
        // Se llama a reveal para convertir $cache en vez de un objeto de tipo Prophecy que se su mismo tipo
        $directive = new BladeDirective($cache->reveal());
        // Para esa dependencia, se espera que el metodo ->has() sea llamado
        $cache->has('cache-key')->shouldBeCalled();

        // Se comprueba que una vez invoque el metodo setUp, éste llame al metodo has del objeto cache, y se comprueba que realmente se ejecute
        $directive->setUp('cache-key');
    }
}
