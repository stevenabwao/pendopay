<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Services\User\ResendConfirmCode;
use App\Services\User\UserConfirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ActivateAccountController extends BaseController
{

    public function showActivationForm(Request $request)
    {

        $phone = "";
        if ($request->has('phone')) {
            $phone = $request->phone;
        }

        return view('auth.activate-account', compact('phone'));

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
            session()->flash("error", $error_message);
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

            // $success_message = 'Successfully created user. Please login.';
            $message = $result_message->message;
            Session::flash('success', $message);
            // return redirect()->route('activate-account');
            return redirect()->route('activate-account', ['phone' => getDatabasePhoneNumber($request->phone)]);

        } catch(\Exception $e) {

            $error_message = json_encode($e->getMessage());
            log_this('Error activating user phone === ' . $error_message);
            //error occured
            session()->flash("error", $error_message);
            return redirect()->back()->withInput()->withErrors($e->getMessage());

        }

    }

}
