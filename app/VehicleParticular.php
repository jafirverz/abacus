<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class VehicleParticular extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $dates = ['registration_date', 'coe_expiry_date'];

    public function getMakeModelAttribute() {
		return ucfirst($this->make) . ' ' . ucfirst($this->model);
    }


    public function sellerparticular()
    {
        return $this->belongsTo('App\SellerParticular', 'seller_particular_id');
    }
}
