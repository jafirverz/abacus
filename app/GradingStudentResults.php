<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradingStudentResults extends Model
{
    //
    public function grading(){
        return $this->belongsTo('App\GradingExam', 'grading_id', 'id');
    }

    public function category(){
        return $this->belongsTo('App\CompetitionCategory', 'category_id', 'id');
    }

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
        return $this->belongsTo('App\GradingExam', 'grading_id', 'id');
    }

    public function location(){
        return $this->belongsTo('App\LearningLocation', 'learning_location', 'id');
    }
}
