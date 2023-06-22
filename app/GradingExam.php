<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class GradingExam extends Model
{
    //

    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('grading_exams.title', 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(grading_exams.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(grading_exams.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');

            return $query;
        }
    }
}
