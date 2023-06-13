<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class CompetitionCategory extends Model
{
    //
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('competition_categories.category_name', 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(competition_categories.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(competition_categories.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');

            return $query;
        }
    }
}
