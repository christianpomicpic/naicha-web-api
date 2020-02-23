<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchItem extends Model
{
    protected $casts = [
    	'information' => 'json'
    ];

    public function itemInfo(){
    	return $this->belongsTo('App\Models\Item', 'item_id');
    }
}
