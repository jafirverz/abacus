<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Contact extends Model
{
    //
	use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function getMobilewithcountrycodeAttribute()
    {
        return $this->country_code . $this->contact_number;
    }

	public function scopeSearch($query, $search_term)
    {
        $query->where('contacts.full_name', 'like', '%'.$search_term.'%');
		$query->orwhere('contacts.email_id', 'like', '%'.$search_term.'%');
		$query->orwhere('contacts.contact_number', 'like', '%'.$search_term.'%');
		$query->orwhere('contacts.message', 'like', '%'.$search_term.'%');
        return $query;
    }
}
