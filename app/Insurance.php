<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Insurance extends Model
{
    //
	
	use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
	
	public function scopeSearch($query, $search_term)
    {
		
		if($search_term->main_driver_full_name!="")
		$query->where('insurances.main_driver_full_name', 'like', '%'.$search_term->main_driver_full_name.'%');
		
		if($search_term->main_driver_nric!="")
		$query->where('insurances.main_driver_nric', 'like', '%'.$search_term->main_driver_nric.'%');
		
		if($search_term->main_driver_email!="")
		$query->where('insurances.main_driver_email', 'like', '%'.$search_term->main_driver_email.'%');
		
		if($search_term->status!="")
		$query->where('insurances.status', $search_term->status);
		
        return $query;
    }
    
    public function insurance_information()
	{
		return $this->belongsTo('App\InsuranceInformation', 'id', 'insurance_id');
	}

	public function insurance_vehicle()
	{
		return $this->belongsTo('App\InsuranceVehicle', 'id', 'insurance_id');
	}
}
