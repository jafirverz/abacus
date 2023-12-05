<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use App\User;
use App\UserProfileUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileUpdateController extends Controller
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

    public function index(){
        $title = 'Pending Profile Update';
        $customer = UserProfileUpdate::where('approve_status', '!=', 1)
            ->whereRaw('id IN (select MAX(id) FROM user_profile_updates  GROUP BY user_id)')
            ->orderBy('created_at','desc')
            ->paginate();
        $instructors = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        return view('admin.account.customer.pending', compact('title', 'customer','instructors'));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;

        $title = 'Pending Profile Update';
        $customer = UserProfileUpdate::where('approve_status', '!=', 1)
            ->whereRaw('id IN (select MAX(id) FROM user_profile_updates  GROUP BY user_id)')->search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $customer->appends('search', $search_term);
        }
        //dd($customer);
        return view('admin.account.customer.pending', compact('title', 'customer'));
    }

    public function edit($id)
    {
        $title = 'Profile Update';
        $customer = UserProfileUpdate::findorfail($id);
        $instructors = User::where('user_type_id', 5)->orderBy('id','desc')->get();
        return view('admin.account.customer.editpending', compact('title', 'customer','instructors'));
    }

    public function update(Request $request, $id)
    {
        $title = 'Profile Updated';
        $userprofileupdate = UserProfileUpdate::find($id);
        $fields = [
            //'email' =>  'required|email|unique:users,email,' . $userprofileupdate->user_id . ',id',
            'name' => 'required|string',
//            'password'  =>  'nullable|min:8',
            //'country_code' => 'required',
//            'user_type_id' => 'required',
            'dob' => 'required',
            //'instructor_id' => 'required',
            'mobile' => 'required',
            'gender' => 'required',
        ];
        $messages = [];
        $messages['email.required'] = 'The email address field is required.';
        $messages['name.required'] = 'The name field is required.';
//        $messages['password.required'] = 'The password field is required.';
        $messages['email.email'] = 'The email address must be a valid email address.';
        $messages['country_code.required'] = 'The country code field is required.';
//        $messages['user_type_id.required'] = 'User type field is required.';
        $messages['dob.required'] = 'Date of Birth is required.';
        $messages['mobile.required'] = 'The contact number field is required.';
        $messages['instructor_id.required'] = 'The instructor field is required.';
//        $messages['mobile.min'] = 'The contact number must be at least 8 characters.';
        $request->validate($fields, $messages);

        $userprofileupdate = UserProfileUpdate::find($id);

        $customer = User::find($userprofileupdate->user_id);
        $customer->name = $request->name;
        //$customer->instructor_id = $request->instructor_id??NULL;
        $customer->dob = $request->dob??NULL;
        $customer->email = $request->email??NULL;
        $customer->address = $request->address??NULL;
        $customer->gender = $request->gender??NULL;
        $customer->country_code_phone = $request->country_code_phone??NULL;
        $customer->country_code = $request->country_code??NULL;
        $customer->mobile = $request->mobile??NULL;
//        $customer->approve_status = $request->status??NULL;
        if (!empty($userprofileupdate->password)) {
            $customer->password = $userprofileupdate->password;
        }
        $customer->updated_at = Carbon::now();
        $customer->save();

        $userprofileupdate->approve_status = 1;
        $userprofileupdate->save();

        return redirect()->route('customer.pendingRequest')->with('success',  __('constant.UPDATED', ['module'    =>  $title]));
    }

    public function show($id)
    {
        $title = 'Show Pending Profile Update';
        $customer = UserProfileUpdate::findorfail($id);
        $instructors = User::findorfail($customer->instructor_id);
        return view('admin.account.customer.showpending', compact('title', 'customer','instructors'));
    }
}
