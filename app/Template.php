<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\DB;

class Template extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

	public function scopeSearch($query, $search_term)
    {
        $query->where('templates.title', 'like', '%'.$search_term.'%');
        return $query;
    }
}
