<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SellerParticular extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('created_at', function(Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function userbuyer()
    {
        return $this->belongsTo('App\User', 'buyer_email', 'email');
    }

    public function admin()
    {
        return $this->belongsTo('App\Admin', 'admin_id');
    }

    public function vehicleparticular()
    {
        return $this->hasOne('App\VehicleParticular', 'seller_particular_id');
    }

    public function spcontract()
    {
        return $this->hasOne('App\SpContractTerm', 'seller_particular_id');
    }

    public function buyerparticular()
    {
        return $this->hasOne('App\BuyerParticular', 'seller_particular_id');
    }

    public function scopeArchived($query)
    {
        return $query->where('seller_archive', '<>', 0)->orwhere('buyer_archive', '<>', 0);
    }

    public function scopeNotArchived($query)
    {
        return $query->where('seller_archive', 0)->where('buyer_archive', 0);
    }
}
