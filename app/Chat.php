<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    protected $fillable = ['message_id', 'user_id_to', 'user_id_from'];
}
