<?php

namespace App\Http\Controllers\Api\Countries;

use App\Entities\Country;
use App\Http\Controllers\Controller;
use App\Transformers\Countries\CountryTransformer;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Response\paginator;
use Dingo\Api\Routing\Helpers;
use Illuminate\Database\Eloquent\paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Propaganistas\LaravelPhone\PhoneNumber;
use libphonenumber\PhoneNumberFormat;

/**
 * Class CountriesController.
 *
 */
class CountriesController extends Controller
{
    use Helpers;

    /**
     * @var Country
     */
    protected $model;

    /**
     * CountriesController constructor.
     *
     * @param Country $model
     */
    public function __construct(Country $model)
    {
        $this->model = $model;

        $this->middleware('permission:Create acls')->only('store');
        $this->middleware('permission:Update acls')->only('update');
        $this->middleware('permission:Delete acls')->only('destroy');
    }

    /**
     * Returns the Users resource with the roles relation.
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {

        //are we in report mode?
        $report = $request->report;

        $countries = Country::all();
        
        /*if (!$report) {
            $countries = $countries->paginate('limit', $request->get('limit', config('app.pagination_limit')));

            return $this->response->paginator($countries, new CountryTransformer());
        }*/

        return $this->response->collection($countries, new CountryTransformer);

    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $user = $this->model->findOrFail($id);

        return $this->response->item($user, new UserTransformer());
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {

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
