<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class GradingPaper extends Model
{
    //
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function template()
    {
        return $this->belongsTo('App\QuestionTemplate', 'question_type', 'id');
    }


    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('grading_papers.title', 'like', '%'.$search_term.'%');
            $query->orWhere('question_templates.title', 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(grading_papers.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(grading_papers.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            return $query;
        }
    }

}
