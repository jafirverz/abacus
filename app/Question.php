<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //

    public function worksheet(){
        return $this->belongsTo('App\Worksheet', 'worksheet_id', 'id');
    }

}
