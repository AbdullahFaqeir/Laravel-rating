<?php

namespace AbdullahFaqeir\LaravelRating\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use AbdullahFaqeir\LaravelRating\Traits\Like\CanLike;
use AbdullahFaqeir\LaravelRating\Traits\Rate\CanRate;
use AbdullahFaqeir\LaravelRating\Traits\Vote\CanVote;

class User extends Model
{
    use CanRate;
    use CanVote;
    use CanLike;

    protected $guarded = [];

    protected $table = 'users';
}
