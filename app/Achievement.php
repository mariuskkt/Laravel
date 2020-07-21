<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description', 'points'];

    public function users()
    {
        return $this->belongsToMany(User::class,'users_achievements');
    }
}
