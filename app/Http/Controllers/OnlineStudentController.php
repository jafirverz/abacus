<?php

namespace App\Http\Controllers;

use App\Country;
use App\UserFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnlineStudentController extends Controller
{
    //
    public function feedback(){
        $country = Country::get();
        return view('account.feedback', compact('country'));
    }

    public function feedbackstore(Request $request){
        $userfeedback = new UserFeedback();
        $userfeedback->enquiry = $request->enquiry;
        $userfeedback->message = $request->message;
        $userfeedback->user_id = Auth::user()->id;
        $userfeedback->name = Auth::user()->name;
        $userfeedback->email = Auth::user()->email;
        $userfeedback->phone = Auth::user()->mobile;
        $userfeedback->save();
        return redirect()->route('feedback')->with('success', 'Submitted Successfully');
    }
}
