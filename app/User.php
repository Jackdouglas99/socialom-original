<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    public function Posts()
    {
        return $this->hasMany('App\Post');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

    public function friend()
    {
        return $this->hasMany('App\Friend');
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }
    public function report()
    {
        return $this->hasMany('App\Report');
    }
    public function messages()
    {
        return $this->hasMany('App\Message');
    }
    public function chats()
    {
        return $this->hasMany('App\Chat');
    }

    protected $fillable = ['username', 'email', 'password', 'first_name', 'last_name'];
}
