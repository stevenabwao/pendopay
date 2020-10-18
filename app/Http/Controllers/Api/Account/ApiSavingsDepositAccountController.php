<?php

namespace App\Http\Controllers\Api\Account;

use App\Entities\Company;
use App\Entities\DepositAccount;
use App\Entities\Group;
use App\Entities\Status;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Services\DepositAccount\DepositAccountIndex;
use App\Transformers\DepositAccount\DepositAccountTransformer;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Session;

use Illuminate\Support\Facades\DB;

class ApiSavingsDepositAccountController  extends BaseController
{
    
    /**
     * @var state
     */
    protected $model;

    /**
     * SavingsDepositAccountController constructor.
     *
     * @param DepositAccount $model
     */
    public function __construct(DepositAccount $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DepositAccountIndex $depositAccountIndex)
    {

        DB::enableQueryLog(); 

        /*start cache settings*/
        /* $url = request()->url();
        $params = request()->query();
        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration('low'); */ 
        /*end cache settings*/

        //product id
        $savings_product_id = config('constants.account_settings.savings_account_product_id');

        $request->merge([
            'product_id' => $savings_product_id
        ]);

        //get the data
        $data = $depositAccountIndex->getAccounts($request);
        // dd($data);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new DepositAccountTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new DepositAccountTransformer());

        }

        dd(DB::getQueryLog());

        return $data;

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 

        $rules = [
            'user_id' => 'required',
            'loan_amt' => 'required',
            'company_id' => 'required',
            'prime_limit_amt' => 'required'
        ];

        $payload = app('request')->only('loan_amt', 'prime_limit_amt', 'company_id', 'user_id');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        //create item
        $this->model->create($request->all());

        return ['message' => 'Savings Deposit Account created.'];

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $user = auth()->user();

        //if user is superadmin, proceed, else, abort
        if ($user->hasRole('superadministrator')){

            $account = $this->model->find($id);

            $rules = [
                'user_id' => 'required',
                'loan_amt' => 'required',
                'company_id' => 'required',
                'prime_limit_amt' => 'required'
            ];

            $payload = app('request')->only('loan_amt', 'prime_limit_amt', 'company_id', 'user_id');
            $validator = app('validator')->make($payload, $rules);

            if ($validator->fails()) {
                throw new StoreResourceFailedException($validator->errors());
            }

            // update fields
            $this->model->updatedata($id, $request->all());

            return $this->response->item($item->fresh(), new DepositAccountTransformer());

        } else {

            abort(404);

        }

    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
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
