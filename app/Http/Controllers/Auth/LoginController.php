<?php

namespace App\Http\Controllers\Auth;

use App\Entities\UserLogin;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // allow only guest users here
    // logged in users will be thrown out
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // show login form
    public function showLoginForm()
    {
        // return user to previous page if it exists
        if(!session()->has('url.intended'))
        {
            session(['url.intended' => url()->previous()]);
        }
        return view('_web.auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        // dd("request == ", $request->all());

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {

            //start save user details if login locked
            $request->merge([
                'status' => 'locked',
                'action' => 'login',
            ]);
            $userlogin = new UserLogin();
            $userlogin = $userlogin->create($request->toArray());
            //end save user details if login locked

            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);

        }
        //dd($request);

        // was login successful
        if ($this->attemptLogin($request)) {

            // logout other devices
            Auth::logoutOtherDevices($request->password);

            //start save user details if login succeeded
            $request->merge([
                'status' => 'success',
                'action' => 'login',
            ]);
            //dd($request);
            $userlogin = new UserLogin();
            $userlogin = $userlogin->create($request->toArray());
            //end save user details if login succeeded

            return $this->sendLoginResponse($request);

        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        //start save user details if login failed
        $request->merge([
            'status' => 'failed',
            'action' => 'login',
        ]);
        $userlogin = new UserLogin();
        $userlogin = $userlogin->create($request->toArray());
        //end save user details if login failed

        return $this->sendFailedLoginResponse($request);

    }

    // set login credentials based on what the user enters in login page
    protected function credentials(Request $request)
    {

        if (isValidEmail($request->username)) {

            return [
                'email'=>$request->{$this->username()},
                'password'=>$request->password,
                'status_id'=>1,
                'active'=>1
            ];

        } else {

            return [
                'phone'=> getDatabasePhoneNumber($request->{$this->username()}),
                'password'=>$request->password,
                'status_id'=>1,
                'active'=>1
            ];

        }

    }

    // set the username
    public function username()
    {
        return 'username';
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect(route('login'));
    }


    /**** start change password route ****/
    public function changepass()
    {
        //dd('hello');
        return view('_web.auth.changepass');
    }

    public function changepassStore()
    {
        return view('_web.auth.changepass');
    }
    /**** end change password route ****/


    /////////////////////////////////////////
    public function tokenAuthCheck (Request $request) {
		return [
			'request' => $request->get('id'),
			'auth'    => Auth::check() ? Auth::id() : -9999,
		];
	}

	public function tokenAuthUser (Request $request) {
		return [
			'request' => $request->get('id'),
			'auth'    => Auth::user()->id,
		];
	}

	public function tokenAuthId (Request $request) {
		return [
			'request' => $request->get('id'),
			'auth'    => Auth::id(),
		];
	}

	public function tokenAuthAttempt (Request $request) {
		Auth::attempt([ 'email' => $request->get('email'), 'password' => $request->get('password') ]);

		return [
			'request' => $request->get('id'),
			'auth'    => Auth::id(),
		];
	}

	public function tokenAuthOnce (Request $request) {
		Auth::once([ 'email' => $request->get('email'), 'password' => $request->get('password') ]);

		return [
			'request' => $request->get('id'),
			'auth'    => Auth::id(),
		];
	}

	public function tokenAuthLogin (Request $request) {
		Auth::login(User::find($request->get('id')));
	}

	public function tokenAuthLoginUsingId (Request $request) {
		Auth::loginUsingId($request->get('id'));

		return [
			'request' => $request->get('id'),
			'auth'    => Auth::id(),
		];
	}

	public function tokenAuthLogout (Request $request) {
		Auth::logout();

		return [
			'request' => $request->get('id'),
			'auth'    => Auth::id(),
		];
	}

	public function tokenAuthValidate (Request $request) {
		$isValidated = Auth::validate([ 'email' => $request->get('email'), 'password' => $request->get('password') ]);

		return [
			'request' => $request->get('id'),
			'auth'    => $isValidated ? $request->get('id') : -8998,
		];
	}

	public function apiAuthCheck (Request $request) {
		return [
			'request' => $request->get('id'),
			'auth'    => Auth::check() ? Auth::id() : -9999,
		];
	}

	public function apiAuthUser (Request $request) {
		return [
			'request' => $request->get('id'),
			'auth'    => Auth::user()->id,
		];
	}

	public function apiAuthId (Request $request) {
		return [
			'request' => $request->get('id'),
			'auth'    => Auth::id(),
		];
	}

	public function apiAuthAttempt (Request $request) {
		Auth::attempt([ 'email' => $request->get('email'), 'password' => $request->get('password') ]);

		return [
			'request' => $request->get('id'),
			'auth'    => Auth::id(),
		];
	}

	public function apiAuthOnce (Request $request) {
		Auth::once([ 'email' => $request->get('email'), 'password' => $request->get('password') ]);

		return [
			'request' => $request->get('id'),
			'auth'    => Auth::id(),
		];
	}

	public function apiAuthLogin (Request $request) {
		Auth::login(User::find($request->get('id')));
	}

	public function apiAuthLoginUsingId (Request $request) {
		Auth::loginUsingId($request->get('id'));

		return [
			'request' => $request->get('id'),
			'auth'    => Auth::id(),
		];
	}

	public function apiAuthLogout (Request $request) {
		Auth::logout();

		return [
			'request' => $request->get('id'),
			'auth'    => Auth::id(),
		];
	}

	public function apiAuthValidate (Request $request) {
		$isValidated = Auth::validate([ 'email' => $request->get('email'), 'password' => $request->get('password') ]);

		return [
			'request' => $request->get('id'),
			'auth'    => $isValidated ? $request->get('id') : -8998,
		];
	}
    /////////////////////////////////////////

}
