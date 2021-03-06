<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function likes(){
        return $this->hasMany('App\Like');
    }

    public function dislikes(){
        return $this->hasMany('App\Dislike');
    }

    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('created_at', 'desc');
    }
}
