<?php

namespace App;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class CompetitionPaper extends Model
{
    //
    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('competition_papers.title', 'like', '%'.$search_term.'%');
            // $query->orWhere('competition_controllers.competition_type', 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(competition_papers.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(competition_papers.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');

            return $query;
        }
    }


    public function comp_ques(){
        return $this->hasMany('App\CompetitionQuestions', 'competition_paper_id', 'id');
    }

    public function comp_contro(){
        return $this->belongsTo('App\Competition', 'competition_controller_id', 'id');
    }
}
