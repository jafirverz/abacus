<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionQuestions extends Model
{
    //
    public function comp_paper(){
        return $this->belongsTo('App\CompetitionPaper', 'competition_paper_id', 'id');
    }
}
