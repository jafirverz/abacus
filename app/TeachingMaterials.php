<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class TeachingMaterials extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function teacher(){
        return $this->belongsTo('App\User', 'teacher_id', 'id');
    }

    public function subHeading(){
        return $this->belongsTo('App\SubHeading', 'sub_heading', 'id');
    }


    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('teaching_materials.title', 'like', '%'.$search_term.'%');
            $query->orWhere('users.name', 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(teaching_materials.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(teaching_materials.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');

            return $query;
        }
    }
}
