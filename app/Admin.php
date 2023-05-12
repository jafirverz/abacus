<?php

namespace App;

use Yadahan\AuthenticationLog\AuthenticationLogable;
use App\Notifications\AdminResetPassword;
use App\Notifications\MailResetPasswordNotification;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use Exception;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class Admin extends Authenticatable
{
    use Notifiable, AuthenticationLogable, LogsActivity, GetEmailTemplate, SystemSettingTrait;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'admin_role', 'status',
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
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {

        // EMAIL Notification to the Admin
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_FORGET_PASSWORD'));
		
        if ($email_template) {
            $data = [];

            $url = url("admin/password/reset/" . $token);
			$user=Admin::where('email',request()->email)->first();
			//dd($user);
			if(isset($user->firstname) && $user->firstname!="")
			$name=$user->firstname;
            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
            $data['from_email'] = $this->systemSetting()->from_email;
            $data['cc_to_email'] = [];

            $data['subject'] = $email_template->subject;

            $key = [ '/{{action_url}}', "{{action_url}}", "{{name}}","{{email}}"];
            $value = [$url, $url,$name,request()->email];
            $newContent = str_replace($key, $value, $email_template->content);

            $data['contents'] = $newContent;
			//dd(request()->email);
            try {
                $this->notify(new MailResetPasswordNotification($data));
            } catch (Exception $exception) {
                //dd($exception);
            }
        }
    }

	public function scopeSearch($query, $search_term)
    {
        if($search_term)
        {
            $query->where('admins.firstname', 'like', '%'.$search_term.'%');
            $query->orWhere('admins.lastname', 'like', '%'.$search_term.'%');
            $query->orWhere('admins.email', 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(admins.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
            $query->orwhere(DB::raw("(DATE_FORMAT(admins.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');

            return $query;
        }

    }

    public function getFullnameAttribute() {
		return ucfirst($this->firstname) . ' ' . ucfirst($this->lastname);
    }

    public function sellerparticular()
    {
        return $this->hasMany('App\SellerParticular', 'admin_id');
    }

    public function roles()
    {
        return $this->belongsTo('App\Role', 'admin_role');
    }
	
	public function scopePartner($query)
    {
        return $query->where('admin_role', __('constant.USER_PARTNER'))->where('status', 1);
    }
	public function scopeAdmin($query)
    {
        return $query->where('admin_role', __('constant.USER_SUPER_ADMIN'));
    }
	

}
