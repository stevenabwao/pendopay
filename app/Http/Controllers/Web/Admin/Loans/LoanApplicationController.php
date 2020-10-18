<?php

namespace App\Http\Controllers\Web\Loans;

use App\Entities\Company;
use App\Entities\DepositAccount;
use App\Entities\Group;
use App\Entities\LoanApplication;
use App\Entities\Product;
use App\Entities\CompanyProduct;
use App\Entities\Term;
use App\Http\Controllers\Controller;
use App\Services\LoanApplication\LoanApplicationIndex;
use App\Services\LoanApplication\LoanApplicationStore;
use App\Services\LoanApplication\LoanApplicationShow;
use App\Services\LoanApplication\LoanApplicationApprove;
use App\Services\LoanApplication\LoanApplicationApproveRepost;
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Session;

class LoanApplicationController extends Controller
{
    
    /**
     * @var state
     */
    protected $model;

    /**
     * LoanApplicationController constructor.
     *
     * @param LoanApplication $model
     */
    public function __construct(LoanApplication $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, LoanApplicationIndex $loanApplicationIndex)
    {

        /*start cache settings*/
        $url = request()->url();
        $params = request()->query();
        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration('low'); 
        /*end cache settings*/

        //get the data
        $data = $loanApplicationIndex->getLoanApplications($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }
        //dd($data);

        return view('loans.loan-applications.index', [
            'loanapplications' => $data->appends(Input::except('page'))
        ]);

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

        if ($user->hasRole('superadministrator')) {
            $companies = Company::all();
        } else if ($user->hasRole('administrator')) {
            if ($user->company) {
                $companies[] = $user->company;
            }
        } else {
            //get user companies i.e. where user has deposit accounts
            $company_ids = DepositAccount::where('primary_user_id', $user->id)->pluck('company_id');
            //dd($company_ids);
            $companies = Company::whereIn('id', $company_ids)->get();
            //dd($companies);
        }

        return view('loans.loan-applications.create', [
                'companies' => $companies
            ]);

    }


    /**
     * Show the form for creating a new resource - step 2.
     */
    public function create_step2(Request $request)
    {

        //dd($request);
        //get more data
        $rules = [
            'company_id' => 'required',
        ];
        $payload = app('request')->only('company_id');
        $validator = app('validator')->make($payload, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //get logged in user
        $user = auth()->user();

        //if user is superadmin, show all companies, else show a user's companies
        $company_id = $request->company_id;
        $company = Company::find($company_id);
        if ($user->hasRole('superadministrator')) {
            $companyproducts = CompanyProduct::where('status_id', '1')
                    ->where('company_id', $company_id)
                    ->get();
        } else if ($user->hasRole('administrator')) {
            $companyproducts = CompanyProduct::where('company_id', $user->company->id)
                    ->where('status_id', '1')
                    ->get();
        } else {
            abort(503);
        }

        //dd($companyproducts);

        //continue if company has loan products
        if ($companyproducts) {
        
            $terms = Term::where('status_id', '1')->get();
            
            $deposit_accounts = [];

            //if (($user->hasRole('superadministrator')) || ($user->hasRole('administrator'))) {
            if ($user->hasRole('superadministrator')) {
                //get company deposit accounts
                $deposit_accounts = DepositAccount::where('company_id', $company_id)
                                    ->get();
            } else {
                //fetch current user company accounts
                $deposit_accounts = DepositAccount::where('company_id', $user->company->id)
                                    ->where('primary_user_id', $user->id)
                                    ->get();
            }

            return view('loans.loan-applications.create2', [
                    'company' => $company,
                    'terms' => $terms,
                    'companyproducts' => $companyproducts,
                    'deposit_accounts' => $deposit_accounts
                ]);

        } else {
            abort(404);
        }

    }


    /**
     * Show the form for approving a new loan application
     */
    public function create_approve($id)
    {

        //get logged in user
        $user = auth()->user();
        $loanapplication = "";

        if ($user->hasRole('superadministrator')) {
            //if user is superadmin, show 
            $loanapplication = $this->model->find($id);
        } else if ($user->hasRole('administrator')){
            //if user is not superadmin, show only from user company
            $loanapplication = $this->model->where('company_id', $user->company->id)
                                ->where('id', $id)
                                ->first();
        }

        if ($loanapplication) {
            $products = Product::where('product_cat_ty', 'LN')
                        ->where('status_id', '1')
                        ->get();
            $terms = Term::where('status_id', '1')->get();

            return view('loans.loan-applications.approve', [
                    'loanapplication' => $loanapplication,
                    'terms' => $terms,
                    'products' => $products
                ]);
        } else {
            abort(404);
        }

    }


    /**
     * Store a newly created resource in storage. 
     */
    public function store(Request $request, LoanApplicationStore $loanApplicationStore)
    { 

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
        $loanapplication = $loanApplicationStore->createItem($request->all());

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
        
        return redirect()->route('loan-applications.index');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $loanapplication = $this->model->where('id', $id)->first();

        $user = auth()->user();
        //if user is superadmin, show all companies, else show a user's companies
        if ($user->hasRole('superadministrator')){
            $companies = Company::all();
        } else {
            $companies = $user->company;
        }

        return view('loans.loan-applications.edit', compact('loanapplication', 'companies'));

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
        
        $rules = [
            'user_id' => 'required',
            'loan_amt' => 'required',
            'company_id' => 'required',
            'prime_limit_amt' => 'required'
        ];

        $payload = app('request')->only('user_id', 'loan_amt', 'company_id', 'prime_limit_amt');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        // update fields
        $this->model->updatedata($id, $request->all());

        Session::flash('success', 'Successfully updated loan application - ' . $id);
        //show updated record
        return redirect()->route('loan-applications.show', $id);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_approve(Request $request, $id)
    {

        $rules = [
            'approved_loan_amt' => 'required',
            'approved_term_id' => 'required',
            'approved_term_value' => 'required'
        ];

        $payload = app('request')->only('approved_loan_amt', 'approved_term_id', 'approved_term_value');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        // update fields
        $this->model->updatedata($id, $request->all());
        //flash a session message
        Session::flash('success', 'Successfully updated loan application - ' . $id);
        //show updated record
        return redirect()->route('loan-applications.show', $id);

    }


    /**
     * Display the specified resource.
     */
    public function show($id, LoanApplicationShow $loanApplicationShow)
    {

        //get the data
        if (!$this->check_edit_permissions($id)){
            abort(503);
        }

        $loanapplication = $loanApplicationShow->showItem($id);
        //dd($loanapplication);

        return view('loans.loan-applications.show', compact('loanapplication'));

    }


    /**
     * approve loan.
     */
    public function loan_approve($id, Request $request, LoanApplicationApprove $loanApplicationApprove)
    {

        $rules = [
            'loan_application_id' => 'required',
            'approved_loan_amt' => 'required',
            'approved_term_id' => 'required',
            'approved_term_value' => 'required'
        ];

        $payload = app('request')->only('loan_application_id', 'approved_loan_amt', 'approved_term_id', 'approved_term_value');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //merge with admin approval flag
        $request->merge([
            'admin_approval' => '1'
        ]);

        if (!$this->check_edit_permissions($id)){
            abort(503);
        }

        $loan_application_approve = $loanApplicationApprove->approveItem($id, $request->all());

        Session::flash('success', 'Successfully approved loan application - ' . $id);
        
        //show updated record
        return redirect()->route('loan-applications.show', $id);

    }


    /**
     * Repost waiting loan approval repost
     */
    public function loan_approve_repost($id, Request $request, LoanApplicationApproveRepost $loanApplicationApproveRepost)
    {

        /*
        $rules = [
            'loan_application_id' => 'required'
        ];

        $payload = app('request')->only('loan_application_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        */

        if (!$this->check_edit_permissions($id)){
            abort(503);
        }

        $loan_application_approve_repost = $loanApplicationApproveRepost->approveItem($id);
        //$result = json_decode($loan_application_approve_repost);
        //dd($loan_application_approve_repost);

        Session::flash('success', 'Successfully approved loan application - ' . $id);

        /*if (!$result->error){
            Session::flash('success', 'Successfully approved loan application - ' . $id);
        } else {
            Session::flash('error', $result->message);
        }
        */
        
        //show updated record
        return redirect()->route('loan-applications.show', $id);

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

        return redirect()->route('loan-applications.index');
    }

    public function check_edit_permissions($id)
    {

        $user = auth()->user();

        if ($user->hasRole('superadministrator')) {
            //if user is superadmin, ok 
            return true;
        } else if ($user->hasRole('administrator')){
            //if user is not superadmin, show only from user company
            $loanapplication = $this->model->where('company_id', $user->company->id)
                                ->where('id', $id)
                                ->first();
            if (!$loanapplication){
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

}
