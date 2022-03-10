<?php

namespace AbdullahFaqeir\LaravelRating\Traits\Rate;

use Illuminate\Support\Collection;
use AbdullahFaqeir\LaravelRating\LaravelRating;
use AbdullahFaqeir\LaravelRating\LaravelRatingFacade;
use AbdullahFaqeir\LaravelRating\Models\Rating;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @property \Illuminate\Support\Collection<int, Rating> $ratings
 */
trait CanRate
{
    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class, 'model')
                    ->where('type', LaravelRating::TYPE_RATE);
    }

    public function rate($model, $value): Rating|bool
    {
        if ($value === null || $value === false || $value === -1) {
            return $this->unRate($model);
        }

        return LaravelRatingFacade::rate($this, $model, $value, LaravelRating::TYPE_RATE);
    }

    public function unRate($model): bool
    {
        return LaravelRatingFacade::unRate($this, $model, LaravelRating::TYPE_RATE);
    }

    public function getRatingValue($model): ?float
    {
        return LaravelRatingFacade::getRatingValue($this, $model, LaravelRating::TYPE_RATE);
    }

    public function isRated($model): bool
    {
        return LaravelRatingFacade::isRated($this, $model, LaravelRating::TYPE_RATE);
    }

    public function rated(): Collection
    {
        return LaravelRatingFacade::resolveRatedItems($this->ratings);
    }
}
