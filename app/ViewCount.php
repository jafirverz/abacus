<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewCount extends Model
{
    protected $table = 'vehicle_view_counts';
    protected $fillable = ['user_id', 'vehicle_id', 'user_ip', 'view_count'];

    public function vehicle(){
        return $this->belongsTo('App\VehicleMain', 'vehicle_id', 'id');
    }
}
