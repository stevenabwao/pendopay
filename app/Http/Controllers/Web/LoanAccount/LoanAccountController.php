<?php

namespace App\Http\Controllers\Web\LoanAccount;

use App\Entities\Company;
use App\Entities\LoanAccount;
use App\Entities\CompanyProduct;
use App\Entities\DepositAccount;
use App\Entities\Term;
use App\Entities\Status;
use App\Entities\LoanRepayment;
use App\Entities\LoanProductSetting;
use App\Http\Controllers\Controller;
use App\Services\LoanAccount\LoanAccountIndex;
use App\Services\LoanAccount\LoanAccountStore;
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Session;

class LoanAccountController extends Controller
{
    
    /**
     * @var state
     */
    protected $model;

    /**
     *
     * @param LoanAccount $model
     */
    public function __construct(LoanAccount $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, LoanAccountIndex $loanAccountIndex)
    {
        
        //get the data
        $data = $loanAccountIndex->getData($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }

        // get company products
        $company_products = "";

        if (userIsSuperAdmin()) {
            $company_products = CompanyProduct::all();
        } else {
            $company_ids = getUserCompanyIds($request);
            // get company loan products
            $company_products = CompanyProduct::whereIn('company_id', $company_ids)->get();
        }

        $statuses = Status::where("section", "LIKE", "%loanaccts%")->get();

        //get the data
        $companies = getAllUserCompanies($request);

        return view('accounts.user-accounts.loan-accounts.index', [
            'loanaccounts' => $data->appends(Input::except('page')),
            'statuses' => $statuses,
            'companies' => $companies,
            'companyproducts' => $company_products
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

        return view('accounts.user-accounts.loan-accounts.create', [
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

            //get deposit accounts matching account search params
            $account_search = "";
            if ($request->has('account_search')) {
                $account_search = $request->account_search;
            }

            //DB::enableQueryLog();

            if ($user->hasRole('superadministrator')) {
                //get company deposit accounts
                $deposit_accounts = DepositAccount::where('company_id', $company_id);
            } else {
                //fetch current user company accounts
                $deposit_accounts = DepositAccount::where('company_id', $user->company->id);
            }
            $deposit_accounts = $deposit_accounts
                                    ->when($account_search, function ($q, $account_search) {
                                        return $q->where('account_name', 'LIKE', "%$account_search%");
                                    })
                                    ->get();
            //dd(DB::getQueryLog());

            return view('accounts.user-accounts.loan-accounts.create2', [
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
     * Show the form for creating a new resource - step 3.
     */
    public function create_step3(Request $request)
    {

        //dd($request);
        //get more data
        $rules = [
            'company_id' => 'required',
            'deposit_account_id' => 'required',
            'company_product_id' => 'required',
        ];
        $payload = app('request')->only('company_id', 'deposit_account_id', 'company_product_id');
        $validator = app('validator')->make($payload, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //get logged in user
        $user = auth()->user();

        //deposit account data
        $deposit_account = DepositAccount::find($request->deposit_account_id);

        //company data
        $company = Company::find($request->company_id);

        //company product data
        $loan_product_setting = LoanProductSetting::where('company_product_id', $request->company_product_id)->first();
        //dd($loan_product_setting);

        //company product data
        $company_product = CompanyProduct::find($request->company_product_id);
        
        //continue if company has loan products        
        $terms = Term::where('status_id', '1')->get();

        return view('accounts.user-accounts.loan-accounts.create3', [
                'company' => $company,
                'terms' => $terms,
                'loan_product_setting' => $loan_product_setting,
                'company_product' => $company_product,
                'deposit_account' => $deposit_account
            ]);

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

        //get deposit accounts matching account search params
        if ($request->has('account_search')) {
            $account_search = $request->account_search;
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
    public function store(Request $request, LoanAccountStore $loanAccountStore)
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
        $loanaccount = $loanAccountStore->createItem($request->all());

        $result_json = json_decode($loanaccount);
        
        $error = $result_json->error;
        $message = $result_json->message;
        //dd($message);

        if ($error){
            $response = $message->message;
            Session::flash('error', $response);
        } else {
            $response = $message->message;
            Session::flash('success', $response);
        }   
        //dd($response);
        
        return redirect()->route('loan-accounts.index');

    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        //get logged in user
        $user = auth()->user();

        $loanaccount = "";

        //if user is superadmin, show all companies, else show a user's companies
        if ($user->hasRole('superadministrator')) {

            //get details for this item
            $loanaccount = $this->model->find($id);

        } else if ($user->hasRole('administrator')) {
            
            //get details for this item
            $company_ids_array = getUserCompanyIds();
            $loanaccount = $this->model->where('id', $id)
                            ->whereIn('company_id', $company_ids_array)
                            ->first();
            
        }

        if ($loanaccount) {

            $loanrepayments = LoanRepayment::where('loan_account_id', $loanaccount->id)
                                ->get();
            
            return view('accounts.user-accounts.loan-accounts.show', compact('loanaccount', 'loanrepayments'));

        } else {

            abort(404);
            
        }

    }
    

}
