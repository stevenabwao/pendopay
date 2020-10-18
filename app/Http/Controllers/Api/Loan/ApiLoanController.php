<?php

namespace App\Http\Controllers\Api\Loan;

use App\Company;
use App\Http\Controllers\BaseController;
use App\Transformers\Loan\LoanTransformer;
use App\Services\Loan\LoanIndex;
use App\Services\Loan\LoanCheckBalance;
use App\Services\Loan\LoanCheckLimit;
use App\Services\Loan\LoanCheckValidity;
use App\Services\Loan\LoanGetRepayments;
use App\Services\Loan\LoanStore;
use App\Services\LoanApplication\LoanApplicationStore;
use App\Transformers\Users\UserTransformer;
use App\User;
use App\Entities\Loan; 
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Session;

class ApiLoanController extends BaseController
{

    /**
     * @var Loan
     */
    protected $model;

    /**
     * Controller constructor.
     *
     * @param Loan $model
     */
    public function __construct(Loan $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, LoanIndex $loanIndex)
    {

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

        if (!$request->id && !$request->phone && !$request->account_no) {
            $message = "Please enter required fields";
            return show_error($message);
        }

        //get the data
        $data = $loanIndex->getData($request);

        //dd($data);

        if ($data) {

            return $this->response->item($data, new LoanTransformer());

        } else {

            $message = "No account data exists. Please try again.";
            return show_error($message);

        }

    }


    /**
     * Display a listing of the resource.
     */
    public function checkBalance(Request $request, LoanCheckBalance $loanCheckBalance)
    {

        $rules = [
            'company_id' => 'required'
        ];

        $payload = app('request')->only('company_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
            /* $message = "Please enter company id";
            return show_error($message); */
        }

        if (!$request->id && !$request->phone && !$request->account_no) {
            $message = "Please enter required fields";
            return show_error($message); 
        }

        //get the data
        $result = $loanCheckBalance->getData($request); 
        $result = json_decode($result);
        //$message = $result_json->message->message;
        //dd($result); 

        return show_success($result->message);

    }

    /**
     * Display the user's loan limit
     */
    public function checkLimit(Request $request, LoanCheckLimit $loanCheckLimit)
    {

        //dd($request);

        if (!$request->id && !$request->phone && !$request->account_no) {
            $message = "Please enter required fields";
            return show_error($message);
        }
        $rules = [
            'company_id' => 'required', 
            'phone' => 'required'
        ];

        $payload = app('request')->only('company_id', 'phone');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            //throw new StoreResourceFailedException($validator->errors());
            return show_error($validator->errors());
        }

        //get the data
        $result = $loanCheckLimit->getData($request->all());
        $result = json_decode($result);
        //dd('hhhh', $result);

        return show_success($result->message);

    }


    /**
     * Check whether user loan application is valid
     */
    public function checkValidity(Request $request, LoanCheckValidity $loanCheckValidity)
    {

        //dd($request);

        if (!$request->id && !$request->phone && !$request->account_no) {
            $message = "Please enter required fields";
            return show_error($message);
        }
        $rules = [
            'company_id' => 'required',
            'phone' => 'required'
        ];

        $payload = app('request')->only('company_id', 'phone');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            //throw new StoreResourceFailedException($validator->errors());
            return show_error($validator->errors());
        }

        //get the data
        $result = $loanCheckValidity->getData($request->all());
        $result = json_decode($result);
        //dd('hhhh', $result);

        return show_success($result->message);

    }


    /**
     * Get loan repayments data
     */
    public function getRepayments(Request $request, LoanGetRepayments $loanGetRepayments)
    {

        //dd($request);

        if (!$request->id && !$request->phone && !$request->account_no) {
            $message = "Please enter required fields";
            return show_error($message);
        }
        $rules = [
            'company_id' => 'required',
            'phone' => 'required',
            'loan_amt' => 'required'
        ];

        $payload = app('request')->only('company_id', 'phone', 'loan_amt');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return show_error($validator->errors());
        }

        //get the data
        $result = $loanGetRepayments->getData($request->all());
        $result = json_decode($result);
        //dd('hhhh', $result);

        return show_success($result->message);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, LoanApplicationStore $loanApplicationStore)
    {

        $rules = [
            'phone' => 'required',
            'loan_amt' => 'required',
            'company_id' => 'required',
        ];

        $payload = app('request')->only('phone', 'loan_amt', 'company_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            //throw new StoreResourceFailedException($validator->errors());
            $message = "Please enter all required fields";
            return show_error($message);
        }

        //get companyuserid
        $account_data = DB::table('users')
            ->join('accounts', 'users.id', '=', 'accounts.user_id')
            ->join('company_user', 'users.id', '=', 'company_user.user_id')
            ->select('company_user.id', 'accounts.account_name')
            ->where('company_user.company_id', $company_id)
            ->where('accounts.company_id', $company_id)
            ->where('accounts.phone', $phone)
            ->first();
        $company_user_id = $account_data->id;
        //add to request
        $request->merge(['company_user_id' => $company_user_id]);

        dd($request->all());

        //create item
        $loanapplication = $loanApplicationStore->createItem($request->all());

        $result_json = json_decode($loanapplication);
        $error = $result_json->error;
        $message = $result_json->message;

        if ($error){
            $response = $message->message;
            return show_error($message);
        } else {
            $response = $message->message;

            //dd($response);
            //check if repayment schedule exists
            if (isset($message->repayment_schedule)) {
                //generate repayment schedule
                $repayment_schedule = $message->repayment_schedule;
                $repay_data = "\n\nRepayment schedule:\n";
                for ($i=0; $i<count($repayment_schedule); $i++){
                    $repay_data .= $repayment_schedule[$i]->date;
                    $repay_data .= "\t\t-\t\t" . $repayment_schedule[$i]->amount . "\n";
                }
                //add message to repayment schedule
                $response .= $repay_data;
            }
            return show_success($message);
        } 

    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {

        $loan = $this->model->findOrFail($id);

        return $this->response->item($loan, new LoanTransformer());

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

        $loan = $this->model->findOrFail($id);
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

        $loan->update($request->except('created_at'));

        return $this->response->item($loan->fresh(), new LoanTransformer());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
