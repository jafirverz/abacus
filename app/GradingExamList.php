<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class GradingExamList extends Model
{
    //

    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('grading_exam_lists.heading', 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(grading_exam_lists.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(grading_exam_lists.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            return $query;
        }
    }
}
