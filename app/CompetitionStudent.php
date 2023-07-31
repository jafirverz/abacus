<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionStudent extends Model
{
    //
    public function userlist(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function categorycomp(){
        return $this->belongsTo('App\CategoryCompetition', 'competition_id', 'competition_controller_id');
    }

    public function category(){
        return $this->belongsTo('App\CompetitionCategory', 'category_id', 'id');
    }
}
