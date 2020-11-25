<?php

namespace App\Http\Controllers\Api\Users;

use App\User;
use App\Entities\UserLogin;
use App\Http\Resources\User\UserResource;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginProxy
{

    use AuthenticatesUsers;

    const REFRESH_TOKEN = 'refreshToken';
    private $model;
    private $auth;
    private $cookie;
    private $db;
    private $request;

    public function __construct(Application $app, User $model) {

        $this->model = $model;

        $this->auth = $app->make('auth');
        $this->cookie = $app->make('cookie');
        $this->db = $app->make('db');
        $this->request = $app->make('request');

    }

    /**
     * Attempt to create an access token using user credentials
     *
     * @param string $username
     * @param string $password
     */
    public function attemptLogin($username, $password)
    {

        //user login object
        $userlogin = new UserLogin();

        $user = $this->model->where('email', $username)
                ->orWhere('phone', $username)
                ->first();

        if ($user) {

            if (validateEmail($username)) {
                $attributes['email'] = $username;
            } else {
                $attributes['phone'] = $username;
            }

            //if user is not activated, show message
            if ($user->active != 1) {

                //start save user login details
                $attributes['status'] = 'failed';
                $attributes['action'] = 'apilogin';

                $userlogin = $userlogin->create($attributes);
                //end save user login details
                throw new \Exception(trans('auth.inactive'));

            }
            // dd("user === ", $user);

            //start save user login details
            $attributes['status'] = 'success';
            $attributes['action'] = 'apilogin';

            try {

                $userlogin = $userlogin->create($attributes);

            } catch(\Exception $e) {

                throw new \Exception($e->getMessage());

            }
            //end save user login details

            // dd("after === ", $userlogin);

            return $this->proxy('password', [
                'username' => $username,
                'password' => $password
            ]);

        } else {

            //start save user login details
            $attributes['status'] = 'failed';
            $attributes['action'] = 'apilogin';

            $userlogin = $userlogin->create($attributes);
            //end save user login details

            throw new \Exception(trans('auth.failed'));

        }

    }

    //check if user account exists
    public function checkLogin($username, $password)
    {

        //DB::enableQueryLog();
        $user = $this->model->where('phone', $username)
                            ->orWhere('email', $username)
                            ->first();

        //start audit data
        if (validateEmail($username)) {
            $attributes['email'] = $username;
        } else {
            $attributes['phone'] = $username;
        }
        //end audit data

        //user login object
        $userlogin = new UserLogin();

        if ($user) {

            $hasher = app('hash');
            if ($hasher->check($password, $user->password)) {

                // Success

                //start save user login details
                $attributes['status'] = 'success';
                $attributes['action'] = 'checklogin';

                $userlogin = $userlogin->create($attributes);
                //end save user login details

                return show_success("user exists");

            } else {

                //start save user login details
                $attributes['status'] = 'failed';
                $attributes['action'] = 'checklogin';

                $userlogin = $userlogin->create($attributes);
                //end save user login details

                $message = "Wrong PIN entered.";
                return show_error($message);

            }

        } else {

            //start save user login details
            $attributes['status'] = 'failed';
            $attributes['action'] = 'checklogin';

            $userlogin = $userlogin->create($attributes);
            //end save user login details

            $message = "Wrong PIN entered.";
            return show_error($message);
        }
        //print_r(DB::getQueryLog());

    }

    /**
     * Attempt to refresh the access token used a refresh token that
     * has been saved in a cookie
     */
    public function attemptRefresh($request)
    {
        //$refreshToken = $this->request->cookie(self::REFRESH_TOKEN);
        $refreshToken = $request->refresh_token;

        return $this->proxy('refresh_token', [
            'refresh_token' => $refreshToken
        ]);
    }

    /**
     * Proxy a request to the OAuth server.
     *
     * @param string $grantType what type of grant type should be proxied
     * @param array $data the data to send to the server
     */
    public function proxy($grantType, array $arr_data = [])
    {
        $data = array_merge($arr_data, [
            'client_id' => config('app.password_client_id'),
            'client_secret' => config('app.password_client_secret'),
            'grant_type'    => $grantType,
            'scope'    => ''
        ]);

        // Create request
        $request = Request::create('/oauth/token', 'POST', $data, [], [], [
            'HTTP_Accept' => 'application/json',
        ]);
        // Get response
        $response = app()->handle($request);
        // dd("response --- ", $response);

        if (!$response->isSuccessful()) {
            $message = "Wrong login credentials";
            // return ['status_code' => 422, 'message' => $message];
            // return response()->json(showCompoundMessage(422, $message));
            // return response()->json(['error' => 'You need to add a card first'], 422);
            // return show_error_response($message);
            throw new \Exception($message);
        }

        $data = json_decode($response->getContent());

        // Create a refresh token cookie
        $this->cookie->queue(
            self::REFRESH_TOKEN,
            $data->refresh_token,
            864000, // 10 days
            null,
            null,
            false,
            true // HttpOnly
        );

        //get user
        $username = $arr_data['username'];
        $user = $this->model->where('phone', $username)
                            ->orWhere('email', $username)
                            ->first();

        $name = $user->first_name . " " .$user->last_name;

        return [
            'access_token' => $data->access_token,
            'refresh_token' => $data->refresh_token,
            'expires_in' => $data->expires_in,
            'user_id' => $user->id,
            'email' => $user->email,
            'phone' => getDatabasePhoneNumber($user->phone),
            'name' => $name,
            'user' => new UserResource($user)
        ];
    }

    /**
     * Logs out the user. We revoke access token and refresh token.
     * Also instruct the client to forget the refresh cookie.
     * Update user's access token in user_access_tokens table to blank
     */
    public function logout()
    {

        // delete users token in passport oauth_tokens table
        $auth_user = $this->auth->user();
        $auth_user->token()->delete();

        //DB::enableQueryLog();
        //dd(DB::getQueryLog());

        // delete from user_access_tokens
        //dd($auth_user->useraccesstoken()->first());
        $auth_user->useraccesstoken()->first()->update([
                        'access_token' => '',
                        'refresh_token' => ''
                    ]);

        // forget the refresh token too
        $this->cookie->queue($this->cookie->forget(self::REFRESH_TOKEN));

    }

}
