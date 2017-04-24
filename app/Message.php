<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function chat()
    {
        return $this->belongsTo('App\Chat');
    }

    protected $fillable = ['chat_id', 'user_id', 'message'];
}
