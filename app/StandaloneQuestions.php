<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StandaloneQuestions extends Model
{
    //
    public function questionTemp(){
        return $this->belongsTo('App\QuestionTemplate', 'question_template_id', 'id');
    }
}
