<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AchievementOther extends Model
{
    //
    protected $table = 'achievements_other';

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
