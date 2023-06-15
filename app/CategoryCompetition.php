<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryCompetition extends Model
{
    //
    public function category(){
        return $this->belongsTo('App\CompetitionCategory', 'category_id', 'id');
    }

}
