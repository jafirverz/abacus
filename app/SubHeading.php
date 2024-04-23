<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubHeading extends Model
{
    //

    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('sub_headings.title', 'like', '%'.$search_term.'%');
            return $query;
        }
    }
}
