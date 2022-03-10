<?php

namespace AbdullahFaqeir\LaravelRating\Traits\Rate;

use AbdullahFaqeir\LaravelRating\Models\Rating;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @property \Illuminate\Support\Collection<int, Rating> $ratings
 */
trait Rateable
{
    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function ratingsAvg()
    {
        return $this->ratings()
                    ->where('type', 'rate')
                    ->avg('value');
    }

    public function ratingsCount(): int
    {
        return $this->ratings()
                    ->count();
    }
}
