<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $guarded = [];
    public function allChat()
    {
        return $this->hasMany('App\ChatMessage')->where('deleted', 0);
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'buyer_id', 'id');
    }

    public function seller()
    {
        return $this->belongsTo('App\User', 'seller_id', 'id');
    }

    public function vehicle_detail()
    {
        return $this->belongsTo('App\VehicleDetail', 'vehicle_main_id', 'vehicle_id');
    }


    public function vehiclemain()
    {
        return $this->belongsTo('App\VehicleMain', 'vehicle_main_id', 'id');
    }

    public function scopeSearchTab($query, $search_term)
    {

        //NEGOTIATE
        if (isset($search_term['tabMessage']) && $search_term['tabMessage'] == 1) {
            $query->where(function ($query) use ($search_term) {
                $query->where('revise_offer_buyer', 1)->where('revise_offer_status', 0);
            });
        }

        //OFFERS
        if (isset($search_term['tabMessage']) && $search_term['tabMessage'] == 2) {
            $query->where('offer_amount', '>', 0)->where('accept_reject_offer', 0);
        }

        //ACCEPTED
        if (isset($search_term['tabMessage']) && $search_term['tabMessage'] == 3) {
            $query->where(function ($query) use ($search_term) {
                $query->where('revise_offer_status', 1)->orWhere('accept_reject_offer', 1);
            });
        }

        //REJECTED
        if (isset($search_term['tabMessage']) && $search_term['tabMessage'] == 4) {
            $query->where(function ($query) use ($search_term) {
                $query->where('revise_offer_status', 2)->orWhere('accept_reject_offer', 2);
            });
        }
        return $query;
    }

    public function vehicledetail()
    {
        return $this->belongsTo('App\VehicleDetail', 'vehicle_main_id', 'vehicle_id');
    }
}
