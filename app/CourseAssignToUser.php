<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseAssignToUser extends Model
{
    //
    public function submitted(){
        return $this->belongsTo('App\CourseSubmitted', 'course_id', 'course_id');
    }

    public function course(){
        return $this->belongsTo('App\Course', 'course_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
