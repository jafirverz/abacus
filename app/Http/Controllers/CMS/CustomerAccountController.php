<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $customer = User::orderBy('id','desc')->paginate($this->pagination);

        return view('admin.account.customer.index', compact('title', 'customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname'  =>  'required',
            'lastname'  =>  'required',
            'email' =>  'required|email|unique:users',
        ]);

        $customer = new User();
        $customer->firstname = $request->firstname;
        $customer->lastname = $request->lastname;
        $customer->email = $request->email;
        $customer->save();

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

        return view('admin.account.customer.show', compact('title', 'customer'));
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

        return view('admin.account.customer.edit', compact('title', 'customer'));
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
            'country_code' => 'required|regex:/^(\+)([1-9]{1,3})$/',
            'mobile' => 'required|string',
            'gender' => 'required|string',
        ];
        $messages = [];
        $messages['email.required'] = 'The email address field is required.';
        $messages['name.required'] = 'The customer name field is required.';
        $messages['email.email'] = 'The email address must be a valid email address.';
        $messages['country_code.required'] = 'The country code field is required.';
        $messages['country_code.regex'] = 'The Country code entered is invalid.';
        $messages['mobile.required'] = 'The contact number field is required.';
        $messages['mobile.min'] = 'The contact number must be at least 8 characters.';
        $request->validate($fields, $messages);

        $customer = User::find($id);
        $customer->name = $request->name;
        $customer->company_name = $request->company_name??NULL;
        $customer->email = $request->email;
        $customer->address = $request->address??NULL;
        $customer->gender = $request->gender;
        $customer->country_code = $request->country_code;
        $customer->mobile = $request->mobile;
		$customer->status = $request->status;
        if (!is_null($request->password)) {
            $customer->password = Hash::make($request->password);
        }
        $customer->updated_at = Carbon::now();
        $customer->save();
        
        if(!empty($request->previousUrll)){
            return redirect($request->previousUrll)->with('success',  __('constant.UPDATED', ['module' => $this->title]));
        }else{
            return redirect()->route('customer-account.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
        }

        // return redirect()->route('customer-account.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
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
        $customer = User::search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $customer->appends('search', $search_term);
        }

        return view('admin.account.customer.index', compact('title', 'customer'));
    }
}
