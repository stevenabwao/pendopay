<?php

namespace App\Http\Controllers\Api\States;

use App\Entities\Country;
use App\Entities\State;
use App\Http\Controllers\Controller;
use App\Services\State\StateIndex;
use App\Transformers\State\StateTransformer;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Response\paginator;
use Dingo\Api\Routing\Helpers;
use Illuminate\Database\Eloquent\paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ApiStatesController.
 *
 */
class ApiStatesController extends Controller
{
    use Helpers;

    /**
     * @var state
     */
    protected $model;

    /**
     * StatesController constructor.
     *
     * @param State $model
     */
    public function __construct(State $model)
    {
        $this->model = $model;
    }

    public function index(Request $request, StateIndex $stateIndex)
    {

        //get the data
        $data = $stateIndex->getData($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new StateTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new StateTransformer());

        }

        return $data;

    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $state = $this->model->findOrFail($id);

        return $this->response->item($state, new StateTransformer());
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'email|unique:users,email',
            'phone_number' => 'required|max:13',
            'password' => 'required|min:6|confirmed'
        ];

        $payload = app('request')->only('first_name', 'last_name', 'email', 'phone_number', 'password', 'password_confirmation');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not create new user.', $validator->errors());
        }

        //set user attributes
        $attributes = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => formatPhoneNumber($request->phone_number),
            'email' => $request->email,
            'gender' => $request->gender,
            'country_id' => $request->country_id,
            'password' => $request->password,
            'src_host' => getUserAgent(),
            'src_ip' => getIp(),
            'created_at' => getCurrentTime()
        ];

        //create user
        $user = $this->model->create($attributes);

        //$user = $this->model->create($request->all());

        if ($request->has('roles')) {
            $user->syncRoles($request['roles']);
        }

        //return $this->response->created(url('api/users/'.$user->uuid));
        return $this->response->created();

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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'name' => 'sometimes|required',
                'email' => 'sometimes|required|email|unique:users,email,'.$user->id,
            ];
        }
        $this->validate($request, $rules);
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
