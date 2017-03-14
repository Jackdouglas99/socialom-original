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
    protected $fillable = ['username', 'email', 'password', 'first_name', 'last_name'];
}
