<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionPaper extends Model
{
    //
    public function comp_ques(){
        return $this->hasMany('App\CompetitionQuestions', 'competition_paper_id', 'id');
    }
}
