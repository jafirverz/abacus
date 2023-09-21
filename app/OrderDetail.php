<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //
    public function order(){
        return $this->belongsTo('App\Order', 'order_id', 'id');
    }
    public function level(){
        return $this->belongsTo('App\Level', 'level_id', 'id');
    }
}
