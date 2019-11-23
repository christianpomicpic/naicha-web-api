<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    // --------------------------------------------------------------
    // Relationships
    // --------------------------------------------------------------
    public function role(){
    	return $this->belongsTo('App\Models\Role');
    }
    // --------------------------------------------------------------
}
