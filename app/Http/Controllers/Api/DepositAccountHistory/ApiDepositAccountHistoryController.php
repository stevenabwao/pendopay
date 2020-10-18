<?php

namespace App\Http\Controllers\Api\DepositAccountHistory;

use App\Entities\Company;
use App\Http\Controllers\BaseController;
use App\Transformers\DepositAccountHistory\DepositAccountHistoryTransformer;
use App\Services\DepositAccountHistory\DepositAccountHistoryIndex;
use App\Services\DepositAccountHistory\DepositAccountHistoryCheckBalance;
use App\Services\DepositAccountHistory\DepositAccountHistoryStore;
use App\Transformers\Users\UserTransformer;
use App\User;
use App\Entities\DepositAccountHistory;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; 
use Illuminate\Support\Facades\Input;
use Session;

use Illuminate\Support\Facades\DB;

class ApiDepositAccountHistoryController extends BaseController
{

    /**
     * @var DepositAccountHistory
     */
    protected $model;

    /**
     * Controller constructor.
     *
     * @param DepositAccountHistory $model
     */
    public function __construct(DepositAccountHistory $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DepositAccountHistoryIndex $depositAccountHistoryIndex)
    {

        // DB::enableQueryLog();

        $rules = [
            'company_id' => 'required'
        ];

        $payload = app('request')->only('company_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            //throw new StoreResourceFailedException($validator->errors());
            $message = "Please enter company id";
            return show_error($message);
        }

        /* if (!$request->id && !$request->phone && !$request->account_no) {
            $message = "Please enter required fields";
            return show_error($message);
        } */
        
        //get the data
        $data = $depositAccountHistoryIndex->getData($request);

        // dd(DB::getQueryLog());

        // dd($data);

        /* if ($data) {

            return $this->response->item($data, new DepositAccountHistoryTransformer());

        } else {

            $message = "No account data exists. Please try again.";
            return show_error($message);

        } */

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new DepositAccountHistoryTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new DepositAccountHistoryTransformer());

        }

        return $data;

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, DepositAccountHistoryStore $depositAccountHistoryStore)
    {

        $rules = [
            'payment_method_id' => 'required',
            'amount' => 'required',
            'account_no' => 'required',
            'full_name' => 'required'
        ];

        $payload = app('request')->only('payment_method_id', 'amount', 'account_no', 'full_name');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            //throw new StoreResourceFailedException($validator->errors());
            $message = "Please enter all required fields";
            return show_error($message);
        }

        //create item
        $depositAccountHistory = $depositAccountHistoryStore->createItem($request->all());

        $message = "deposit account History created";
        return $this->success($message);

    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    { 

        $depositAccountHistory = $this->model->findOrFail($id);

        return $this->response->item($depositAccountHistory, new DepositAccountHistoryTransformer());

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $depositAccountHistory = $this->model->findOrFail($id);
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'tsc_no' => 'required'
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'name' => 'sometimes|required',
                'phone' => 'sometimes|required',
                'tsc_no' => 'sometimes|required'
            ];
        }

        $payload = app('request')->only('name', 'phone', 'tsc_no');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            $error_messages = formatValidationErrors($validator->errors());
            //throw new StoreResourceFailedException($error_messages);
            $message = "Please enter all required fields";
            return show_error($message);
        }

        $depositAccountHistory->update($request->except('created_at'));

        return $this->response->item($depositAccountHistory->fresh(), new DepositAccountHistoryTransformer());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
