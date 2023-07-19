<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaperCategory extends Model
{
    //

    public function compQues(){
        return $this->hasMany('App\CompetitionQuestions', 'competition_paper_id', 'competition_paper_id');
    }
}
