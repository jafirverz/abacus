<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends Model
{
    protected $fillable = ['name', 'guard_name'];

    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('roles', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    public function admins()
    {
        return $this->hasOne('App\Admin', 'admin_role');
    }

    public function scopeSearch($query, $search_term)
    {
        $query->orwhere('roles.name', 'like', '%'.$search_term.'%');
        return $query;
    }
}
