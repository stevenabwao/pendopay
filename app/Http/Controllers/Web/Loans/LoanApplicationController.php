<?php

namespace App\Http\Controllers\Web\Loans;

use App\Entities\Company;
use App\Entities\DepositAccount;
use App\Entities\Group;
use App\Entities\LoanApplication;
use App\Entities\Product;
use App\Entities\CompanyProduct;
use App\Entities\Term;
use App\Entities\Status;
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
use Illuminate\Support\Facades\DB;
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

        if (isUserHasPermissions("1", ['read-loan_application'])) {

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

            $statuses = Status::where("section", "LIKE", "%loanapplication%")->get();


            return view('loans.loan-applications.index', [
                'loanapplications' => $data->appends(Input::except('page')),
                'statuses' => $statuses
            ]);

        } else {
            abort(503);
        }

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        if (isUserHasPermissions("1", ['create-loan_application'])) {

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

        } else {
            abort(503);
        }

    }


    /**
     * Show the form for creating a new resource - step 2.
     */
    public function create_step2(Request $request)
    {

        //get logged in user
        $user = auth()->user();

        if (isUserHasPermissions("1", ['create-loan_application'])) {

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

            //get deposit accounts matching account search params
            /* $account_search = "";
            if ($request->has('account_search')) {
                $account_search = $request->account_search;
            } */

            //$source_account_search = $request->source_account_search;
            $section = $request->section;
            $section_criteria = $request->section_criteria;
            $search_text = $request->search_text;

            //dd($companyproducts);

            //continue if company has loan products
            if ($companyproducts) {
            
                $terms = Term::where('status_id', '1')->get();
                
                $deposit_accounts = [];

                //DB::enableQueryLog();

                $deposit_accounts = new DepositAccount();
                $deposit_accounts = $deposit_accounts->select('deposit_accounts.*');
                $deposit_accounts = $deposit_accounts->join('company_user', 'deposit_accounts.company_user_id', '=', 'company_user.id');
                $deposit_accounts = $deposit_accounts->join('users', 'company_user.user_id', '=', 'users.id');

                /* if ($account_search) {
                    $deposit_accounts = $deposit_accounts->join('accounts', 'deposit_accounts.ref_account_no', '=', 'accounts.account_no');
                    $account_search_values = getSplitTerms($account_search); 
                    $deposit_accounts = $deposit_accounts->where('accounts.phone', "LIKE", '%' . $account_search . '%')                         
                                        ->orWhere(function ($q) use ($account_search_values, $account_search) {
                                            $q->orWhere('deposit_accounts.account_no', "LIKE", '%' . $account_search . '%');
                                            $q->orWhere('deposit_accounts.ref_account_no', "LIKE", '%' . $account_search . '%');
                                            foreach ($account_search_values as $value) {
                                                $q->orWhere('deposit_accounts.account_name', 'like', "%{$value}%");
                                            }
                                        });
                } */

                if ($search_text) {
                
                    //get section
                    if ($section == "first_name") {
                        $field = 'users.first_name';
                    }
                    if ($section == "last_name") {
                        $field = 'users.last_name';
                    }
                    if ($section == "phone") {
                        $field = 'users.phone';
                    }
        
                    //get criteria
                    if ($section_criteria == "starts_with") {
                        $deposit_accounts = $deposit_accounts->where($field, "LIKE", $search_text . '%');
                    }
                    if ($section_criteria == "contains") {
                        $deposit_accounts = $deposit_accounts->where($field, "LIKE", '%' . $search_text . '%');
                    }
                    if ($section_criteria == "exact") {
                        $deposit_accounts = $deposit_accounts->where($field, "=", $search_text);
                    }
                    
                }

                //ignore admins and company users
                $deposit_accounts = $deposit_accounts->where('users.super_admin', "!=", "1");
                $deposit_accounts = $deposit_accounts->where('company_user.is_company_user', "!=", "1");

                //fetch registered users only
                $deposit_accounts = $deposit_accounts->where('company_user.registration_paid', "1");

                if ($user->hasRole('superadministrator')) {
                    //get company deposit accounts
                    $deposit_accounts = $deposit_accounts->where('deposit_accounts.company_id', $company_id);
                } else {
                    //fetch current user company accounts
                    $deposit_accounts = $deposit_accounts->where('deposit_accounts.company_id', $user->company->id);
                }

                $deposit_accounts = $deposit_accounts->get();

                //dd(DB::getQueryLog(), $deposit_accounts);
                
                return view('loans.loan-applications.create2', [
                        'company' => $company,
                        'terms' => $terms,
                        'companyproducts' => $companyproducts,
                        'deposit_accounts' => $deposit_accounts
                    ]);

            } else {
                abort(404);
            }

        } else {
            abort(503);
        }

    }


    /**
     * Show the form for approving a new loan application
     */
    public function create_approve($id)
    {

        if (isUserHasPermissions("1", ['approve-loan_application'])) {

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

        } else {
            abort(503);
        }

    }


    /**
     * Store a newly created resource in storage. 
     */
    public function store(Request $request, LoanApplicationStore $loanApplicationStore)
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

        if (isUserHasPermissions("1", ['update-loan_application'])) {

            $loanapplication = $this->model->where('id', $id)->first();

            $user = auth()->user();
            //if user is superadmin, show all companies, else show a user's companies
            if ($user->hasRole('superadministrator')){
                $companies = Company::all();
            } else {
                $companies = $user->company;
            }

            return view('loans.loan-applications.edit', compact('loanapplication', 'companies'));

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
        
        if (isUserHasPermissions("1", ['update-loan_application'])) {

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
    public function update_approve(Request $request, $id)
    {
        

        if (isUserHasPermissions("1", ['approve-loan_application'])) {

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

        } else {
            abort(503);
        }

    }


    /**
     * Display the specified resource.
     */
    public function show($id, LoanApplicationShow $loanApplicationShow)
    {

        if (isUserHasPermissions("1", ['read-loan_application'])) {

            //get the data
            if (!$this->check_edit_permissions($id)){
                abort(503);
            }

            $loanapplication = $loanApplicationShow->showItem($id);
            //dd($loanapplication);

            return view('loans.loan-applications.show', compact('loanapplication'));

        } else {
            abort(503);
        }

    }


    /**
     * approve loan.
     */
    public function loan_approve($id, Request $request, LoanApplicationApprove $loanApplicationApprove)
    {

        if (isUserHasPermissions("1", ['approve-loan_application'])) {

            $rules = [
                'approved_loan_amt' => 'required',
                'approved_term_id' => 'required',
                'approved_term_value' => 'required',
                'company_product_id' => 'required'
            ];
            //dd($request, $id);

            $payload = app('request')->only('approved_loan_amt', 'approved_term_id', 'approved_term_value', 'company_product_id');

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

            try {
                
                $loan_application_approve = $loanApplicationApprove->approveItem($id, $request->all());
                $result = json_decode($loan_application_approve);
                $res_message = $result->message;
                $action = $res_message->action;
                $message = $res_message->message;
                //dd($result);
                $action_message = "success";
                //dd($message, $action);

                Session::flash($action_message, $message);
                
                //show updated record
                return redirect()->route('loan-applications.index');

            } catch (\Exception $e) {

                //dd($e);
                $message = $e->getMessage();
                Session::flash("error", $message);
                return redirect()->route('loan-applications.index');

            }

        } else {
            abort(503);
        }

    }


    /**
     * Repost waiting loan approval repost
     */
    public function loan_approve_repost($id, Request $request, 
                                        LoanApplicationApproveRepost $loanApplicationApproveRepost)
    {

        if (isUserHasPermissions("1", ['create-loan_application'])) {

            $loan_application_approve_repost = $loanApplicationApproveRepost->approveItem($id);
            //$result = json_decode($loan_application_approve_repost);
            //dd($loan_application_approve_repost);

            Session::flash('success', 'Successfully approved loan application - ' . $id);
            
            //show updated record
            return redirect()->route('loan-applications.show', $id);

        } else {

            abort(503);

        }

    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        if (isUserHasPermissions("1", ['delete-loan_application'])) {

            $user_id = auth()->user()->id;

            $item = $this->model->findOrFail($id);
            
            if ($item) {
                //update deleted by field
                $item->update(['deleted_by' => $user_id]);
                $result = $item->delete();
            }

            return redirect()->route('loan-applications.index');

        } else {
            abort(503);
        }

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
