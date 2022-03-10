<?php

namespace AbdullahFaqeir\LaravelRatings\Tests;

use Illuminate\Database\Eloquent\Relations\Relation;
use AbdullahFaqeir\LaravelRating\Tests\Models\Post;
use AbdullahFaqeir\LaravelRating\Tests\Models\User;
use AbdullahFaqeir\LaravelRating\Tests\TestCase;

class RatingTest extends TestCase
{
    /** @test */
    public function user_can_rate_rateable_model(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);

        $user->rate($post, 5);

        $this->assertCount(1, $user->ratings);
    }

    /** @test */
    public function user_can_unrate_rateable_model(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);

        $user->rate($post, 5);
        $user->unRate($post);

        $this->assertCount(0, $user->ratings);
    }

    /** @test */
    public function ratable_model_can_be_unrated_if_passed_false_or_null_to_rate_method(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);

        $user->rate($post, 5);
        $user->rate($post, -1);

        $user->rate($post, 5);
        $user->rate($post, null);

        $user->rate($post, 5);
        $user->rate($post, false);

        $user->rate($post, 5);
        $user->rate($post, 10);

        $this->assertEquals(10, $user->getRatingValue($post));
        $this->assertCount(1, $user->ratings);
    }

    /** @test */
    public function it_can_return_rating_value_for_user_for_rateable_model(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);

        $user->rate($post, 5);

        $this->assertEquals(5, $user->getRatingValue($post));
    }

    /** @test */
    public function it_can_update_user_rating_if_already_rated(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);

        $user->rate($post, 5);
        $this->assertEquals(5, $user->getRatingValue($post));

        $user->rate($post, 10);
        $this->assertEquals(10, $user->getRatingValue($post));
    }

    /** @test */
    public function it_can_return_avg_for_rateable_model(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $user2 = User::query()
                     ->create(['name' => 'test2']);
        $post = Post::query()
                    ->create(['name' => 'test post']);

        $user->rate($post, 5);
        $user2->rate($post, 10);

        $this->assertEquals(7.5, $post->ratingsAvg());
    }

    /** @test */
    public function it_can_return_count_for_rateable_model(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $user2 = User::query()
                     ->create(['name' => 'test2']);
        $post = Post::query()
                    ->create(['name' => 'test post']);

        $user->rate($post, 5);
        $user2->rate($post, 10);

        $this->assertEquals(2, $post->ratingsCount());
    }

    /** @test */
    public function it_can_return_rated_items_for_a_user(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);
        $post2 = Post::query()
                     ->create(['name' => 'test post2']);

        $user->rate($post, 5);
        $user->rate($post2, 10);

        $this->assertCount(2, $user->rated());
    }

    /** @test */
    public function it_can_work_with_morph_maps(): void
    {
        Relation::$morphMap = [
            'post' => Post::class,
            'user' => User::class,
        ];


        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);

        $user->rate($post, 5);

        $this->assertCount(1, $user->rated());
    }
}
