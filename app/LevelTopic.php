<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LevelTopic extends Model
{
    public function levels(){
        return $this->belongsTo('App\Level', 'level_id', 'id');
    }

    public function topics(){
        return $this->belongsTo('App\Level', 'topic_id', 'id');
    }
}
