<?php

namespace AbdullahFaqeir\LaravelRatings\Tests;

use AbdullahFaqeir\LaravelRating\Tests\Models\Post;
use AbdullahFaqeir\LaravelRating\Tests\Models\User;
use AbdullahFaqeir\LaravelRating\Tests\TestCase;

class VotingTest extends TestCase
{
    /** @test */
    public function user_can_up_vote_votable_model(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);

        $user->upVote($post);


        $this->assertCount(1, $user->votes);
        $this->assertEquals(1, $user->getVotingValue($post));
    }

    /** @test */
    public function user_can_down_vote_votable_model()
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);

        $user->downVote($post);

        $this->assertCount(1, $user->votes);
        $this->assertEquals(0, $user->getVotingValue($post));
    }

    /** @test */
    public function it_returns_total_up_voting_count(): void
    {
        $user = User::create(['name' => 'test']);
        $user2 = User::create(['name' => 'test2']);
        $post = Post::create(['name' => 'test post']);

        $user->upVote($post);
        $user2->upVote($post);

        $this->assertEquals(2, $post->upVotesCount());
    }

    /** @test */
    public function it_returns_total_down_voting_count(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $user2 = User::query()
                     ->create(['name' => 'test2']);
        $post = Post::query()
                    ->create(['name' => 'test post']);

        $user->downVote($post);
        $user2->downVote($post);

        $this->assertEquals(2, $post->downVotesCount());
    }

    /** @test */
    public function it_returns_total_votes_count(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $user2 = User::query()
                     ->create(['name' => 'test2']);
        $post = Post::query()
                    ->create(['name' => 'test post']);

        $user->upVote($post);
        $user2->downVote($post);

        $this->assertEquals(2, $post->totalVotesCount());
    }

    /** @test */
    public function it_returns_votes_diff(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $user2 = User::query()
                     ->create(['name' => 'test2']);
        $post = Post::query()
                    ->create(['name' => 'test post']);

        $user->upVote($post);
        $user2->downVote($post);

        $this->assertEquals(0, $post->votesDiff());
    }

    /** @test */
    public function it_can_return_up_voted_items_for_a_user(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);
        $post2 = Post::query()
                     ->create(['name' => 'test post2']);

        $user->upVote($post);
        $user->downVote($post2);

        $this->assertEquals('test post', $user->upVoted()
                                              ->first()->name);
    }

    /** @test */
    public function it_can_return_downvoted_items_for_a_user(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);
        $post2 = Post::query()
                     ->create(['name' => 'test post2']);

        $user->upVote($post);
        $user->downVote($post2);

        $this->assertEquals('test post2', $user->downVoted()
                                               ->first()->name);
    }

    /** @test */
    public function it_can_return_all_voted_items_for_a_user(): void
    {
        $user = User::query()
                    ->create(['name' => 'test']);
        $post = Post::query()
                    ->create(['name' => 'test post']);
        $post2 = Post::query()
                     ->create(['name' => 'test post2']);

        $user->upVote($post);
        $user->downVote($post2);

        $this->assertCount(2, $user->voted());
    }
}
