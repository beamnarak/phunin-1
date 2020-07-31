<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function machine_category(){
        return $this->belongsTo('App\MachineCategory');
    }

    public function repairments(){
        return $this->hasMany('App\Repairment');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
