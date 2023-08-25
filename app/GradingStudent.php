<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class GradingStudent extends Model
{
    //

    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function student(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function teacher(){
        return $this->belongsTo('App\User', 'instructor_id', 'id');
    }

    public function mental(){
        return $this->belongsTo('App\Grade', 'mental_grade', 'id');
    }

    public function abacus(){
        return $this->belongsTo('App\Grade', 'abacus_grade', 'id');
    }

    public function event(){
        return $this->belongsTo('App\GradingExam', 'grading_exam_id', 'id');
    }


}
