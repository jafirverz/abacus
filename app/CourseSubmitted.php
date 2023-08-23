<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseSubmitted extends Model
{
    //
    public function certificate(){
        return $this->belongsTo('App\Certificate', 'certificate_id', 'id');
    }

    public function course(){
        return $this->belongsTo('App\Course', 'course_id', 'id');
    }
}
