<?php

namespace AbdullahFaqeir\LaravelRating\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use AbdullahFaqeir\LaravelRating\Traits\Like\Likeable;
use AbdullahFaqeir\LaravelRating\Traits\Rate\Rateable;
use AbdullahFaqeir\LaravelRating\Traits\Vote\Votable;

class Post extends Model
{
    use Rateable;
    use Votable;
    use Likeable;

    protected $guarded = [];

    protected $table = 'users';
}
