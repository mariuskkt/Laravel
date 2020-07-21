<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBike extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description', 'city', 'price', 'photo','user_id'];
}
