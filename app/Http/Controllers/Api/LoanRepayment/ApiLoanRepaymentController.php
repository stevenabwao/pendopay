<?php

namespace App\Http\Controllers\Api\LoanRepayment;

use App\Entities\Account;
use App\Entities\Company;
use App\Entities\LoanRepayment;
use App\Entities\Status;
use App\Http\Controllers\Controller;
use App\Services\LoanRepayment\LoanRepaymentIndex;
use App\Services\LoanRepayment\LoanRepaymentStore;
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Session;

class ApiLoanRepaymentController extends Controller
{
    
    /**
     */
    protected $model;

    /**
     * ApiLoanRepaymentController constructor.
     *
     * @param LoanRepayment $model
     */
    public function __construct(LoanRepayment $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, LoanRepaymentIndex $loanRepaymentIndex)
    {

        //product id
        $loan_repayment_product_id = config('constants.account_settings.loan_repayment_account_product_id');

        $request->merge([
            'product_id' => $loan_repayment_product_id
        ]);

        //get the data
        $data = $loanRepaymentIndex->getAccounts($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }

        //return cached data or cache if cached data not exists
        //return Cache::remember($fullUrl, $minutes, function () use ($data) {
            return view('accounts.user-accounts.loan-repayments.index', [
                'accounts' => $data->appends(Input::except('page'))
            ]);
        //});

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //get logged in user
        $user = auth()->user();

        //if user is superadmin, show all companies, else show a user's companies
        $companies = [];
        $groups = [];
        $company_ids = [];
        if ($user->hasRole('superadministrator')) {
            $company_ids = Company::all()->pluck('id');
            $companies = Company::all();
        } else if ($user->hasRole('administrator')) {
            if ($user->company) {
                $company_ids[] = $user->company->id;
                $companies[] = $user->company;
            }
        }

        //get first company id
        $company_id = $companies->first()->id;

        /*return view('accounts.user-accounts.loan-repayments.create')
               ->withCompanies($companies)
               ->withGroups($groups);*/

        return view('accounts.user-accounts.loan-repayments.create', compact('companies', 'groups'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, LoanRepaymentStore $loanRepaymentStore)
    { 

        $rules = [
            'phone' => 'required',
            'amount' => 'required',
            'company_id' => 'required'
        ];

        $payload = app('request')->only('phone', 'amount', 'company_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //create item
        $phone = $request->phone;
        try{
            $phone = getDatabasePhoneNumber($phone);
        } catch (\Exception $e) {
            $message = "Please enter correct phone number as the account no!";
            return show_error($message);
        }

        //get companyuserid
        $account_data = getCompanyUserData($request->company_id, $phone);

        $company_user_id = $account_data->id;

        //add to request
        $request->merge(['company_user_id' => $company_user_id]);

        //create item
        $loanrepayment = $loanRepaymentStore->createItem($request->all());

        $result_json = json_decode($loanrepayment);

        //dd($result_json);

        $error = $result_json->error;
        $message = $result_json->message;

        if ($error){
            $response = $message->message;
            //Session::flash('error', $response);
            return show_success($response);
        } else {
            $response = $message->message;
            //generate repayment schedule
            if (!empty($message->repayment_schedule)) {
                $repayment_schedule = $message->repayment_schedule;
                $repay_data = "\n\nRepayment schedule:\n";
                for ($i=0; $i<count($repayment_schedule); $i++){
                    $repay_data .= $repayment_schedule[$i]->date;
                    $repay_data .= "\t\t-\t\t" . $repayment_schedule[$i]->amount . "\n";
                }
                //add message to repayment schedule
                $response .= $repay_data;
            }
            //Session::flash('success', $response);
            return show_success($response);
        }   
        //dd($response);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = auth()->user();

        //if user is superadmin, proceed, else, abort
        if ($user->hasRole('superadministrator')){

            $account = $this->model->find($id);
            $products = Product::where('product_cat_ty', 'DP')->get();            
            $companies = Company::all();
            $statuses = Status::all();

            return view('accounts.user-accounts.loan-repayments.edit', compact('account', 'companies', 'products', 'statuses'));

        } else {

            abort(404);

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
        
        $user = auth()->user();

        //if user is superadmin, proceed, else, abort
        if ($user->hasRole('superadministrator')){

            $account = $this->model->find($id);

            $rules = [
                'account_name' => 'required',
                'company_id' => 'required',
                'product_id' => 'required',
                'account_no' => 'required|unique:accounts,account_no,'.$account->id,
            ];

            $payload = app('request')->only('account_no', 'account_name', 'company_id', 'product_id');

            $validator = app('validator')->make($payload, $rules);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            // update fields
            $this->model->updatedata($id, $request->all());

            Session::flash('success', 'Successfully updated user loan repayment account - ' . $account->account_no);
            //show updated record
            return redirect()->route('user-loan-repayments.show', $account->id);

        } else {

            abort(404);

        }


        

    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        //get details for this item
        $account = $this->model->find($id);
        
        return view('accounts.user-accounts.loan-repayments.show', compact('account'));

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

        return redirect()->route('user-loan-repayment-accounts.index');
    }

}
