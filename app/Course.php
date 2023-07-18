<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //

    public function level(){
        return $this->belongsTo('App\Level', 'level_id', 'id');
    }

    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('courses.title', 'like', '%'.$search_term.'%');
            return $query;
        }
    }



    public function paper(){
        return $this->belongsTo('App\TestPaper', 'paper_id', 'id');
    }
}
