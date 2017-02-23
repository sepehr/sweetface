<?php

namespace SweetFace;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name', 'avatar', 'is_active', 'fb_id', 'fb_token'
    ];

    /**
     * @inheritdoc
     */
    protected $hidden = [
        'fb_token', 'remember_token',
    ];
}
