<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LikesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_user_can_like_a_post()
    {
        // given I have a post
        $post = Post::factory()->create();

        // and a user
        $user = User::factory()->create();

        // and that user is logged in
        $this->actingAs($user);

        // when they like a post
        $post->like();

        // then we should see evidence in the database and the post should be liked
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post),
        ]);

        $this->assertTrue($post->isLiked());

    }

    /** @test */
    public function a_user_can_unlike_a_post()
    {
        // given I have a post
        $post = Post::factory()->create();

        // and a user
        $user = User::factory()->create();

        // and that user is logged in
        $this->actingAs($user);

        // when they like a post
        $post->like();
        $post->unlike();

        // then we should see evidence in the database and the post should be liked
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'likeable_id' => $post->id,
            'likeable_type' => get_class($post),
        ]);

        $this->assertFalse($post->isLiked());
    }

    /** @test */
    public function a_user_may_toggle_a_post_like_status()
    {
        // given I have a post
        $post = Post::factory()->create();

        // and a user
        $user = User::factory()->create();

        // and that user is logged in
        $this->actingAs($user);

        // when they like a post
        $post->toggle();

        $this->assertTrue($post->isLiked());

        $post->toggle();

        $this->assertFalse($post->isLiked());
    }

    /** @test */
    public function a_post_knows_how_many_likes_it_has()
    {
        // given I have a post
        $post = Post::factory()->create();

        // and a user
        $user = User::factory()->create();

        // and that user is logged in
        $this->actingAs($user);

        // when they like a post
        $post->toggle();

        $this->assertEquals(1, $post->likesCount);
    }
}
