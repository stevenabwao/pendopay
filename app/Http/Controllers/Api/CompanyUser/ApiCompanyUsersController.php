<?php

namespace App\Http\Controllers\Api\CompanyUser;

use App\Http\Controllers\BaseController;
use App\Services\CompanyUser\CompanyUserIndex;
use App\Services\CompanyUser\CompanyCheckUser;
use App\Services\User\UserStore;
use App\Services\User\UserConfirm;
use App\Transformers\Users\CompanyUserTransformer;
use App\User;
use App\Entities\CompanyUser;
use App\Transformers\Users\CompanyUserDetailTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

/**
 * Class ApiCompanyUsersController
 */
class ApiCompanyUsersController extends BaseController
{

    /**
     * @var User
     */
    protected $model;

    /**
     * UsersController constructor.
     * @param User $model
     */
    public function __construct(CompanyUser $model)
    {
        $this->model = $model;
    }


    /**
     * Returns the Users resource with the roles relation
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request, CompanyUserIndex $companyUserIndex)
    {

        //get the data
        $data = $companyUserIndex->getData($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new CompanyUserTransformer());

        } else {

            if ($request->single==1) {
                $data = $data->first();
                $data = $this->response->item($data, new CompanyUserTransformer());
            } else {
                $data = $data->get();
                $data = $this->response->collection($data, new CompanyUserTransformer());
            }

        }

        return $data;

    }


    /**
     * Returns the Users resource with the roles relation
     * @param Request $request
     * @return mixed
     */
    public function indexDetail(Request $request, CompanyUserIndex $companyUserIndex)
    {

        //get the data
        $data = $companyUserIndex->getData($request);

        // dd("data ", $data->get());

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new CompanyUserDetailTransformer());

        } else {

            if ($request->single==1) {
                
                    $data = $data->first();
                    // dd("data ", $data);
                    if ($data) {
                        $data = $this->response->item($data, new CompanyUserDetailTransformer());
                    } else {
                        $data = [];
                    }

            } else {

                $data = $data->get();
                $data = $this->response->collection($data, new CompanyUserDetailTransformer());

            }

        }

        return $data;

    }


    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $user = $this->model->with('roles.permissions')->byUuid($id)->firstOrFail();
        return $this->response->item($user, new CompanyUserTransformer());
    }
    
    /**
     * @param $id
     * @return mixed
     */
    public function checkUser(Request $request, CompanyCheckUser $companyCheckUser)
    {
        //get the data
        $data = $companyCheckUser->getData($request);

        return $data;
    }

    /**
     * get logged in user
     */
    public function loggeduser()
    {
        $user = auth()->user();
        return $this->response->item($user, new CompanyUserTransformer());
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
            throw new StoreResourceFailedException($error_messages);
        }

        //$user = $this->model->create($request->all());
        $user = $userConfirm->confirmAccount($request);

        return $user;


    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request, UserStore $userStore)
    {

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_country' => 'required_with:phone',
            'phone' => 'required|phone',
            'email' => 'sometimes|nullable|email',
            //'email' => 'sometimes|nullable|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            //'company_id' => 'required|integer',
        ];

        $payload = app('request')->only('first_name', 'last_name', 'phone', 'phone_country', 'email', 'password', 'password_confirmation');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        //$user = $this->model->create($request->all());
        $user = $userStore->createItem($request->all());

        //return $this->response->created();
        return ['message' => 'User created.'];
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
            throw new StoreResourceFailedException($validator->errors());
        }

        // Except password as we don't want to let the users change a password from this endpoint
        $user->update($request->except('_token', 'password'));
        if ($request->has('roles')) {
            $user->syncRoles($request['roles']);
        }
        return $this->response->item($user->fresh(), new CompanyUserTransformer());

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
