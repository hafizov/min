<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'user_id',
        'original',
        'short',
        'expiration',
        'is_active'
    ];
}
