<?php

namespace App\Http\Controllers\Api\Account;

use App\Entities\Company;
use App\Entities\LoanAccount;
use App\Entities\Group;
use App\Entities\Status;
use App\Http\Controllers\Controller;
use App\Services\LoanAccount\LoanAccountIndex;
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Session;

use App\Http\Controllers\BaseController;
use App\Transformers\Account\LoanAccountTransformer;

class ApiLoanAccountController extends BaseController
{
    
    /**
     * @var state
     */
    protected $model;

    /**
     * ApiLoanAccountController constructor.
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
        // dd($data);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new LoanAccountTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new LoanAccountTransformer());

        }

        return $data;

    }


    /**
     * @param $id
     * @return mixed
    */
    public function show($id)
    {
        $item = $this->model->findOrFail($id);

        return $this->response->item($item, new LoanAccountTransformer());
    }

    /**
     * @param $request
     * @return mixed
    */
    public function showRecent(Request $request)
    {
        $item = $this->model->where('company_id', $request->company_id)
                            ->where('user_id', $request->user_id)
                            ->orderBy('created_at', 'desc')
                            ->first();

        return $this->response->item($item, new LoanAccountTransformer());
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

        return view('accounts.deposit-accounts.loan-repayments.create')
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

            return view('accounts.deposit-accounts.loan-repayments.edit', compact('account', 'companies', 'products', 'statuses'));

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
            return redirect()->route('loan-repayments-deposit-accounts.show', $account->id);

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

        return redirect()->route('loan-applications.index');
    }

}
