<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseLevelCertificate extends Model
{
    //
    public function certificate(){
        return $this->belongsTo('App\Certificate', 'certificate_id', 'id');
    }

    public function level(){
        return $this->belongsTo('App\Level', 'level_id', 'id');
    }
}
