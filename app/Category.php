<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function spare_parts(){
        return $this->hasMany('App\SparePart');
    }

    public function scopeNameLike($q, $keyword){
        return $q->where('name','like','%'.$keyword.'%');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($category) { // before delete() method call this
             $category->spare_parts()->delete();
        });
    }
}
