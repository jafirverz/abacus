<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseAssignToUser extends Model
{
    //
    public function submitted(){
        return $this->belongsTo('App\CourseSubmitted', 'course_id', 'course_id');
    }
}
