<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeCount extends Model
{
    protected $table = 'vehicle_like_counts';
    protected $fillable = ['user_id', 'vehicle_id', 'is_liked'];

    public function vehicle(){
        return $this->belongsTo('App\VehicleMain', 'vehicle_id', 'id');
    }
}
