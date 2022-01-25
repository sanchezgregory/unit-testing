<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LikesTest extends TestCase
{
    use DatabaseTransactions;

    protected $post;

    public function setUp():void
    {
        parent::setUp();

       //  $this->post = Post::factory()->create(); // It's good but, the  helper is better

        /**
         *  using an own helper and adding it to composer.json. Section files
         * "autoload-dev": {
                "psr-4": {
                "Tests\\": "tests/"
            },
            "files": [
                    "tests/Helpers/functions.php"
                ]
            },
         */
        $this->post = createPost();

        $this->signIn();
    }

    /** @test */
    public function a_user_can_like_a_post()
    {
        $this->post->like();

        // then we should see evidence in the database and the post should be liked
        $this->assertDatabaseHas('likes', [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post),
        ]);

        $this->assertTrue($this->post->isLiked());
    }

    /** @test */
    public function a_user_can_unlike_a_post()
    {
        $this->post->like();
        $this->post->unlike();

        // then we should see evidence in the database and the post should be liked
        $this->assertDatabaseMissing('likes', [
            'user_id' => $this->user->id,
            'likeable_id' => $this->post->id,
            'likeable_type' => get_class($this->post),
        ]);

        $this->assertFalse($this->post->isLiked());
    }

    /** @test */
    public function a_user_may_toggle_a_post_like_status()
    {
        // when they like a post
        $this->post->toggle();

        $this->assertTrue($this->post->isLiked());

        $this->post->toggle();

        $this->assertFalse($this->post->isLiked());
    }

    /** @test */
    public function a_post_knows_how_many_likes_it_has()
    {
        $this->post->toggle();

        $this->assertEquals(1, $this->post->likesCount);
    }
}
