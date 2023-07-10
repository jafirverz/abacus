<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    //

    public function student(){
        return $this->belongsTo('App\User', 'student_id', 'id');
    }
}
