<?php

namespace AbdullahFaqeir\LaravelRating\Traits\Like;

use AbdullahFaqeir\LaravelRating\Models\Rating;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @property \Illuminate\Support\Collection<int, Rating> $likes
 */
trait Likeable
{
    public function likes(): MorphMany
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function likesDislikesCount(): int
    {
        return $this->likes()
                    ->count();
    }

    public function likesCount(): int
    {
        return $this->likes()
                    ->where('value', 1)
                    ->count();
    }

    public function dislikesCount(): int
    {
        return $this->likes()
                    ->where('value', 0)
                    ->count();
    }
}
