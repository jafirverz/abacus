<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionPaper extends Model
{
    //
    public function comp_ques(){
        return $this->hasMany('App\CompetitionQuestions', 'competition_paper_id', 'id');
    }

    public function comp_contro(){
        return $this->belongsTo('App\Competition', 'competition_controller_id', 'id');
    }
}
