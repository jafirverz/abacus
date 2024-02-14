<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestPaperQuestionDetail extends Model
{
    //

    public function detail(){
        return $this->belongsTo('App\TestPaperDetail', 'test_paper_question_id', 'id');
    }
}
