<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function likes(){
        return $this->hasMany('App\Like');
    }

    public function dislikes(){
        return $this->hasMany('App\Dislike');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }


    // friendship that I started
    function friendsOfMine()
    {
        return $this->belongsToMany('App\User', 'user_friends', 'user_id', 'friend_id');

    }

// friendship that I was invited to
    function friendOf()
    {
        return $this->belongsToMany('App\User', 'user_friends', 'friend_id', 'user_id');

    }

//// accessor allowing you call $user->friends
    public function getFriendsAttribute()
    {
        if ( ! array_key_exists('user_friends', $this->relations)) $this->loadFriends();

        return $this->getRelation('user_friends');
    }
//
    protected function loadFriends()
    {
        if ( ! array_key_exists('user_friends', $this->relations))
        {
            $friends = $this->mergeFriends();

            $this->setRelation('user_friends', $friends);
        }
    }

    protected function mergeFriends()
    {
        return $this->friendsOfMine->merge($this->friendOf);
    }







}
