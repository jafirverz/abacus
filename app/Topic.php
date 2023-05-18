<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public function level(){
        return $this->belongsTo('App\Level', 'level_id', 'id');
    }

    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('topics.title', 'like', '%'.$search_term.'%');
//            $query->orWhere('users.email', 'like', '%'.$search_term.'%');
//            $query->orWhere('users.mobile', 'like', '%'.$search_term.'%');
//            $query->orwhere(DB::raw("(DATE_FORMAT(users.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
//            $query->orwhere(DB::raw("(DATE_FORMAT(users.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');

            return $query;
        }
    }
}
