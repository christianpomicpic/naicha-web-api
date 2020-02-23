<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;

    protected $casts = [
    	'information' => 'json'
    ];

    public function items(){
    	return $this->hasMany('App\BranchItem', 'branch_id');
    }

    public function transactions(){
    	return $this->hasMany('App\ItemTransaction', 'branch_id');
    }
}
