<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class EmailTemplate extends Model
{
    use SoftDeletes, LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $fillable = ['title', 'subject', 'content', 'view_order', 'status'];
    protected $dates = ['deleted_at'];

    public function scopeSearch($query, $search_term)
    {
        $query->where('email_templates.title', 'like', '%'.$search_term.'%');
        $query->orwhere(DB::raw("(DATE_FORMAT(email_templates.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
        $query->orwhere(DB::raw("(DATE_FORMAT(email_templates.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
        return $query;
    }
}
