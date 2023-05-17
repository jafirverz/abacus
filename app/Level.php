<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Level extends Model
{
    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('levels.title', 'like', '%'.$search_term.'%');
//            $query->orWhere('users.email', 'like', '%'.$search_term.'%');
//            $query->orWhere('users.mobile', 'like', '%'.$search_term.'%');
//            $query->orwhere(DB::raw("(DATE_FORMAT(users.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
//            $query->orwhere(DB::raw("(DATE_FORMAT(users.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');

            return $query;
        }
    }
}
