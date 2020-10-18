<?php

namespace App\Http\Controllers\Api\ChargeProduct;

use App\Entities\ChargeProduct;
use App\Entities\Company;
use App\Entities\Group;
use App\Http\Controllers\BaseController;
use App\Services\ChargeProduct\ChargeProductIndex;
use App\Transformers\ChargeProduct\ChargeProductTransformer;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;

class ApiChargeProductController extends BaseController
{
    
    /**
     * @var ChargeProduct
     */
    protected $model;

    /**
     * ChargeProductController constructor.
     *
     * @param ChargeProduct $model
     */
    public function __construct(ChargeProduct $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ChargeProductIndex $chargeProductIndex)
    {

        /*start cache settings*/
        $url = request()->url();
        $params = request()->query();
        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration('low'); 
        /*end cache settings*/

        //get the data
        $data = $chargeProductIndex->getCharges($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new ChargeProductTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new ChargeProductTransformer());

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

        return $this->response->item($item, new ChargeProductTransformer());
    }


    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request)
    {

        $rules = [
            'product_id' => 'required',
            'charge_id' => 'required'
        ];

        $payload = app('request')->only('charge_id', 'product_id');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        //create item
        $this->model->create($request->all());

        return ['message' => 'ChargeProduct created.'];

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function update(Request $request, $id)
    {

        $rules = [
            'product_id' => 'required',
            'charge_id' => 'required'
        ];

        $payload = app('request')->only('charge_id', 'product_id');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }
        
        // update data fields
        $this->model->updatedata($id, $request->all());

        return $this->response->item($item->fresh(), new ChargeProductTransformer());

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
