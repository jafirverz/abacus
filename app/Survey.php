<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    //

    public function student(){
        return $this->belongsTo('App\User', 'student_id', 'id');
    }


    public function teacher(){
        return $this->belongsTo('App\User', 'assigned_by', 'id');
    }


    public function survey(){
        return $this->belongsTo('App\Survey', 'assigned_id', 'id');
    }

    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('surveys.title', 'like', '%'.$search_term.'%');
            $query->orWhere('users.name', 'like', '%'.$search_term.'%');
            return $query;
        }
    }


}
