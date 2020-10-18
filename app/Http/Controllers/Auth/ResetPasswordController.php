<?php

namespace App\Http\Controllers\Auth;

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
        $this->middleware('guest');
    }

    public function reset(Request $request, UserResetPassword $userResetPassword)
    {

        $this->validate($request, [
            'email' => 'required|email'
        ]);

        //create item
        try {

            $user_result = $userResetPassword->createItem($request->all());
            $user_result = json_decode($user_result);
            $result_message = $user_result->message;
            // dd($result_message);

            if (!$user_result->error) {
                $message = $result_message->message;
                Session::flash('success', $message);
                return redirect()->route('login');
            } else {
                $message = $result_message->message;
                Session::flash('error', $message);
                return redirect()->back()->withInput()->withErrors($message);
            }

        } catch(\Exception $e) {

            DB::rollback();
            $error_message = json_encode($e->getMessage());
            log_this('Error activating user phone === ' . $error_message);
            //error occured
            session()->flash("error", "An error occured\n" . $error_message);
            return redirect()->back()->withInput()->withErrors($e);

        }

    }

}
