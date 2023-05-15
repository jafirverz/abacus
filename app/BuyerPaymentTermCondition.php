<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class BuyerPaymentTermCondition extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function buyerparticular()
    {
        return $this->belongsTo('App\BuyerParticular', 'buyer_particular_id');
    }
}
