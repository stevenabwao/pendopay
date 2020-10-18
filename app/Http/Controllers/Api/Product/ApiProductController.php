<?php

namespace App\Http\Controllers\Api\Product;

use App\Entities\Company;
use App\Entities\Group;
use App\Entities\Product;
use App\Http\Controllers\BaseController;
use App\Services\Product\ProductIndex;
use App\Transformers\Product\ProductTransformer;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Session;

class ApiProductController extends BaseController
{
    
    /**
     * @var product
     */
    protected $model;

    /**
     * ProductController constructor.
     *
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ProductIndex $productIndex)
    {

        /*start cache settings*/
        $url = request()->url();
        $params = request()->query();
        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration('low'); 
        /*end cache settings*/

        //get the data
        $data = $productIndex->getProducts($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new ProductTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new ProductTransformer());

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

        return $this->response->item($item, new ProductTransformer());
    }


    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request)
    {

        $rules = [
            'start_at' => 'required'
        ];

        $payload = app('request')->only('start_at');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        //create item
        $this->model->create($request->all());

        return ['message' => 'Product created.'];

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
            'start_at' => 'required'
        ];

        $payload = app('request')->only('start_at');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }
        // update data fields
        $this->model->updatedata($id, $request->all());

        return $this->response->item($item->fresh(), new ProductTransformer());

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
