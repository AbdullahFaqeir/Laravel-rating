<?php

namespace AbdullahFaqeir\LaravelRating\Traits\Vote;

use AbdullahFaqeir\LaravelRating\Models\Rating;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @property \Illuminate\Support\Collection<int, Rating> $votes
 */
trait Votable
{
    public function votes(): MorphMany
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function totalVotesCount(): int
    {
        return $this->votes()
                    ->count();
    }

    public function upVotesCount(): int
    {
        return $this->votes()
                    ->where('value', 1)
                    ->count();
    }

    public function downVotesCount(): int
    {
        return $this->votes()
                    ->where('value', 0)
                    ->count();
    }

    public function votesDiff(): int
    {
        return $this->upVotesCount() - $this->downVotesCount();
    }
}
