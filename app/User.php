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


class User extends Authenticatable
{
    use Notifiable, AuthenticationLogable, LogsActivity, GetEmailTemplate,SystemSettingTrait;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'gender', 'email', 'mobile', 'password', 'address',' instructor_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	 public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('users.name', 'like', '%'.$search_term.'%');
            $query->orWhere('users.email', 'like', '%'.$search_term.'%');
            $query->orWhere('users.account_id', 'like', '%'.$search_term.'%');
            $query->orWhere('users.mobile', 'like', '%'.$search_term.'%');
            $query->orWhere('user_types.name', 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(users.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(users.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');

            return $query;
        }
    }

//    public function getFullnameAttribute() {
//		return ucfirst($this->firstname) . ' ' . ucfirst($this->lastname);
//    }

    public function getMobilewithcountrycodeAttribute()
    {
        return $this->country_code . $this->mobile;
    }


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        // EMAIL Notification to the User
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_FORGET_PASSWORD'));
        if ($email_template) {
            $data = [];

            $url = url(config('app.url').route('password.reset', ['token' => $token, 'email' => request()->email], false));
            $user=get_user_detail_by_email(request()->email);
			if(isset($user->name) && $user->name!="")
			$name=$user->name;
            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
            $data['from_email'] = $this->systemSetting()->from_email;
            $data['cc_to_email'] = [];

            $data['subject'] = $email_template->subject;

            $key = ['/{{action_url}}', "{{action_url}}", "{{name}}", "{{email}}"];
            $value = [$url, $url, $name,request()->email];

            $newContent = str_replace($key, $value, $email_template->content);

            $data['contents'] = $newContent;
           // dd($data);
            try {
                $this->notify(new MailResetPasswordNotification($data));
            } catch (Exception $exception) {
                //dd($exception);
            }
        }
    }

    public function userlist(){
        return $this->hasMany('App\CompetitionStudent', 'user_id', 'id');
    }

    public function level(){
        return $this->belongsTo('App\Level', 'level_id', 'id');
    }

}
