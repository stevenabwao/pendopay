<?php

namespace App\Http\Controllers\Api\Users;

use App\Entities\UserSetting;
use App\Http\Controllers\BaseController;
use App\Services\User\UserIndex;
use App\Services\User\UserIndexUssd;
use App\Services\User\BasicUserIndex;
use App\Services\User\UserActiveCompanyIndex;
use App\Services\User\UserStore;
use App\Services\User\UserConfirm;
use App\Services\User\UserCompanyIndex;
use App\Services\User\UserChangePassword;
use App\Services\User\UserResetPassword;
use App\Transformers\Users\UserTransformer;
use App\Transformers\Users\CompanyUserTransformer;
use App\Transformers\Users\BasicUserTransformer;
use App\Transformers\Company\CompanyTransformer;
use App\Transformers\Users\UserDetailTransformer;
use App\User;
use Illuminate\Http\Request;

/**
 * Class ApiUsersController
 */
class ApiUsersController extends BaseController
{

    /**
     * @var User
     */
    protected $model;

    /**
     * ApiUsersController constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }


    /**
     * Returns the Users resource with the roles relation
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request, UserIndex $userIndex)
    {

        //get the data
        $data = $userIndex->getUsers($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new CompanyUserTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new CompanyUserTransformer());

        }

        return $data;

        /*$paginator = $this->model->with('roles.permissions')
            ->paginate($request->get('limit', config('app.pagination_limit')));
        return $this->response->paginator($paginator, new CompanyUserTransformer());*/
    }


    public function indexUssd(Request $request, UserIndexUssd $userIndexUssd)
    {

        //get the data
        $data = $userIndexUssd->getUsers($request);
        // dd("data", $data);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new UserTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new UserTransformer());

        }

        return $data;

        /*$paginator = $this->model->with('roles.permissions')
            ->paginate($request->get('limit', config('app.pagination_limit')));
        return $this->response->paginator($paginator, new CompanyUserTransformer());*/
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        // try {
            $user = $this->model->with('roles.permissions')->where('id', $id)->firstOrFail();
            // $user = $this->model->findOrFail($id);
            return $this->response->item($user, new UserTransformer());
        /* } catch(Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            handleExceptions($e);
        } */
    }

    public function showBasicUser(Request $request, BasicUserIndex $basicUserIndex)
    {

        $default_company_id = "";
        // dd($request->all());
        // get default company
        $default_company_data = UserSetting::where('phone', $request->phone)->first();

        if ($default_company_data)  {
            $default_company_id = $default_company_data->default_company_id;
        }
        
        // get the data - 254711753528
        $data = $basicUserIndex->getData($request);

        $data->default_company_id = $default_company_id;

        $data = $this->response->item($data, new BasicUserTransformer());

        return $data;

    }

    /**
     * get logged in user
     */
    public function loggeduser()
    {
        $user = auth()->user();
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * confirm an account
     * @param Request $request
     * @return mixed
     */
    public function accountconfirm(Request $request, UserConfirm $userConfirm)
    {

        $rules = [
            'phone_country' => 'required_with:phone',
            'phone' => 'required|phone',
            'confirm_code' => 'required',
        ];

        $payload = app('request')->only('confirm_code', 'phone', 'phone_country');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            //throw new StoreResourceFailedException($validator->errors());
            $message = "Please enter all required fields";
            return show_error($message);
        }

        //$user = $this->model->create($request->all());
        $user = $userConfirm->confirmAccount($request);

        return $user;


    }


    /**
     * confirm an account
     * @param Request $request
     * @return mixed
     */
    public function ChangePassword(Request $request, UserChangePassword $userChangePassword)
    {

        $rules = [ 
            'current_pin' => 'required|digits:4',
            'new_pin' => 'required|digits:4|confirmed',
        ];

        $payload = app('request')->only('current_pin', 'new_pin', 'new_pin_confirmation');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            $message = "An error occured - " . $validator->errors();
            return show_error($message);
        }

        $result = $userChangePassword->changePassword($request->all());
        $result = json_decode($result);
        $result_message = $result->message;

        if (!$result->error) {
            //success
            return show_success($result_message);
        } else {
            //error occured
            return show_error($result_message);
        }


    }

    /**
     * reset password
     * @param Request $request
     * @return mixed
     */
    public function ResetPassword(Request $request, UserResetPassword $userResetPassword)
    {

        $rules = [ 
            'phone_country' => 'required_with:phone',
            'phone' => 'required|phone',
            'idno' => 'required',
            'email' => 'required|email',
        ];

        $payload = app('request')->only('phone_country', 'phone', 'idno', 'email');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            $message = "An error occured - " . $validator->errors();
            return show_error($message);
        }

        $result = $userResetPassword->resetPassword($request->all());
        $result = json_decode($result);
        $result_message = $result->message;

        if (!$result->error) {
            //success
            return show_success($result_message);
        } else {
            //error occured
            return show_error($result_message);
        }

    }


    /**
     * @param Request $request
     * @return mixed 
     */
    public function store(Request $request, UserStore $userStore)
    {

        $rules = [ 
            'first_name' => 'required|regex:/^[\pL\s\-]+$/u|max:100',
            'last_name' => 'required|regex:/^[\pL\s\-]+$/u|max:100',
            // 'phone_country' => 'required_with:phone',
            // 'phone' => 'required|phone',
            'password' => 'required|digits:4|confirmed',
        ];

        $payload = app('request')->only('first_name', 'last_name', 'password', 'password_confirmation');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            //throw new StoreResourceFailedException($validator->errors());
            //$message = "Please enter all required fields ";
            $message = $validator->errors();
            return show_error($message);
        }

        $result = $userStore->createItem($request->all());
        $result = json_decode($result);
        $result_message = $result->message;

        if (!$result->error) {
            //success
            return show_success($result_message);
        } else {
            //error occured
            return show_error($result_message);
        }

        //return $this->success('User created');

    }


    public function getCompanies(Request $request, UserCompanyIndex $userCompanyIndex)
    {

        // dd($request->all());
        //get the data
        $data = $userCompanyIndex->getData($request);
        // dd("data *** ", $data);

        $data = $data->get();
        $data = $this->response->collection($data, new CompanyTransformer());

        // dd("data here == ", $data);

        return $data;

    }


    public function getActiveCompany($user_id, UserActiveCompanyIndex $userActiveCompanyIndex)
    {

        //get the data
        $data = $userActiveCompanyIndex->getData($user_id);

        // $data = $data->get();
        $data = $this->response->item($data, new CompanyTransformer());

        // dd("data here == ", $data);

        return $data;

    }


    /**
     * @param Request $request
     * @param $uuid
     * @return mixed
     */
    public function update(Request $request, $uuid)
    {

        $user = $this->model->byUuid($uuid)->firstOrFail();

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|phone:KE,mobile',
            'email' => 'sometimes|nullable|email|unique:users,email,'.$user->id,
        ];

        $payload = app('request')->only('first_name', 'last_name', 'phone', 'email');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            //throw new StoreResourceFailedException($validator->errors());
            $message = "Please enter all required fields";
            return show_error($message);
        }

        // Except password as we don't want to let the users change a password from this endpoint
        $user->update($request->except('_token', 'password'));
        if ($request->has('roles')) {
            $user->syncRoles($request['roles']);
        }
        return $this->response->item($user->fresh(), new UserTransformer());

    }

    /**
     * @param Request $request
     * @param $uuid
     * @return mixed
     */
    public function destroy(Request $request, $uuid)
    {
        $user = $this->model->byUuid($uuid)->firstOrFail();
        $user->delete();
        return $this->response->noContent();
    }
    
}
