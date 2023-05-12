<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class Banner extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
	
	public function scopeSearch($query, $search_term)
    {
        $query->where('pages.title', 'like', '%' . $search_term . '%');
        $query->orwhere(DB::raw("(DATE_FORMAT(banners.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
        $query->orwhere(DB::raw("(DATE_FORMAT(banners.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
        return $query;
    }
}
