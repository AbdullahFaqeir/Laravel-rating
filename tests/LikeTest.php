<?php

namespace AbdullahFaqeir\LaravelRatings\Tests;

use AbdullahFaqeir\LaravelRating\Tests\Models\Post;
use AbdullahFaqeir\LaravelRating\Tests\Models\User;
use AbdullahFaqeir\LaravelRating\Tests\TestCase;

class LikeTest extends TestCase
{
    /** @test */
    public function user_can_like_likable_model(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);

        $user->like($post);

        $this->assertCount(1, $user->likes);
    }

    /** @test */
    public function user_can_dislike_likable_model(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);

        $user->dislike($post);

        $this->assertCount(1, $user->likes);
    }

    /** @test */
    public function user_can_return_total_likes_count(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $user2 = User::query()
                     ->create(['name' => 'test2']);
        $post = Post::query()
                    ->create(['name' => 'test post']);

        $user->like($post);
        $user2->like($post);

        $this->assertEquals(2, $post->likesCount());
    }

    /** @test */
    public function it_can_return_liked_items_for_a_user(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);
        $post2 = Post::query()
                     ->create(['name' => 'test post2']);

        $user->like($post);
        $user->dislike($post2);

        $this->assertEquals('test post', $user->liked()
                                              ->first()->name);
    }

    /** @test */
    public function it_can_return_disliked_items_for_a_user(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);
        $post2 = Post::query()
                     ->create(['name' => 'test post2']);

        $user->like($post);
        $user->dislike($post2);

        $this->assertEquals('test post2', $user->disliked()
                                               ->first()->name);
    }

    /** @test */
    public function it_can_return_all_liked_disliked_items_for_a_user(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);
        $post2 = Post::query()
                     ->create(['name' => 'test post2']);

        $user->like($post);
        $user->dislike($post2);

        $this->assertCount(2, $user->likedDisliked());
    }
}
