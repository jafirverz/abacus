<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestPaperDetail extends Model
{
    //


    public function questionsCourse(){
        return $this->hasMany('App\TestPaperQuestionDetail', 'test_paper_question_id', 'id');
    }

    public function test_paper(){
        return $this->belongsTo('App\TestPaper', 'paper_id', 'id');
    }
}
