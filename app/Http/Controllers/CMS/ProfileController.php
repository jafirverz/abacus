<?php

namespace App\Http\Controllers\CMS;

use App\Insurance;
use App\InsuranceInformation;
use App\InsuranceQuotation;
use App\InsuranceVehicle;
use App\Admin;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.PROFILE');
        $this->module = 'PROFILE';
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
	public function index()
    {
        $title = $this->title;
		dd(123);
        return view('admin.home', compact('title'));
    }
    public function edit()
    {
        $title = $this->title;
        $admin = Admin::findorfail($this->user->id);

        return view('admin.account.profile.edit', compact('title', 'admin'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'firstname'  =>  'required',
            'lastname'  =>  'required',
            'email' =>  'required|email',
            'profile' => 'nullable|file|mimes:jpg,png,gif,jpeg|max:5000',
            'password'  =>  'nullable|required_with:old_password|confirmed|min:8',
        ]);

        $admin = Admin::findorfail($this->user->id);
		$admin->firstname = $request->firstname;
        $admin->lastname = $request->lastname;
        $admin->email = $request->email;
        if($request->old_password)
        {
            if(!Hash::check($request->old_password, $admin->password))
            {
                return redirect()->back()->with('error', 'Old password does not match.');
            }
            $admin->password = Hash::make($request->password);
        }
        if ($request->hasFile('profile')) {
            $profile_image = $request->file('profile');
            $filename = Carbon::now()->format('YmdHis') . '__' . $profile_image->getClientOriginalName();
            $filepath = 'storage/profile/';
            Storage::putFileAs(
                'public/profile', $profile_image, $filename
            );
            $path_profile = $filepath . $filename;
            $admin->profile = $path_profile;
        }
		if(isset($request->delete_picture) && $request->delete_picture==1)
        {
		$admin->profile = NULL;	
		}
        $admin->save();

        return redirect()->back()->with('success', __('constant.UPDATED', ['module' => $this->title]));
    }
	
	public function insurance_applications($slug = 'insurance-applications')
	{
		 $page = get_page_by_slug($slug);
		//dd($page);
        if (!$page) {
            return abort(404);
        }
	}
	
	
}
