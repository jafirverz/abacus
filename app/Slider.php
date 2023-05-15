<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class Slider extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function scopeSearch($query, $search_term)
    {
        $query->where('sliders.title', 'like', '%' . $search_term . '%');
        $query->orwhere(DB::raw("(DATE_FORMAT(sliders.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%' . $search_term . '%');
        $query->orwhere(DB::raw("(DATE_FORMAT(sliders.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%' . $search_term . '%');
        return $query;
    }
}
