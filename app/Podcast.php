<?php

namespace Podium;

use Illuminate\Database\Eloquent\Model;
use Podium\Traits\Publishable;

class Podcast extends Model
{
    use Publishable;

    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'publish_at' => 'datetime',
    ];

}
