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
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Session;

class LoanApprovalController extends Controller
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

        //return cached data or cache if cached data not exists
       // return Cache::remember($fullUrl, $minutes, function () use ($data) {
            return view('loans.loan-applications.index', [
                'loanapplications' => $data->appends(Input::except('page'))
            ]);
       // });

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, LoanApplicationApprove $loanApplicationApprove)
    { 

        //get more data
        $rules = [
            'loan_application_id' => 'required',
        ];

        $payload = app('request')->only('loan_application_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //create item
        $loanapplication = $loanApplicationApprove->createItem($request->all());

        Session::flash('success', 'Loan application successfully created');
        
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
        $loanapplication = $loanApplicationShow->showItem($id);

        //$loanapplication = json_decode($loanapplication);

        //$loanapplication = $loanapplication->message;

        //dd($loanapplication);
        
        return view('loans.loan-applications.show', compact('loanapplication'));

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
