<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'isAdmin',
    ];

    protected $attributes = [
        'isAdmin' => false,
    ];


//    /**
//     * If you would like to make all attributes mass assignable, you may define the $guarded property as an empty array:
//     * The attributes that aren't mass assignable.
//     *
//     * @var array
//     */
//    protected $guarded = [];
}
