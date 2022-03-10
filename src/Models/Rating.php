<?php

namespace AbdullahFaqeir\LaravelRating\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Rating extends Model
{
    protected $guarded = [];

    protected $table = 'ratings';

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function rateable(): MorphTo
    {
        return $this->morphTo();
    }
}
