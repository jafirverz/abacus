<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstructorCalendar extends Model
{
    //

    public function teacher(){
        return $this->belongsTo('App\User', 'teacher_id', 'id');
    }
}
