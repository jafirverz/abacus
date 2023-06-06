<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Level;
use App\Traits\SystemSettingTrait;
use App\User;
use App\UserProfileUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CustomerAccountController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.CUSTOMER_ACCOUNT');
        $this->module = 'CUSTOMER_ACCOUNT';
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
        $userType = array('1,2,3,4');
        $customer = User::orderBy('id','desc')->whereIn('user_type_id', $userType)->paginate($this->pagination);

        return view('admin.account.customer.index', compact('title', 'customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $levels = Level::get();
        $instructors = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        return view('admin.account.customer.create', compact('title','instructors', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $fields = [
            'email' =>  'required|email|unique:users,email',
            'name' => 'required|string',
            'password'  =>  'required|min:8',
            'country_code' => 'required',
            'user_type_id' => 'required',
            'instructor_id' => 'required',
            'level' => 'required',
            'dob' => 'required',
            'country_code_phone' => 'required',
            'mobile' => 'required|integer|min:8',
            'gender' => 'required|string',
            'status' => 'required',
        ];

        $messages = [];
        $messages['email.required'] = 'The email address field is required.';
        $messages['name.required'] = 'The name field is required.';
        $messages['password.required'] = 'The password field is required.';
        $messages['email.email'] = 'The email address must be a valid email address.';
        $messages['country_code_phone.required'] = 'The country code is required.';
        $messages['country_code.required'] = 'The country code field is required.';
        $messages['user_type_id.required'] = 'User type field is required.';
        $messages['dob.required'] = 'Date of Birth is required.';
        $messages['mobile.required'] = 'The contact number field is required.';
        $messages['instructor_id.required'] = 'The instructor field is required.';
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
        $customer->account_id = $accountId;
        $customer->instructor_id = $request->instructor_id??NULL;
        $customer->user_type_id = $request->user_type_id??NULL;
        $customer->dob = $request->dob??NULL;
        $customer->level_id = json_encode($request->level);
        $customer->email = $request->email??NULL;
        $customer->address = $request->address??NULL;
        $customer->gender = $request->gender??NULL;
        $customer->country_code = $request->country_code??NULL;
        $customer->country_code_phone = $request->country_code_phone??NULL;
        $customer->mobile = $request->mobile??NULL;
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
			$email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_STUDENT_REGISTRATION'));
            $admins = Admin::get();

            if ($email_template) {
                $data = [];
                foreach($admins as $admin){
                    $data['email_sender_name'] = systemSetting()->email_sender_name;
                    $data['from_email'] = systemSetting()->from_email;
                    $data['to_email'] = [$admin->email];
                    $data['cc_to_email'] = [];
                    $data['subject'] = $email_template->subject;

                    $key = ['{{full_name}}','{{email}}','{{dob}}','{{gender}}','{{contact_number}}','{{address}}','{{country}}','{{instructor}}'];
                    $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $request->country_code, $instructor->name];

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
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_INSTRUCTOR_STUDENT_REGISTRATION'));

        if ($email_template) {
            $data = [];
                $data['email_sender_name'] = systemSetting()->email_sender_name;
                $data['from_email'] = systemSetting()->from_email;
                $data['to_email'] = [$instructor->email];
                $data['cc_to_email'] = [];
                $data['subject'] = $email_template->subject;

                $key = ['{{full_name}}','{{email}}','{{dob}}','{{gender}}','{{contact_number}}','{{address}}','{{country}}','{{instructor}}'];
                $value = [$request->name, $request->email, $dob, $gender, $request->mobile, $request->address, $request->country_code, $instructor->name];

                $newContents = str_replace($key, $value, $email_template->content);

                $data['contents'] = $newContents;
                try {
                    $mail = Mail::to($instructor->email)->send(new EmailNotification($data));
                } catch (Exception $exception) {
                    dd($exception);
                }

        }

        return redirect()->route('customer-account.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $instructors = User::findorfail($customer->instructor_id);
        return view('admin.account.customer.show', compact('title', 'customer','instructors'));
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
        $levels = Level::get();
        $instructors = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        return view('admin.account.customer.edit', compact('title', 'customer','instructors', 'levels'));
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
            'password'  =>  'nullable|min:8',
            'country_code' => 'required',
            'user_type_id' => 'required',
            'level' => 'required',
            'dob' => 'required',
            'instructor_id' => 'required',
            'country_code_phone' => 'required',
            'mobile' => 'required|integer|min:8',
            'gender' => 'required|string',
        ];
        $messages = [];
        $messages['email.required'] = 'The email address field is required.';
        $messages['name.required'] = 'The name field is required.';
        $messages['password.required'] = 'The password field is required.';
        $messages['email.email'] = 'The email address must be a valid email address.';
        $messages['country_code_phone.required'] = 'The country code is required.';
        $messages['country_code.required'] = 'The country code field is required.';
        $messages['user_type_id.required'] = 'User type field is required.';
        $messages['dob.required'] = 'Date of Birth is required.';
        $messages['mobile.required'] = 'The contact number field is required.';
        $messages['instructor_id.required'] = 'The instructor field is required.';
        $messages['mobile.min'] = 'The contact number must be at least 8 characters.';
        $request->validate($fields, $messages);

        $customer = User::find($id);
        $customer->name = $request->name;
        $customer->instructor_id = $request->instructor_id??NULL;
        $customer->dob = $request->dob??NULL;
        $customer->email = $request->email??NULL;
        $customer->address = $request->address??NULL;
        $customer->level_id = json_encode($request->level);
        $customer->gender = $request->gender??NULL;
        $customer->user_type_id = $request->user_type_id??NULL;
        $customer->country_code = $request->country_code??NULL;
        $customer->country_code_phone = $request->country_code_phone??NULL;
        $customer->mobile = $request->mobile??NULL;
		$customer->approve_status = $request->status??NULL;
        if (!is_null($request->password)) {
            $customer->password = Hash::make($request->password);
        }
        $customer->updated_at = Carbon::now();
        $customer->save();

        return redirect()->route('customer-account.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $id = explode(',', $request->multiple_delete);
        User::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;

        $title = $this->title;
        $customer = User::join('user_types','users.user_type_id','user_types.id')->select('users.*')->search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $customer->appends('search', $search_term);
        }
        //dd($customer);
        return view('admin.account.customer.index', compact('title', 'customer'));
    }

}
