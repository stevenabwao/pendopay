<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Services\User\ResendConfirmCode;
use App\Services\User\UserConfirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ActivateAccountController extends BaseController
{

    public function showActivationForm()
    {

        return view('auth.activate-account');

    }

    public function store(Request $request, UserConfirm $userConfirm)
    {

        $this->validate($request, [
            'phone' => 'required|phone:KE,mobile',
            'code' => 'required'
        ]);

        //create item
        try {

            $user_result = $userConfirm->createItem($request->all());
            // dd($user_result);
            $user_result = json_decode($user_result);
            $result_message = $user_result->message;
            // dd($result_message, $result_message->message);

            $message = $result_message->message->message;
            Session::flash('success', $message);
            return redirect()->route('login');

        } catch(\Exception $e) {

            // DB::rollback();
            $error_message = $e->getMessage();
            log_this('Error activating user phone === ' . $error_message);
            session()->flash("error", "An error occured\n" . $error_message);
            return redirect()->back()->withInput()->withErrors($error_message);

        }

    }

    public function showResendActivationCodeForm()
    {

        return view('auth.resend-activation-code');

    }

    public function resendStore(Request $request, ResendConfirmCode $resendConfirmCode)
    {

        $this->validate($request, [
            'phone' => 'required|phone:KE,mobile'
        ]);

        //create item
        try {

            $user_result = $resendConfirmCode->createItem($request->all());
            $user_result = json_decode($user_result);
            $result_message = $user_result->message;

            if (!$user_result->error) {
                // $success_message = 'Successfully created user. Please login.';
                $message = $result_message->message;
                Session::flash('success', $message);
                return redirect()->route('activate-account');
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
