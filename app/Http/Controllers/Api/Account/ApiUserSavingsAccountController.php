<?php

namespace App\Http\Controllers\Api\Account;

use App\Entities\Account;
use App\Entities\Company;
use App\Entities\Group;
use App\Entities\LoanApplication;
use App\Entities\Product;
use App\Entities\Status;
use App\Http\Controllers\Controller;
use App\Services\Account\AccountIndex;
use App\Services\LoanApplication\LoanApplicationIndex;
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Session;

class ApiUserSavingsAccountController extends Controller
{
    
    /**
     * @var state
     */
    protected $model;

    /**
     * LoanApplicationController constructor.
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
        $url = request()->url();
        $params = request()->query();
        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration('low'); 
        /*end cache settings*/

        //product id
        $savings_product_id = config('constants.account_settings.savings_account_product_id');

        $request->merge([
            'product_id' => $savings_product_id
        ]);

        //get the data
        $data = $accountIndex->getAccounts($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }

        //return cached data or cache if cached data not exists
        //return Cache::remember($fullUrl, $minutes, function () use ($data) {
            return view('accounts.user-accounts.savings.index', [
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

        //get group ids if any
        if ($company_id) {
            //get groups
            $groups = Group::where('company_id', $company_id)->get();
        }  

        return view('loans.loan-applications.create')
               ->withCompanies($companies)
               ->withGroups($groups);

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

        $payload = app('request')->only('user_id', 'loan_amt', 'company_id', 'prime_limit_amt');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //create item
        $loanapplication = $this->model->create($request->all());

        Session::flash('success', 'Loan application successfully created');
        
        return redirect()->back();

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

            return view('accounts.user-accounts.savings.edit', compact('account', 'companies', 'products', 'statuses'));

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

            Session::flash('success', 'Successfully updated user savings account - ' . $account->account_no);
            //show updated record
            return redirect()->route('user-savings-accounts.show', $account->id);

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
        
        return view('accounts.user-accounts.savings.show', compact('account'));

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

}
