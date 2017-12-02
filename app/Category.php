<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function users(){
        return $this->hasMany('App\User');
    }
    
    public function spare_parts(){
        return $this->hasMany('App\SparePart');
    }
}
