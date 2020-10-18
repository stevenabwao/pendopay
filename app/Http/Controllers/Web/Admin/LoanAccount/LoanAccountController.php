<?php

namespace App\Http\Controllers\Web\LoanAccount;

use App\Entities\LoanAccount;
use App\Entities\Company;
use App\Entities\Group;
use App\Entities\LoanApplication;
use App\Entities\Product;
use App\Entities\Status;
use App\Entities\LoanRepayment;
use App\Http\Controllers\Controller;
use App\Services\LoanAccount\LoanAccountIndex;
use App\Services\LoanApplication\LoanApplicationIndex;
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
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

        return view('accounts.user-accounts.loan-accounts.index', [
            'loanaccounts' => $data->appends(Input::except('page'))
        ]);

    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        //get logged in user
        $user = auth()->user();

        //if user is superadmin, show all companies, else show a user's companies
        if ($user->hasRole('superadministrator')) {
            //get details for this item
            $loanaccount = $this->model->find($id);
        } else if ($user->hasRole('administrator')) {
            //get details for this item
            $companies_array = getUserCompanies($request);
            $loanaccount = $this->model->where('id', $id)
                            ->whereIn('company_id', $companies_array)
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
