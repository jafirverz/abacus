<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradingStudent extends Model
{
    //

    public function student(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function mental(){
        return $this->belongsTo('App\Grade', 'mental_grade', 'id');
    }

    public function abacus(){
        return $this->belongsTo('App\Grade', 'abacus_grade', 'id');
    }
}
