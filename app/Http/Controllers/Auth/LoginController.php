<?php
namespace App\Http\Controllers\Auth;
use App\Page;
use App\User;
use App\Menu;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\View;

use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Hash;
use App\Traits\SystemSettingTrait;
use App\Mail\EmailNotification;
use App\Traits\GetEmailTemplate;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmail;
use Carbon\Carbon;

//use Socialite;

use Session;
class LoginController extends Controller

{

    /*

    |--------------------------------------------------------------------------

    | Login Controller

    |--------------------------------------------------------------------------

    |

    | This controller handles authenticating users for the application and

    | redirecting them to your home screen. The controller uses a trait

    | to conveniently provide its functionality to your applications.

    |

    */
    use GetEmailTemplate, SystemSettingTrait,AuthenticatesUsers;
    /**

     * Where to redirect users after login.

     *

     * @var string

     */

    protected $redirectTo = 'home';
    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()
    {

        Auth::viaRemember();
		$this->middleware('guest')->except('logout');
		$this->system_settings = $this->systemSetting();

    }
    protected function guard()
    {

        return Auth::guard('web');

    }

    public function login(Request $request)
    {
        $request->validate([
            'account_id' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('account_id', 'password');
        if (Auth::attempt($credentials)) {
            $userType = array(1,2,3,4,5);
            if(in_array(Auth::user()->user_type_id,$userType)){
                if(Auth::user()->approve_status == 1){
                    return redirect()->intended('home')
                ->withSuccess('Signed in');
                }else{
                    Auth::logout();
                    return redirect("login")->withError('User not approved');
                }
                
            }else{
                return redirect()->intended('instructor/overview')
                ->withSuccess('Signed in');
            }
            
        }

        return redirect("login")->withError('Login details are not valid');
    }

    /**

     * Send the response after the user was authenticated.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    protected function sendLoginResponse(Request $request)
    {
        $redirectTo = url('home');

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())

                ?: redirect()->intended($redirectTo);
    }
	public function showLoginForm()
    {
        //session()->forget('previous_url');
        $slug = __('constant.SLUG_LOGIN');

		$page = get_page_by_slug($slug);

		//dd($page);

        if(!$page)
        {
            return abort(404);
        }
        return view('auth.login',compact("page"));
    }

    public function forgetaccountid()
    {
        return view('forget_account_id');
    }

    public function checkaccountid(Request $request)
    {
        $messages = [
            'name.required' => 'This field is required',
            'email.required' => 'This field is required',
            'dob.required' => 'This field is required',

        ];

        $request->validate([
            'name' => 'required|string',
            'email' =>  'required|email|exists:users,email',
            'dob' => 'required',
        ], $messages);

        $dob = date('Y-m-d', strtotime($request->dob));
        $user = User::where('email', $request->email)->where('dob', $dob)->first();
        if(empty($user)){
            throw ValidationException::withMessages(['email' => 'Email Id and DOB does not match']);
//            return back()->withErrors('Details does not match')->withInput();
        }
        if($user){
            //			Student email for forget account id
            $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_STUDENT_ACCOUNT_ID'));

            if ($email_template) {
                $data = [];
                    $data['email_sender_name'] = systemSetting()->email_sender_name;
                    $data['from_email'] = systemSetting()->from_email;
                    $data['to_email'] = [$user->email];
                    $data['cc_to_email'] = [];
                    $data['subject'] = $email_template->subject;

                    $key = ['{{account_id}}'];
                    $value = [$user->account_id];

                    $newContents = str_replace($key, $value, $email_template->content);

                    $data['contents'] = $newContents;
                    try {
                        $mail = Mail::to($user->email)->send(new EmailNotification($data));
                        return redirect('forget-account-id')->with('success',  'Please check your email.');
                    } catch (Exception $exception) {
                        dd($exception);
                    }

            }
        }
    }





	protected function credentials(Request $request)
    {
		//return array_merge($request->only($this->username(), 'password'));
        return $request->only($this->username(), 'password');
    }

	public function redirectToProvider($provider, Request $request)
    {
        if (isset($request->redirect_url)) {
            session(['redirect_url' => $request->redirect_url]);
        }
        return Socialite::driver($provider)->redirect();
    }







    /**

     * Get the failed login response instance.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Symfony\Component\HttpFoundation\Response

     *

     * @throws \Illuminate\Validation\ValidationException

     */

   /* protected function sendFailedLoginResponse(Request $request)

    {

        return response()->json(['error' => trans('auth.failed')], 422);

    }*/
	protected function attemptLogin(Request $request)
	{

		$remember =$request->has('remember');

		return $this->guard()->attempt(
			$this->credentials($request), $remember
		);
	}

    public function logout(Request $request)
    {
        $sessionKey = $this->guard()->getName();
        $this->guard()->logout();
        $request->session()->forget($sessionKey);
        return $this->loggedOut($request) ?: redirect('/login');
    }


}

