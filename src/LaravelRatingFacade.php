<?php

namespace AbdullahFaqeir\LaravelRating;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Illuminate\Database\Eloquent\Model;
use AbdullahFaqeir\LaravelRating\Models\Rating;

/**
 * @see \AbdullahFaqeir\LaravelRating\LaravelRating
 *
 * @method static Rating rate(Model $rateable, Model $rater, $value, string $rateType)
 * @method static boolean unRate(Model $rateable, Model $rater, string $rateType)
 * @method static float|null getRatingValue(Model $rateable, Model $rater, string $rateType)
 * @method static boolean isRated(Model $rateable, Model $rater, string $rateType)
 * @method static Collection resolveRatedItems(mixed $ratings)
 */
class LaravelRatingFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravelRating';
    }
}
