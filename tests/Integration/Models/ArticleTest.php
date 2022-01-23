<?php

namespace Tests\Integration\Models;

use App\Models\Article;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ArticleTest extends TestCase
{
//    /** @test */
//    public function setUp(): void
//    {
//
//    }

    use DatabaseTransactions;
    /** @test */
    public function it_fetches_trending_article()
    {
        // Se usa DatabaseTransactions para no guardar los cambios en la base y siempre mantener la bd limpia de datos de prueba
        // use DatabaseTransactions


        // Given = Existe en la base de datos
        Article::factory(2)->create();
        $mostPopular = Article::factory()->create(['reads'=> 20]);

        // When = Cuando ejecuto la accion
        $articles = Article::trending();

        // Then = Lo que se espera que pase
        $this->assertEquals($mostPopular->id, $articles->first()->id);
        $this->assertCount(3, $articles);
    }

}
