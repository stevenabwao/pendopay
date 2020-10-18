<?php

namespace App\Http\Controllers\Api\Account;

use App\Entities\Account;
use App\Entities\Company;
use App\Entities\Group;
use App\Http\Controllers\BaseController;
use App\Services\Account\AccountIndex;
use App\Transformers\Account\AccountTransformer;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Session;

class ApiAccountController extends BaseController
{

    /**
     * @var account
     */
    protected $model;

    /**
     * AccountController constructor.
     *
     * @param Account $model
     */
    public function __construct(Account $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AccountIndex $accountIndex)
    {

        /*start cache settings*/
        /*$url = request()->url();
        $params = request()->query();
        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration('low'); */
        /*end cache settings*/

        //get the data
        $data = $accountIndex->getAccounts($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new AccountTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new AccountTransformer());

        }

        return $data;

    }


    /**
     * @param $id
     * @return mixed
    */
    public function show($id)
    {
        $item = $this->model->findOrFail($id);

        return $this->response->item($item, new AccountTransformer());
    }

    /**
     * @param $id
     * @return mixed
    */
    public function showByPhone($phone)
    {
        $item = $this->model->where('phone', $phone)->first();

        return $this->response->item($item, new AccountTransformer());
    }


    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request)
    {

        $rules = [
            'account_no' => 'required',
            'product_id' => 'required',
            'company_id' => 'required',
            'user_id' => 'required'
        ];

        $payload = app('request')->only('account_no', 'product_id', 'company_id', 'user_id');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        //create item
        $this->model->create($request->all());

        return ['message' => 'Account created.'];

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

        return $this->response->item($item->fresh(), new AccountTransformer());

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
