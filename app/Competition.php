<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Competition extends Model
{
    //
    protected $table = 'competition_controllers';

    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('competition_controllers.title', 'like', '%'.$search_term.'%');
            $query->orWhere('competition_controllers.competition_type', 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(competition_controllers.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(competition_controllers.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');

            return $query;
        }
    }

    public function compStu(){
        return $this->hasMany('App\CompetitionStudent', 'competition_controller_id', 'id');
    }

}
