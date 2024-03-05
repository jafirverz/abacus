<?php

namespace App\Http\Controllers\CMS;

use App\Admin;
use App\Country;
use App\Http\Controllers\Controller;
use App\Role;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAccountController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.USER_ACCOUNT');
        $this->module = 'USER_ACCOUNT';
        $this->middleware('grant.permission:'.$this->module);
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
        $roles = Role::all();
        $admins = Admin::orderBy('created_at','DESC')->paginate($this->pagination);

        return view('admin.account.user_account.index', compact('title', 'roles', 'admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $roles = Role::all();
        $countries = Country::orderBy('country', 'DESC')->get();
        return view('admin.account.user_account.create', compact('title', 'roles', 'countries'));
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
            'email' =>  'required|email|unique:admins',
            'password'  =>  'required|min:8',
            'admin_role'    =>  'required',
            'countrry'    =>  'required',
        ]);

        $admins = new Admin;
        $admins->firstname = $request->firstname;
        $admins->lastname = $request->lastname;
        $admins->email = $request->email;
        $admins->country_id = $request->countrry;
        $admins->password = Hash::make($request->password);
        $admins->admin_role = $request->admin_role;
        $admins->status = $request->status;
        $admins->save();

        return redirect()->route('user-account.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $admins = Admin::findorfail($id);

        return view('admin.account.user_account.show', compact('title', 'admins'));
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
        $roles = Role::all();
        $admin = Admin::findorfail($id);
        $countries = Country::get();
        return view('admin.account.user_account.edit', compact('title', 'roles', 'admin', 'countries'));
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
        $request->validate([
            'firstname'  =>  'required',
            'lastname'  =>  'required',
            'email' =>  'required|email|unique:admins,email,'.$id.',id',
            'password'  =>  'nullable|min:8',
            'admin_role'    =>  'required',
            'countrry'    =>  'required',
        ]);

        $admins = Admin::find($id);
        $admins->firstname   =   $request->firstname;
        $admins->lastname   =   $request->lastname;
        $admins->email = $request->email;
        $admins->country_id = $request->countrry;
        if($request->password)
        {
            $admins->password = Hash::make($request->password);
        }
        $admins->admin_role = $request->admin_role;
        $admins->status = $request->status;
        $admins->updated_at = Carbon::now();
        $admins->save();
        
        if(!empty($request->previousUrll)){
            return redirect($request->previousUrll)->with('success',  __('constant.UPDATED', ['module' => $this->title]));
        }else{
            return redirect()->route('user-account.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
        }
        
        // return redirect()->route('user-account.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
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
        if($id<>1)
        {
            Admin::destroy($id);
        }

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;

        $title = $this->title;
        $roles = Role::all();
        $admins = Admin::search($search_term)->paginate($this->pagination);
        if($search_term)
        {
            $admins->appends('search', $search_term);
        }

        return view('admin.account.user_account.index', compact('title', 'roles', 'admins'));
    }
}
