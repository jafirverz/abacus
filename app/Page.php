<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\DB;

class Page extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function scopeSearch($query, $search_term)
    {
        
		if($search_term->title!="")
		$query->where('pages.title', 'like', '%'.$search_term->title.'%');
		
		if($search_term->status!="")
		$query->where('pages.status', $search_term->status);
		
		if($search_term->parent_id!="")
		$query->where('pages.parent',$search_term->parent_id);  
        return $query;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('view_order', 'asc');
    }
}
