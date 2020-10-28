<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\User;
use App\Services\User\UserRegisterStore;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class RegisterController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers;
    // use ValidatesRequests;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function showRegistrationForm()
    {

        $status_active = config('constants.status.active');
        $counties = getCounties("", $status_active);

        return view('auth.register', compact('counties'));

    }

    public function storeUser(Request $request, UserRegisterStore $userRegisterStore)
    {

        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            // 'dob' => 'required|date|date_format:d/m/Y|before:yesterday',
            // 'dob' => 'required',
            'phone' => 'required|phone:KE,mobile',
            'password' => 'required|min:6|confirmed',
            'terms' => 'required',
            // 'gender' => 'required',
        ]);

        //create item
        try {

            $user_result = $userRegisterStore->createItem($request->all());
            $user_result = json_decode($user_result);
            $result_message = $user_result->message;

            if (!$user_result->error) {
                $success_message = 'Successfully created user. Please login.';
                Session::flash('success', $success_message);
                return redirect()->route('login');
                /* return $request->wantsJson()
                    ? new Response($success_message, 201)
                    : Session::flash('success', $success_message); return redirect()->route('login'); */
            } else {
                $message = $result_message->message->message;
                Session::flash('error', $message);
                return redirect()->back()->withInput()->withErrors($message);
            }

        } catch(\Exception $e) {

            // DB::rollback();
            // dd($e);
            $error_message = json_encode($e->getMessage());
            log_this('Error creating user === ' . $error_message);
            //error occured
            session()->flash("error", "An error occured\n" . $error_message);
            return redirect()->back()->withInput()->withErrors($e);

        }

    }

}
