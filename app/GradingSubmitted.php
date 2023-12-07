<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradingSubmitted extends Model
{
    //

    public function grade(){
        return $this->belongsTo('App\GradingExam', 'grading_exam_id', 'id');
    }
    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function paper(){
        return $this->belongsTo('App\GradingPaper', 'paper_id', 'id');
    }
    public function gcategory(){
        return $this->belongsTo('App\GradingCategory', 'category_id', 'id');
    }

}
