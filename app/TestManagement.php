<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestManagement extends Model
{
    //

    public function course(){
        return $this->belongsTo('App\Course', 'course_id', 'id');
    }

    public function paper(){
        return $this->belongsTo('App\TestPaper', 'paper_id', 'id');
    }

    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('test_management.title', 'like', '%'.$search_term.'%');
            return $query;
        }
    }
}
