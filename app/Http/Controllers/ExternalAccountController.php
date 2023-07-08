<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\EmailNotification;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use App\Traits\PageTrait;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmail;

class ExternalAccountController extends Controller
{
    use GetEmailTemplate, SystemSettingTrait, PageTrait;

	public function __construct()
	{
		$this->middleware('auth:web');
		$this->system_settings = $this->systemSetting();
		$this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
		$this->middleware(function ($request, $next) {
			$this->user = Auth::user();
			return $next($request);
		});
	}
    //
    public function external_store(Request $request)
    {
        //        dd($request->all());
        $updateUserProfile = User::find($this->user->id);

        $messages = [
            'country_code.regex' => 'The Country code entered is invalid.',
        ];
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $updateUserProfile->id,
            'dob' => 'required',
            'country_code_phone' => 'required',
            'mobile' => 'required',
            'gender' => 'required',
            // 'instructor' => 'required',
            'country_code' => 'required',
        ], $messages); //dd($request);


        $dob = date('Y-m-d', strtotime($request->dob));
        //$updateUserProfile = new User();
        $updateUserProfile->name = $request->name;
        $updateUserProfile->email = $request->email;
        //$users->email = $request->email;
        if ($request->password != '') {
            //dd($request->password);
            $updateUserProfile->password = Hash::make($request->password);
        }
        $updateUserProfile->address = $request->address ?? NULL;
        $updateUserProfile->country_code = $request->country_code;
        $updateUserProfile->country_code_phone = $request->country_code_phone;
        $updateUserProfile->dob = $dob;
        $updateUserProfile->mobile = $request->mobile;
        $updateUserProfile->gender = $request->gender;

        // $updateUserProfile->year_attained_qualified_instructor = $request->year_attained_qualified_instructor ?? NULL;
        // $updateUserProfile->year_attained_senior_instructor = $request->year_attained_senior_instructor ?? NULL;
        // $updateUserProfile->highest_abacus_grade = $request->highest_abacus_grade ?? NULL;
        // $updateUserProfile->highest_mental_grade = $request->highest_mental_grade ?? NULL;
        // $updateUserProfile->awards = $request->awards ?? NULL;

        $updateUserProfile->updated_at = Carbon::now();
        $updateUserProfile->save();

        if ($request->gender == 1) {
            $gender = 'Male';
        } else {
            $gender = 'Female';
        }

        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_INSTRUCTOR_STUDENT_PROFILE_UPDATE'));

        if ($email_template) {
            if ($this->user) {
                $data = [];
                $data['email_sender_name'] = systemSetting()->email_sender_name;
                $data['from_email'] = systemSetting()->from_email;
                $data['to_email'] = [$this->user->email];
                $data['cc_to_email'] = [];
                $data['subject'] = $email_template->subject;

                $key = ['{{full_name}}', '{{email}}', '{{dob}}', '{{gender}}', '{{contact_number}}', '{{address}}', '{{country}}', '{{instructor}}'];
                $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $request->country_code, $this->user->name];

                $newContents = str_replace($key, $value, $email_template->content);

                $data['contents'] = $newContents;
                try {
                    $mail = Mail::to($this->user->email)->send(new EmailNotification($data));
                } catch (Exception $exception) {
                    dd($exception);
                }
            }
        }

        //			Admin email for new student registration
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_STUDENT_PROFILE_UPDATE'));
        $admins = Admin::get();

        if ($email_template) {
            $data = [];
            foreach ($admins as $admin) {
                $data['email_sender_name'] = systemSetting()->email_sender_name;
                $data['from_email'] = systemSetting()->from_email;
                $data['to_email'] = [$admin->email];
                $data['cc_to_email'] = [];
                $data['subject'] = $email_template->subject;

                $key = ['{{full_name}}', '{{email}}', '{{dob}}', '{{gender}}', '{{contact_number}}', '{{address}}', '{{country}}', '{{instructor}}'];
                $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $request->country_code, $instructorDetail->name];

                $newContents = str_replace($key, $value, $email_template->content);

                $data['contents'] = $newContents;
                try {
                    $mail = Mail::to($admin->email)->send(new EmailNotification($data));
                } catch (Exception $exception) {
                    dd($exception);
                }
            }
        }




        return redirect()->back()->with('success', __('constant.ACOUNT_UPDATED'));
    }
}
