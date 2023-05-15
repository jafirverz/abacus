<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Attributes extends Model
{
    protected $fillable = ['attribute_title', 'position', 'status'];

    public static function search($search_term)
    {
        $query = DB::table('attributes');
        $query->where('attributes.attribute_title', 'like', '%'.$search_term.'%');
        return $query;
    }
}
