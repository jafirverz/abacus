<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionStudentResult extends Model
{
    //
    public function competition(){
        return $this->belongsTo('App\Competition', 'competition_id', 'id');
    }

    public function category(){
        return $this->belongsTo('App\CompetitionCategory', 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
