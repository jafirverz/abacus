<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BuyerParticular extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function sellerparticular()
    {
        return $this->belongsTo('App\SellerParticular', 'seller_particular_id');
    }

    public function buyerloandetail()
    {
        return $this->hasOne('App\BuyerLoanDetail', 'buyer_particular_id');
    }

    public function buyerpaymenttermcondition()
    {
        return $this->hasOne('App\BuyerPaymentTermCondition', 'buyer_particular_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
