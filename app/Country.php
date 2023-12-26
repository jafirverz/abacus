<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    protected $table = 'country';

    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('country.country', 'like', '%'.$search_term.'%');
            $query->orWhere('country.phonecode', 'like', '%'.$search_term.'%');
            return $query;
        }
    }
}
