<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Api\Users\LoginProxy;
use App\Http\Controllers\ApiController;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

/**
 * Class ApiLoginController
 */
class ApiLoginController extends ApiController
{

    protected $server;

    protected $tokens;

    private $loginProxy;

    /**
     * LoginController constructor
    */
    public function __construct(LoginProxy $loginProxy) {
        $this->loginProxy = $loginProxy;
    }

    public function login(LoginRequest $request)
    {

        $loginData = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->get('username');

        if (!isValidEmail($username)) {
            $phone_country = 'KE';
            if ($request->has('phone_country')) {
                $phone_country = $request->get('phone_country');
            }
            $username = getDatabasePhoneNumber($username, $phone_country);
        }
        $password = $request->get('password');

        try {

            $response_data = $this->loginProxy->attemptLogin($username, $password);

        } catch(\Exception $e) {

            return showCompoundMessage(422, $e->getMessage());

        }

        $message = "Successful login";
        return showCompoundMessage(200, $message, $response_data);

    }

    public function checklogin(LoginRequest $request)
    {
        $username = $request->get('username');
        $phone_country = $request->get('phone_country');
        //check whether username is phone
        if ($phone_country) {
            $username = getDatabasePhoneNumber($username, $phone_country);
        }
        $password = $request->get('password');

        return response($this->loginProxy->checkLogin($username, $password));
    }

    public function refresh(Request $request)
    {
        return response($this->loginProxy->attemptRefresh($request));
    }

    public function logout()
    {
        $this->loginProxy->logout();

        return response()->json([null], 204); // Status code here

    }

}
