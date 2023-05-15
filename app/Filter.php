<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class Filter extends Model
{
    //

    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;


    public function scopeSearch($query, $search_term)
    {

		if($search_term->title!="")
		{
		$query->where('filters.title', 'like', '%'.$search_term->title.'%');
		}

		if($search_term->type!="")
		{
		$query->where('filters.type', $search_term->type);
		}

        return $query;
    }
}
