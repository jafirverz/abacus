<?php
namespace App\Http\Controllers\Auth;
use App\Page;
use App\User;
use App\Menu;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;

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

    protected $redirectTo = 'my-profile';
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
            return redirect()->intended('dashboard')
                ->withSuccess('Signed in');
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
        return $this->loggedOut($request) ?: redirect('/home');
    }


}

