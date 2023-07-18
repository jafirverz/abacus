<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionTemplate extends Model
{
    //
    public function questionsTemp(){
        return $this->hasMany('App\Question', 'question_type', 'id');
    }
}
