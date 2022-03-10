<?php

namespace AbdullahFaqeir\LaravelRating\Traits\Vote;

use Illuminate\Support\Collection;
use AbdullahFaqeir\LaravelRating\LaravelRating;
use AbdullahFaqeir\LaravelRating\LaravelRatingFacade;
use AbdullahFaqeir\LaravelRating\Models\Rating;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @property \Illuminate\Support\Collection<int, Rating> $votes
 */
trait CanVote
{
    public function votes(): MorphMany
    {
        return $this->morphMany(Rating::class, 'model')
                    ->where('type', LaravelRating::TYPE_VOTE);
    }

    public function upVote($model): Rating
    {
        return LaravelRatingFacade::rate($this, $model, 1, LaravelRating::TYPE_VOTE);
    }

    public function downVote($model): Rating
    {
        return LaravelRatingFacade::rate($this, $model, 0, LaravelRating::TYPE_VOTE);
    }

    public function isVoted($model): bool
    {
        return LaravelRatingFacade::isRated($this, $model, LaravelRating::TYPE_VOTE);
    }

    public function getVotingValue($model): ?float
    {
        return LaravelRatingFacade::getRatingValue($this, $model, LaravelRating::TYPE_VOTE);
    }

    public function upVoted(): Collection
    {
        $upVoted = $this->votes()
                        ->where('value', 1)
                        ->get();

        return LaravelRatingFacade::resolveRatedItems($upVoted);
    }

    public function downVoted(): Collection
    {
        $downVoted = $this->votes()
                          ->where('value', 0)
                          ->get();

        return LaravelRatingFacade::resolveRatedItems($downVoted);
    }

    public function voted(): Collection
    {
        return LaravelRatingFacade::resolveRatedItems($this->votes);
    }
}
