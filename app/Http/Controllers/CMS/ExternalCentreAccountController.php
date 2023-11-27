<?php

namespace App\Http\Controllers\CMS;

use App\Country;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use App\User;
use App\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\EmailNotification;
use App\Traits\GetEmailTemplate;
use Illuminate\Support\Facades\Mail;

class ExternalCentreAccountController extends Controller
{
    use SystemSettingTrait, GetEmailTemplate;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.EXTERNAL_CENTRE_ACCOUNT');
        $this->module = 'EXTERNAL_CENTRE_ACCOUNT';
        $this->middleware('grant.permission:' . $this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;
        $customer = User::where('user_type_id',6)->orderBy('id','desc')->paginate($this->pagination);

        return view('admin.account.external-centre.index', compact('title', 'customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $instructors = User::orderBy('id','desc')->get();
        $country = Country::orderBy('country', 'asc')->get();
        $country_phone = Country::orderBy('phonecode', 'asc')->get();
        return view('admin.account.external-centre.create', compact('title', 'instructors','country','country_phone'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = [
            'email' =>  'required|email|unique:users,email',
            'name' => 'required|string',
            'in_charge_name' => 'required|string',
            'password'  =>  'required|min:8',
            'country_code_phone' => 'required',
            'mobile' => 'required|integer|min:8',
            'gender' => 'required|string',
            'status' => 'required',
        ];

        $messages = [];
        $messages['email.required'] = 'The email address field is required.';
        $messages['name.required'] = 'The name field is required.';
        $messages['in_charge_name.required'] = 'The Person In-Charge Name field is required.';
        $messages['password.required'] = 'The password field is required.';
        $messages['email.email'] = 'The email address must be a valid email address.';
        $messages['country_code_phone.required'] = 'The country code is required.';
        $messages['mobile.required'] = 'The contact number field is required.';
        $messages['mobile.min'] = 'The contact number must be at least 8 characters.';
        $request->validate($fields, $messages);
        $acName = '';
        $dob = date('Y-m-d', strtotime($request->dob));
        $dob1 = date('dmy', strtotime($dob));
        $fullnameEx = explode(' ', $request->name);
        foreach($fullnameEx as $funame){
            $acName .= strtoupper(substr($funame, 0, 1));
        }
        $accountId = 'SUD-'.$dob1.$acName;
        $customer = new User();
        $customer->name = $request->name;
        $customer->in_charge_name = $request->in_charge_name;
        $customer->account_id = $accountId;
        $customer->instructor_id = $request->instructor_id??NULL;
        $customer->user_type_id = 6;
        //$customer->dob = $request->dob??NULL;
        $customer->email = $request->email??NULL;
        $customer->address = $request->address??NULL;
        $customer->centre_location = $request->centre_location??NULL;
        //$customer->year_attained_qualified_instructor = $request->year_attained_qualified_instructor??NULL;
        //$customer->year_attained_senior_instructor = $request->year_attained_senior_instructor??NULL;
        //$customer->highest_abacus_grade = $request->highest_abacus_grade??NULL;
        //$customer->highest_mental_grade = $request->highest_mental_grade??NULL;
        //$customer->awards = $request->awards??NULL;
        $customer->gender = $request->gender??NULL;
        //$customer->country_code = $request->country_code??NULL;
        $customer->mobile = $request->mobile??NULL;
        $customer->country_code_phone = $request->country_code_phone??NULL;
		$customer->approve_status = $request->status??NULL;
        if (!is_null($request->password)) {
            $customer->password = Hash::make($request->password);
        }
        $customer->created_at = Carbon::now();
        $customer->save();

        if($request->gender == 1){
            $gender = 'Male';
        }else{
            $gender = 'Female';
        }

        //			Admin email for new student registration
			$email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_EXTERNAL_CENTER_REGISTRATION'));
            $admins = Admin::get();

            if ($email_template) {
                $data = [];
                foreach($admins as $admin){
                    $data['email_sender_name'] = systemSetting()->email_sender_name;
                    $data['from_email'] = systemSetting()->from_email;
                    $data['to_email'] = [$admin->email];
                    $data['cc_to_email'] = [];
                    $data['subject'] = $email_template->subject;

                    $key = ['{{full_name}}','{{email}}','{{dob}}','{{gender}}','{{contact_number}}','{{address}}','{{country}}','{{Year_Attained_Qualified_Instructor_Certification}}','{{Year_Attained_Senior_Instructor_Certification}}','{{Highest_Abacus_Grade_Attained}}','{{Highest_Mental_Grade_Attained}}','{{Awards}}'];
                    $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $request->country_code, $request->year_attained_qualified_instructor, $request->year_attained_senior_instructor, $request->highest_abacus_grade, $request->highest_mental_grade, $request->awards];

                    $newContents = str_replace($key, $value, $email_template->content);

                    $data['contents'] = $newContents;
                    try {
                        $mail = Mail::to($admin->email)->send(new EmailNotification($data));
                    } catch (Exception $exception) {
                        dd($exception);
                    }
                }

            }

            //			Instructor email for new student registration
            $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_USER_THANKS'));

            if ($email_template) {
                $data = [];
                    $data['email_sender_name'] = systemSetting()->email_sender_name;
                    $data['from_email'] = systemSetting()->from_email;
                    $data['to_email'] = [$request->email];
                    $data['cc_to_email'] = [];
                    $data['subject'] = $email_template->subject;

                    $key = ['{{full_name}}'];
                    $value = [$request->name];
                    $newContents = str_replace($key, $value, $email_template->content);

                    $data['contents'] = $newContents;
                    try {
                        $mail = Mail::to($request->email)->send(new EmailNotification($data));
                    } catch (Exception $exception) {
                        dd($exception);
                    }

            }


        return redirect()->route('external-centre-account.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = $this->title;
        $customer = User::findorfail($id);
        return view('admin.account.external-centre.show', compact('title', 'customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = $this->title;
        $customer = User::findorfail($id);
        $instructors = User::orderBy('id','desc')->get();
        $country = Country::orderBy('country', 'asc')->get();
        $country_phone = Country::orderBy('phonecode', 'asc')->get();
        return view('admin.account.external-centre.edit', compact('title', 'customer','instructors','country','country_phone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fields = [
            'email' =>  'required|email|unique:users,email,' . $id . ',id',
            'name' => 'required|string',
            'in_charge_name' => 'required|string',
            'password'  =>  'nullable|min:8',
            'country_code_phone' => 'required',
            'mobile' => 'required|integer|min:8',
            'gender' => 'required|string',
        ];

        $messages = [];
        $messages['email.required'] = 'The email address field is required.';
        $messages['name.required'] = 'The name field is required.';
        $messages['in_charge_name.required'] = 'The Person In-Charge Name field is required.';
        $messages['password.required'] = 'The password field is required.';
        $messages['email.email'] = 'The email address must be a valid email address.';
        $messages['country_code_phone.required'] = 'The country code is required.';
        $messages['mobile.required'] = 'The contact number field is required.';
        $messages['mobile.min'] = 'The contact number must be at least 8 characters.';
        $request->validate($fields, $messages);

        $customer = User::find($id);
        $customer->name = $request->name;
        $customer->in_charge_name = $request->in_charge_name;
        $customer->instructor_id = $request->instructor_id??NULL;
        $customer->dob = $request->dob??NULL;
        $customer->email = $request->email??NULL;
        $customer->address = $request->address??NULL;
        $customer->centre_location = $request->centre_location??NULL;
        //$customer->year_attained_qualified_instructor = $request->year_attained_qualified_instructor??NULL;
        //$customer->year_attained_senior_instructor = $request->year_attained_senior_instructor??NULL;
        //$customer->highest_abacus_grade = $request->highest_abacus_grade??NULL;
        //$customer->highest_mental_grade = $request->highest_mental_grade??NULL;
        //$customer->awards = $request->awards??NULL;
        $customer->gender = $request->gender??NULL;
        //$customer->user_type_id = 5;
        //$customer->country_code = $request->country_code??NULL;
        $customer->country_code_phone = $request->country_code_phone??NULL;
        $customer->mobile = $request->mobile??NULL;
		$customer->approve_status = $request->status??NULL;
        if (!is_null($request->password)) {
            $customer->password = Hash::make($request->password);
        }
        $customer->updated_at = Carbon::now();
        $customer->save();

        return redirect()->route('external-centre-account.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $ids = explode(',', $request->multiple_delete);
        //User::destroy($id);
        foreach($ids as $id)
        {
            $customer = User::find($id);
            $customer->approve_status = NULL;
            $customer->save();
        }

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;

        $title = $this->title;
        $customer = User::join('user_types','users.user_type_id','user_types.id')->where('users.user_type_id',6)->select('users.*')->search($search_term)->paginate($this->pagination);
        //dd($customer);
        if ($search_term) {
            $customer->appends('search', $search_term);
        }

        return view('admin.account.external-centre.index', compact('title', 'customer'));
    }
}
