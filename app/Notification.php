<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    protected $fillable = ['from', 'to', 'type', 'date', 'read_at'];
}
