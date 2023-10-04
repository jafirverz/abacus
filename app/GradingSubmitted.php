<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradingSubmitted extends Model
{
    //

    public function grade(){
        return $this->belongsTo('App\GradingExam', 'grading_exam_id', 'id');
    }
}
