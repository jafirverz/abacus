<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Specifications extends Model
{
    protected $fillable = ['specification', 'position', 'status'];

    public static function search($search_term)
    {
        $query = DB::table('specifications');
        $query->where('specifications.specification', 'like', '%'.$search_term.'%');
        return $query;
    }
}
