<?php

namespace App\Http\Controllers\Api\Charge;

use App\Entities\Charge;
use App\Entities\Company;
use App\Entities\Group;
use App\Http\Controllers\BaseController;
use App\Services\Charge\ChargeIndex;
use App\Transformers\Charge\ChargeTransformer;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;

class ApiChargeController extends BaseController
{
    
    /**
     * @var Charge
     */
    protected $model;

    /**
     * ChargeController constructor.
     *
     * @param Charge $model
     */
    public function __construct(Charge $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ChargeIndex $chargeIndex)
    {

        /*start cache settings*/
        $url = request()->url();
        $params = request()->query();
        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration('low'); 
        /*end cache settings*/

        //get the data
        $data = $chargeIndex->getCharges($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new ChargeTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new ChargeTransformer());

        }

        //return api data
        /*return Cache::remember($fullUrl, $minutes, function () use ($data) {
            return $data;
        });*/

        return $data;

    }


    /**
     * @param $id
     * @return mixed
    */
    public function show($id)
    {
        $item = $this->model->findOrFail($id);

        return $this->response->item($item, new ChargeTransformer());
    }


    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request)
    {

        $rules = [
            'charge_cd' => 'required',
            'description' => 'required'
        ];

        $payload = app('request')->only('charge_cd', 'description');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        //create item
        $this->model->create($request->all());

        return ['message' => 'Charge created.'];

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function update(Request $request, $id)
    {

        $item = $this->model->findOrFail($id);

        $rules = [
            'charge_cd' => 'required',
            'description' => 'required'
        ];

        $payload = app('request')->only('charge_cd', 'description');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }
        // update data fields
        $this->model->updatedata($id, $request->all());

        return $this->response->item($item->fresh(), new ChargeTransformer());

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
