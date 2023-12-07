<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class TestPaper extends Model
{
    //

    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('test_papers.title', 'like', '%'.$search_term.'%');
            //$query->orwhere(DB::raw("(DATE_FORMAT(grades.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            //$query->orwhere(DB::raw("(DATE_FORMAT(grades.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');

            return $query;
        }
    }

    public function comp_paper(){
        return $this->belongsTo('App\CompetitionPaper', 'competition_paper_id', 'id');
    }

    public function template(){
        return $this->belongsTo('App\QuestionTemplate', 'question_template_id', 'id');
    }
}
