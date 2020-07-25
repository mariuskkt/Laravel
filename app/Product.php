<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'EAN', 'type', 'weight', 'color', 'image', 'user_id'];
}