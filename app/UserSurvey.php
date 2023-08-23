<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSurvey extends Model
{
    //
    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function survey(){
        return $this->belongsTo('App\Survey', 'survey_id', 'id');
    }
}
