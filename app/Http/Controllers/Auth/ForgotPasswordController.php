<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\User\UserSendPasswordResetLink;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request, UserSendPasswordResetLink $userSendPasswordResetLink)
    {

        $this->validate($request, [
            'email' => 'required|email',
        ]);

        //create item
        try {

            $user_result = $userSendPasswordResetLink->createItem($request->all());
            $user_result = json_decode($user_result);
            $result_message = $user_result->message;
            // dd($result_message, $result_message->message);

            $message = $result_message->message;
            Session::flash('success', $message);
            return redirect()->back();

        } catch(\Exception $e) {

            // dd($e);
            $error_message = $e->getMessage();
            log_this('Error activating user phone === ' . $error_message);
            session()->flash("error", "An error occured\n" . $error_message);
            return redirect()->back()->withInput()->withErrors($error_message);

        }

    }

}
