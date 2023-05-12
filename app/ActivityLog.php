<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
	protected $table = 'activity_log';
	protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

	public function scopeSearch($query, $search_term)
    {
		//dd($search_term->firstname);
		if($search_term->page_name!="")
		$query->where('activity_log.subject_type', 'like', '%'.$search_term->page_name.'%');

		if($search_term->firstname!="")
		$query->where('admins.firstname', 'like', '%'.$search_term->firstname.'%');

		if($search_term->lastname!="")
		$query->where('admins.lastname', 'like', '%'.$search_term->lastname.'%');
		
		if($search_term->fields_updated!="")
		$query->where('activity_log.properties', 'like', '%'.$search_term->fields_updated.'%');
        return $query;
    }
}
