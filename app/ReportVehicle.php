<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportVehicle extends Model
{
    protected $table = 'report_vehicles';
    protected $fillable = ['user_id', 'vehicle_id', 'is_reported','comments'];

    public function scopeSearch($query,$search_term)
    {
        $query->whereHas('vehicledetail', function ($query) use ($search_term) {
            $query->where('vehicle_make', 'like', '%' .  $search_term . '%');
            $query->orWhere('vehicle_model', 'like', '%' .  $search_term . '%');
        });
        return $query;
    }

    public function vehicledetail()
    {
        return $this->belongsTo('App\VehicleDetail', 'vehicle_id', 'vehicle_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


}
