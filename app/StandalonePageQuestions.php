<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StandalonePageQuestions extends Model
{
    //
    public function questions(){
        return $this->hasMany('App\StandalonePageQuestions', 'standalone_page_question_id', 'id');
    }
}
