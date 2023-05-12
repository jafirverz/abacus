<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SpContractTerm extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function sellerparticular()
    {
        return $this->belongsTo('App\SellerParticular', 'seller_particular_id');
    }
}
