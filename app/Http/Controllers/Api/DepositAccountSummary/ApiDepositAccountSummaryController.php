<?php

namespace App\Http\Controllers\Api\DepositAccountSummary;

use App\Company;
use App\Http\Controllers\BaseController;
use App\Transformers\DepositAccountSummary\DepositAccountSummaryTransformer;
use App\Services\DepositAccountSummary\DepositAccountSummaryIndex;
use App\Services\DepositAccountSummary\DepositAccountSummaryCheckBalance;
use App\Services\DepositAccountSummary\DepositAccountSummaryStore;
use App\Transformers\Users\UserTransformer;
use App\User;
use App\Entities\DepositAccountSummary;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException; 
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; 
use Illuminate\Support\Facades\Input;
use Session;

class ApiDepositAccountSummaryController extends BaseController
{

    /**
     * @var DepositAccountSummary
     */
    protected $model;

    /**
     * Controller constructor.
     *
     * @param DepositAccountSummary $model
     */
    public function __construct(DepositAccountSummary $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DepositAccountSummarySingle $depositAccountSummarySingle)
    {

        $rules = [
            'company_id' => 'required'
        ];

        $payload = app('request')->only('company_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            $message = "Please enter company id";
            return show_error($message);
        }

        if (!$request->id && !$request->phone && !$request->account_no) {
            $message = "Please enter required fields";
            return show_error($message);
        }
        
        //get the data
        $data = $depositAccountSummarySingle->getData($request);

        //dd($data);

        if ($data) {

            return $this->response->item($data, new DepositAccountSummaryTransformer());

        } else {

            $message = "No account data exists. Please try again.";
            return show_error($message);

        }

    }


    /**
     * Display a listing of the resource.
     */
    public function checkBalance(Request $request, DepositAccountSummaryCheckBalance $depositAccountSummaryCheckBalance)
    {

        $rules = [
            'phone' => 'required',
            'company_id' => 'required'
        ];

        $payload = app('request')->only('phone', 'company_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            $message = "An error occured - " . $validator->errors();
            return show_error($message);
        }

        //get the data
        $result = $depositAccountSummaryCheckBalance->getData($request->all());
        $result = json_decode($result);
        //dd($result);

        return show_success($result->message);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, DepositAccountSummaryStore $depositAccountSummaryStore)
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
            $message = "An error occured - " . $validator->errors();
            return show_error($message);
        }

        //create item
        $depositAccountSummary = $depositAccountSummaryStore->createItem($request->all());

        $message = "deposit account summary created";
        return $this->success($message);

    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    { 

        $depositAccountSummary = $this->model->findOrFail($id);

        return $this->response->item($depositAccountSummary, new DepositAccountSummaryTransformer());

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $depositAccountSummary = $this->model->findOrFail($id);
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

        $depositAccountSummary->update($request->except('created_at'));

        return $this->response->item($depositAccountSummary->fresh(), new DepositAccountSummaryTransformer());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
