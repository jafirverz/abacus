<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorksheetSubmitted extends Model
{
    //
    public function worksheet(){
        return $this->belongsTo('App\Worksheet', 'worksheet_id', 'id');
    }
    public function level(){
        return $this->belongsTo('App\Level', 'level_id', 'id');
    }
    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
