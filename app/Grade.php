<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    //



    public function worksheet(){
        return $this->belongsTo('App\GradeType', 'grade_type_id', 'id');
    }


    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('grades.title', 'like', '%'.$search_term.'%');
            $query->orWhere('grade_types.title', 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(questions.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(questions.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');

            return $query;
        }
    }
}
