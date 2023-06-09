<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class Announcement extends Model
{
    //

    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function teacher(){
        return $this->belongsTo('App\User', 'teacher_id', 'id');
    }


    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('announcements.title', 'like', '%'.$search_term.'%');
            $query->orWhere('users.name', 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(announcements.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(announcements.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');

            return $query;
        }
    }
}
