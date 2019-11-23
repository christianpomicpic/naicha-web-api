<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $casts = [
        'information' => 'json'
    ];

    public function creator(){
    	return $this->belongsTo('App\User', 'user_id');
    }
}
