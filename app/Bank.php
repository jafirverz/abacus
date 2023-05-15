<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class Bank extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;


    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeSearch($query, $search_term)
    {
        $query->where('banks.title', 'like', '%'.$search_term.'%');
        $query->orwhere(DB::raw("(DATE_FORMAT(banks.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
        $query->orwhere(DB::raw("(DATE_FORMAT(banks.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');

        return $query;
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('view_order', function (Builder $builder) {
            $builder->orderBy('view_order', 'asc');
        });
    }

    public function loans()
    {
        return $this->hasOne('App\Loan', 'bank_id');
    }
}
