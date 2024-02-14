<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestSubmission extends Model
{
    //

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function detail(){
        return $this->belongsTo('App\TestPaperDetail', 'test_paper_question_id', 'id');
    }
}
