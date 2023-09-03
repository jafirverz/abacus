<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstructorCalendar extends Model
{
    //
    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('users.name', 'like', '%'.$search_term.'%');
            $query->orWhere('instructor_calendars.full_name', 'like', '%'.$search_term.'%');
            return $query;
        }
    }
    public function teacher(){
        return $this->belongsTo('App\User', 'teacher_id', 'id');
    }
}
