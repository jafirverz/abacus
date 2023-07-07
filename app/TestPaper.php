<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestPaper extends Model
{
    //

    public function comp_paper(){
        return $this->belongsTo('App\CompetitionPaper', 'competition_paper_id', 'id');
    }

    public function template(){
        return $this->belongsTo('App\QuestionTemplate', 'question_template_id', 'id');
    }
}
