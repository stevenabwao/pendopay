<?php

namespace App\Http\Controllers\Web\Loans;

use App\Entities\Company;
use App\Entities\LoanExposureLimit;
use App\Entities\LoanExposureLimitsDetail;
use App\Http\Controllers\Controller;
use App\Services\LoanExposureLimit\LoanExposureLimitIndex;
use App\Services\LoanExposureLimit\LoanExposureLimitStore;
use App\Events\LoanExposureLimitUpdated;
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Session;

class LoanExposureLimitController extends Controller
{
    
    /**
     * @var state
     */
    protected $model;

    /**
     * LoanExposureLimitController constructor.
     *
     * @param LoanExposureLimit $model
     */
    public function __construct(LoanExposureLimit $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, LoanExposureLimitIndex $loanExposureLimitIndex)
    {

        if (isUserHasPermissions("1", ['read-loan-exposure-limit'])) {

            //get the data
            $data = $loanExposureLimitIndex->getLoanExposureLimits($request);

            //are we in report mode? return get results
            if ($request->report) {

                $data = $data->get();

            }
            //dd($data);

            return view('loans.loan-exposure-limits.index', [
                'loanexposurelimits' => $data->appends(Input::except('page'))
                //'statuses' => $statuses
            ]);

        } else {
            abort(503);
        }

    }


    /**
     * Store a newly created resource in storage. 
     */
    public function store(Request $request, LoanExposureLimitStore $loanExposureLimitStore)
    { 

        if (isUserHasPermissions("1", ['create-loan_application'])) {

            //dd($request->all());
            $rules = [
                'loan_amt' => 'required',
                'company_id' => 'required',
                'company_product_id' => 'required',
                'deposit_account_id' => 'required',
            ];

            $payload = app('request')->only('loan_amt', 'company_id', 'company_product_id', 'deposit_account_id');

            $validator = app('validator')->make($payload, $rules);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            //create item
            $loanapplication = $loanExposureLimitStore->createItem($request->all());

            $result_json = json_decode($loanapplication);
            
            $error = $result_json->error;
            $message = $result_json->message;
            //dd($message);

            if ($error){
                $response = $message->message;
                Session::flash('error', $response);
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
                Session::flash('success', $response);
            }   
            //dd($response);
            
            return redirect()->route('.loan-exposure-limits.index');

        } else {
            abort(503);
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if (isUserHasPermissions("1", ['update-loan-exposure-limit'])) {

            $loanexposurelimit = $this->model->where('id', $id)->first();

            $usersharesBalance = getUserSharesPayments($loanexposurelimit->company_user_id);

            return view('loans..loan-exposure-limits.edit', compact('loanexposurelimit', 'usersharesBalance'));

        } else {
            
            abort(503);

        }

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
        
        if (isUserHasPermissions("1", ['update-loan-exposure-limit'])) {

            //get logged in user
            $logged_user = auth()->user();

            $rules = [
                'max_limit' => 'sometimes|nullable|numeric',
                'limit' => 'sometimes|nullable|numeric'
            ];

            $payload = app('request')->only('max_limit', 'limit');

            $validator = app('validator')->make($payload, $rules);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            //check if exposure limit has changed,
            // if it changed, make sure it is not more than or equal to current limit
            //it must be less than current limit
            //get current limit
            if ($request->has('limit')){

                $new_loan_exp_limit = $request->limit;

                $loanexposurelimit = $this->model->where('id', $id)->first();
                $current_loan_exp_limit = $loanexposurelimit->limit;
                $company_id = $loanexposurelimit->company_id;
                $user_id = $loanexposurelimit->user_id;
                $company_user_id = $loanexposurelimit->company_user_id;
                $company_product_id = $loanexposurelimit->company_product_id;
                $comments = $request->comments;
                $loan_exposure_limit_id = $loanexposurelimit->id;

                $calculation_limit = $new_loan_exp_limit - $current_loan_exp_limit;
                $new_user_loan_exposure_limit = $new_loan_exp_limit;
                //dd($calculation_limit);

                if ($new_loan_exp_limit > $current_loan_exp_limit) {
                    //show error message
                    return redirect()->back()->withInput();
                    Session::flash('error', 'Failed. New exposure limit must be less than the current limit');
                }

                //store limit details
                 //start create new loan user exposure limit details
                 try {

                    $loan_exposure_limit_detail_entry = new LoanExposureLimitsDetail();

                    $loan_exposure_limit_detail_attributes['limit'] = $calculation_limit;
                    $loan_exposure_limit_detail_attributes['current_limit'] = $new_user_loan_exposure_limit;
                    $loan_exposure_limit_detail_attributes['company_id'] = $company_id;
                    $loan_exposure_limit_detail_attributes['user_id'] = $user_id;
                    $loan_exposure_limit_detail_attributes['comments'] = $comments;
                    $loan_exposure_limit_detail_attributes['company_user_id'] = $company_user_id;
                    $loan_exposure_limit_detail_attributes['company_product_id'] = $company_product_id;
                    $loan_exposure_limit_detail_attributes['loan_exposure_limit_id'] = $loan_exposure_limit_id;
                    $loan_exposure_limit_detail_attributes['created_by'] = $logged_user->id;
                    $loan_exposure_limit_detail_attributes['updated_by'] = $logged_user->id;

                    $loan_exposure_limit_detail_entry::create($loan_exposure_limit_detail_attributes);

                } catch(\Exception $e) {

                    DB::rollback();
                    $message_text = "Error creating new user exposure limit detail entry - " . $e->getMessage();
                    //dd($message);
                    log_this($message_text);
                    $show_message = "Error processing loan repayment. Please try again later.";
                    $show_message .= $message_text;
                    Session::flash('error', $show_message);

                }
                //end create new loan user exposure limit details

            }

            // update fields
            $this->model->updatedata($id, $request->all());



            //send update event
            $item = $this->model->findOrFail($id);
            event(new LoanExposureLimitUpdated($item));

            Session::flash('success', 'Successfully updated loan exposure limit - ' . $id);
            //show updated record
            return redirect()->route('loan-exposure-limits.show', $id);

        } else {
            abort(503);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        if (isUserHasPermissions("1", ['read-loan-exposure-limit'])) {

            //get the data
            $loanexposurelimit = $this->model->findOrFail($id);
            //dd($loanexposurelimit);

            $usersharesBalance = getUserSharesPayments($loanexposurelimit->company_user_id);


            return view('loans.loan-exposure-limits.show', compact('loanexposurelimit', 'usersharesBalance'));

        } else {
            abort(503);
        }

    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        if (isUserHasPermissions("1", ['delete-loan-exposure-limit'])) {

            $user_id = auth()->user()->id;

            $item = $this->model->findOrFail($id);
            
            if ($item) {
                //update deleted by field
                $item->update(['deleted_by' => $user_id]);
                $result = $item->delete();
            }

            return redirect()->route('.loan-exposure-limits.index');

        } else {
            abort(503);
        }

    }


}
