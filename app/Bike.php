<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description', 'city', 'price', 'photo','user_id'];
}
