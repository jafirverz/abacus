<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StandalonePage extends Model
{
    //
    // public function questions(){
    //     return $this->hasMany('App\StandaloneQuestions', 'standalone_page_id', 'id')->groupBy('question_template_id');
    // }
    public function questionsPage(){
        return $this->hasMany('App\StandalonePageQuestions', 'standalone_page_id', 'id');
    }
}
