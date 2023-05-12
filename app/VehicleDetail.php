<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class VehicleDetail extends Model
{
    //
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $fillable = ['vehicle_id', 'vehicle_number', 'nric', 'price', 'mileage', 'upload_file', 'vehicle_make', 'vehicle_model', 'year_of_mfg', 'first_reg_date', 'coe_expiry_date', 'vehicle_type', 'co2_emission_rate', 'engine_cc', 'open_market_value', 'no_of_transfers', 'coe_category', 'propellent', 'max_unladden_weight', 'road_tax_expiry_date', 'primary_color', 'orig_reg_date', 'min_parf_benefit', 'quota_premium', 'power_rate', 'vehicle_scheme'];

    
}
