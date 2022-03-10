<?php

namespace AbdullahFaqeir\LaravelRating\Traits\Like;

use Illuminate\Support\Collection;
use AbdullahFaqeir\LaravelRating\LaravelRating;
use AbdullahFaqeir\LaravelRating\LaravelRatingFacade;
use AbdullahFaqeir\LaravelRating\Models\Rating;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @property Collection<int, Rating> $likes
 */
trait CanLike
{
    public function likes(): MorphMany
    {
        return $this->morphMany(Rating::class, 'model')
                    ->where('type', LaravelRating::TYPE_LIKE);
    }

    public function like($model): Rating
    {
        return LaravelRatingFacade::rate($this, $model, 1, LaravelRating::TYPE_LIKE);
    }

    public function dislike($model): Rating
    {
        return LaravelRatingFacade::rate($this, $model, 0, LaravelRating::TYPE_LIKE);
    }

    public function isLiked($model): bool
    {
        return LaravelRatingFacade::isRated($this, $model, LaravelRating::TYPE_LIKE);
    }

    public function liked(): Collection
    {
        $liked = $this->likes()
                      ->where('value', 1)
                      ->get();

        return LaravelRatingFacade::resolveRatedItems($liked);
    }

    public function disliked(): Collection
    {
        $disliked = $this->likes()
                         ->where('value', 0)
                         ->get();

        return LaravelRatingFacade::resolveRatedItems($disliked);
    }

    public function likedDisliked(): Collection
    {
        return LaravelRatingFacade::resolveRatedItems($this->likes);
    }
}
