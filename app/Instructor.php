<?php

namespace App;

use App\Notifications\MailResetPasswordNotification;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use Exception;
use Yadahan\AuthenticationLog\AuthenticationLogable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;


class Instructor extends Model
{
    //

    use Notifiable, AuthenticationLogable, LogsActivity, GetEmailTemplate,SystemSettingTrait;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('users.name', 'like', '%'.$search_term.'%');
            $query->orWhere('users.email', 'like', '%'.$search_term.'%');
            $query->orWhere('users.mobile', 'like', '%'.$search_term.'%');
            $query->orWhere('user_types.name', 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(users.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(users.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');

            return $query;
        }
    }

    public function getMobilewithcountrycodeAttribute()
    {
        return $this->country_code . $this->mobile;
    }


}
