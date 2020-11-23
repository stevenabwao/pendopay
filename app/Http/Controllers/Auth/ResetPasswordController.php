<?php

namespace App\Http\Controllers\Auth;

use App\Entities\PasswordReset;
use App\Http\Controllers\Controller;
use App\Services\User\UserResetPassword;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /* $this->middleware('guest'); */
    }

    // reset form
    /* public function showResetForm(Request $request, $token = null)
    {

        $error_msg = "";
        $password_reset = PasswordReset::where('token', $token)
                                        ->where('status_id', getStatusActive())
                                        ->first();
        if (!$password_reset) {
            $error_msg = "Invalid password reset link";
        }

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email, 'error_msg' => $error_msg]
        );

    } */

    // reset form
    public function showResetForm(Request $request, $token = null)
    {

        $error_msg = "";
        $password_reset = PasswordReset::where('token', $token)
                                        ->where('status_id', getStatusActive())
                                        ->first();
        if (!$password_reset) {

            $error_msg = "Invalid password reset link";

        } else {

            // check if reset token is still valid
            // get set lifetime
            $site_settings = getSiteSettings();
            $token_lifetime_minutes = $site_settings['password_reset_token_lifetime_minutes'];
            $interval="minute";
            $created_date = formatDatePickerDate(getUTCDate($password_reset->created_at), $format='Y-m-d H:i:s');
            $current_date = formatDatePickerDate(getUpdatedDate(), $format='Y-m-d H:i:s');
            // get the date difference in minutes
            $token_age = getDateDiff($created_date, $current_date, $interval, 'Y-m-d H:i:s');
            // dd($current_date, $created_date, $token_age, $token_lifetime_minutes);

            // if token has expired, show error
            if ($token_lifetime_minutes < $token_age) {
                $error_msg = "Expired password reset link";
            }

        }

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email, 'error_msg' => $error_msg]
        );

    }


    public function reset(Request $request, UserResetPassword $userResetPassword)
    {

        $this->validate($request, [
            'new_password' => 'required|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'token' => 'required',
        ]);

        //create item
        try {

            $user_result = $userResetPassword->createItem($request->all());
            $user_result = json_decode($user_result);
            $result_message = $user_result->message;
            // dd($result_message);

            $message = $result_message->message->message;
            Session::flash('success', $message);
            return redirect()->route('login');

        } catch(\Exception $e) {

            dd($e);
            $error_message = $e->getMessage();
            log_this('Error activating user phone === ' . $error_message);
            session()->flash("error", "An error occured\n" . $error_message);
            return redirect()->back()->withInput()->withErrors($error_message);

        }

    }

}
