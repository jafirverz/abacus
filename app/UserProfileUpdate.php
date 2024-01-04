<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserProfileUpdate extends Model
{
    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('user_profile_updates.name', 'like', '%'.$search_term.'%');
            $query->orWhere('user_profile_updates.email', 'like', '%'.$search_term.'%');
            $query->orWhere('user_profile_updates.mobile', 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(user_profile_updates.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(user_profile_updates.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');

            return $query;
        }
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
