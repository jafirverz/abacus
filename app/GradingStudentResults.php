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
}
