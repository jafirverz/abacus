<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class VehicleMain extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $fillable = ['seller_id', 'full_name', 'email', 'country', 'contact_number', 'specification', 'additional_accessories', 'seller_comment'];

    public function detail()
    {
        return $this->hasOne('App\VehicleDetail', 'vehicle_id', 'id');
    }

    public function vehicleDetail(){
        return $this->hasMany('App\VehicleDetail', 'vehicle_id', 'id');
    }

    public function buyerId(){
        return $this->belongsTo('App\Chat', 'id', 'vehicle_main_id');
    }

    // public static function search($search_term)
    // {
    //     $query = DB::table('vehicle_mains')->join('vehicle_details', 'vehicle_mains.id', '=', 'vehicle_details.vehicle_id');
    //     $query->where('vehicle_details.vehicle_number', 'like', '%'.$search_term.'%')
    //           ->orWhere('vehicle_details.vehicle_model', 'like', '%'.$search_term.'%')
    //           ->where('vehicle_mains.full_name', 'like', '%'.$search_term.'%')
    //           ->where('vehicle_mains.email', 'like', '%'.$search_term.'%');
    //     return $query;
    // }

    // public function scopeSearch($query, $search_term)
    // {
	// 	if($search_term->search!="")
	// 	{
	// 	    $query->where('vehicle_details.vehicle_number', 'like', '%'.$search_term->search.'%')
    //                 ->orWhere('vehicle_mains.full_name', 'like', '%'.$search_term->search.'%');
	// 	}

	// 	if($search_term->type!="")
	// 	{
	// 	    $query->where('vehicle_details.vehicle_type', $search_term->type);
	// 	}

    //     if($search_term->make!="")
	// 	{
	// 	    $query->where('vehicle_details.vehicle_make', $search_term->make);
	// 	}

    //     if($search_term->model!="")
	// 	{
	// 	    $query->where('vehicle_details.vehicle_model', $search_term->model);
	// 	}

    //     return $query;
    // }
}
