<?php

namespace App\Http\Controllers\Api\Countries;

use App\Entities\Country;
use App\Http\Controllers\Controller;
use App\Services\Country\CountryIndex;
use App\Transformers\Country\CountryTransformer;
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
 * Class ApiCountriesController.
 *
 */
class ApiCountriesController extends Controller
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
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CountryIndex $countryIndex)
    {

        //get the data
        $data = $countryIndex->getCountries($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new CountryTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new CountryTransformer());

        }

        return $data;

    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $user = $this->model->findOrFail($id);

        return $this->response->item($user, new CountryTransformer());
    }

    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required',
            'sortname' => 'required',
            'phonecode' => 'required|integer'
        ];

        $payload = app('request')->only('name', 'sortname', 'phonecode');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        //create item
        $this->model->create($request->all());

        return ['message' => 'Country created.'];

    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function update(Request $request, $id)
    {

        $rules = [
            'name' => 'required',
            'sortname' => 'required',
            'phonecode' => 'required|integer'
        ];

        $payload = app('request')->only('name', 'sortname', 'phonecode');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }
        
        // update data fields
        $this->model->updatedata($id, $request->all());

        return $this->response->item($item->fresh(), new CountryTransformer());

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function destroy(Request $request, $id)
    {
        
        $user_id = auth()->user()->id;

        $item = $this->model->findOrFail($id);
        
        if ($item) {
            //update deleted by field
            $item->update(['deleted_by' => $user_id]);
            $result = $item->delete();
        }

        return $this->response->noContent();
    }

}
