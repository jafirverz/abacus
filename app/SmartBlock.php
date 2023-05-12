<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class SmartBlock extends Model
{
    use SoftDeletes, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $dates = ['deleted_at'];

    public function scopeSearch($query, $search_term)
    {
        $query->where('smart_blocks.title', 'like', '%'.$search_term.'%');
        $query->orwhere(DB::raw("(DATE_FORMAT(smart_blocks.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
        $query->orwhere(DB::raw("(DATE_FORMAT(smart_blocks.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
        return $query;
    }
}
