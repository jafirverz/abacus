<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Partner extends Model
{
    //
	 use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
	
	public function scopeSearch($query, $search_term)
    {
        $query->where('partners.partner_name', 'like', '%'.$search_term.'%');
        return $query;
    }
}
