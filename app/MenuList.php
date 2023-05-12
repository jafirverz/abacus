<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class MenuList extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function scopeSearch($query, $search_term)
    {
        $query->where('menu_lists.title', 'like', '%'.$search_term.'%');
        $query->orwhere('pages.title', 'like', '%'.$search_term.'%');
        $query->orwhere(DB::raw("(DATE_FORMAT(menu_lists.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
        $query->orwhere(DB::raw("(DATE_FORMAT(menu_lists.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
        return $query;
    }
}
