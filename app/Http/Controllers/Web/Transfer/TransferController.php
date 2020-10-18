<?php

namespace App\Http\Controllers\Web\Transfer;

use Illuminate\Http\Request;
use App\Entities\Group;
use App\Entities\Country;
use App\User;
use App\Entities\Company;
use App\Entities\CompanyBranch;
use App\Entities\CompanyUser;
use App\Entities\Transfer;
use App\Entities\BranchGroup;
use App\Entities\Product;
use App\Entities\LoanAccount;
use App\Services\Transfer\TransferIndex;
use App\Services\Transfer\TransferStore;
use App\Services\Transfer\TransferUpdate;

use Session;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Entities\DepositAccountSummary;

class TransferController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Transfer $model)
    {
        $this->model = $model;
        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TransferIndex $transferIndex)
    {

        //get the data
        $companies = getAllUserCompanies($request);

        $data = $transferIndex->getData($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }

        return view('transfers.index', [
            'companies' => $companies,
            'transfers' => $data
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        /* $companies = getUserCompanyIds();
        $countries = Country::all();
        $companybranches = CompanyBranch::whereIn('company_id', $companies)->get();
        $companyusers = CompanyUser::whereIn('company_id', $companies)->get();
        $products = Product::where('transferable', "1")->get();

        return view('transfers.create', compact('companybranches', 'countries', 'companyusers', 'products')); */

        return view('transfers.create');

    }

    public function create_step2(Request $request)
    {

        //DB::enableQueryLog();

        //account type texts
        $deposit_account_text = config('constants.account_type_text.deposit_account');
        $loan_account_text = config('constants.account_type_text.loan_account');
        $shares_account_text = config('constants.account_type_text.shares_account');
        
        //dd($request);
        $rules = [
            'source_account' => 'required',
            'destination_account' => 'required',
        ];
        $payload = app('request')->only('source_account', 'destination_account');
        $validator = app('validator')->make($payload, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //get logged in user
        $user = auth()->user();

        $companies_array = getUserCompanies($request);
        $company_ids_array = getUserCompanyIds($request);

        $source_title = "";
        $source_text = "";
        $destination_title = "";
        $destination_text = "";
        $source_accounts = "";
        //get accounts
        if ($company_ids_array) {

            //source
            if ($request->source_account == $deposit_account_text) {
                $source_title = getAccountNameText($deposit_account_text);
                $source_text = $deposit_account_text;
                $account_type = $deposit_account_text;

                $source_accounts = getTransferAccountData($request, $company_ids_array, $account_type);

            }

            //destination
            //deposit account
            if ($request->destination_account == $deposit_account_text) {

                $destination_title = getAccountNameText($deposit_account_text);
                $destination_text = $deposit_account_text;
                $account_type = $deposit_account_text;
                
                $destination_accounts = getTransferAccountData($request, $company_ids_array, $account_type);

            }

            //shares account
            if ($request->destination_account == $shares_account_text){
                
                $destination_title = getAccountNameText($shares_account_text);
                $destination_text = $shares_account_text;
                $account_type = $shares_account_text;

                $destination_accounts = getTransferAccountData($request, $company_ids_array, $account_type);
                
            }

            //loan account
            if ($request->destination_account == $loan_account_text){
                
                $destination_title = getAccountNameText($loan_account_text);
                $destination_text = $loan_account_text;
                $account_type = $loan_account_text;

                $destination_accounts = getTransferAccountData($request, $company_ids_array, $account_type);   
                //dd($destination_accounts);             

            }
            //dd(DB::getQueryLog());
            
        } else {

            abort(503);

        }

        //continue if list exists
        if ($source_accounts) {

            return view('transfers.create2', [
                    'source_accounts' => $source_accounts,
                    'destination_accounts' => $destination_accounts,
                    'source_title' => $source_title,
                    'destination_title' => $destination_title,
                    'source_text' => $source_text,
                    'destination_text' => $destination_text
                ]);

        } else {
            abort(404);
        }

    }

    public function create_step3(Request $request)
    {

        //dd($request);

        $rules = [
            'source_account' => 'required',
            'destination_account' => 'required',
            'source_text' => 'required',
            'destination_text' => 'required',
        ];
        $payload = app('request')->only('source_account', 'destination_account', 'source_text', 'destination_text');
        $validator = app('validator')->make($payload, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
        //dd($request);

        $transfer_data = getTransferSummaryData($request);
        //$transfer_data = json_decode($transfer_data);
        //dd($transfer_data);

        //check if source and destination accts are from same company
        $source_account = $transfer_data['source_account'];
        $destination_account = $transfer_data['destination_account'];
        $source_company= $source_account->company;
        $destination_company= $destination_account->company;
        //dd($source_company, $destination_company);
        if ($source_company->id != $destination_company->id) {
            //show error, redirect back
            Session::flash('error', "Source and destination accounts must be from the same company");
            return redirect()->back()->withInput();
        }
        //dd($source_company->id, $destination_company->id);

        //continue if list exists
        if ($transfer_data) {

            return view('transfers.create3', [
                'source_account' => $transfer_data['source_account'],
                'destination_account' => $transfer_data['destination_account'],
                'source_title' => $transfer_data['source_title'],
                'destination_title' => $transfer_data['destination_title'],
                'source_text' => $transfer_data['source_text'],
                'destination_text' => $transfer_data['destination_text']
            ]);

        } else {

            abort(404);

        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TransferStore $transferStore)
    {

        $user_id = auth()->user()->id;

        $this->validate($request, [
            'amount' => 'required|regex:/^\d+(\.\d+)?$/',
            'source_account' => 'required',
            'destination_account' => 'required',
            'source_text' => 'required',
            'destination_text' => 'required',
        ]);
        //dd($request);

        //create item
        DB::beginTransaction();

            try {

                $transfer = $transferStore->createItem($request);
                $transfer = json_decode($transfer);
                $result_message = $transfer->message;
                //dd($result_message);
                
                $new_id = $result_message->message->id;
                Session::flash('success', 'Successfully created new transfer');
                return redirect()->route('transfers.show', $new_id);

            } catch(\Exception $e) {

                DB::rollback(); 
                //dd($e);
                $message = 'Error. Could not create transfer entry - ' . $e->getMessage();
                log_this($message);
                Session::flash('error', $message);
                return redirect()->back()->withInput()->withErrors($message);
                
            }

        DB::commit();

    }


    public function store2(Request $request, TransferStore $transferStore)
    {

        $user_id = auth()->user()->id;

        $this->validate($request, [
            'amount' => 'required|regex:/^\d+(\.\d+)?$/',
            'source_account' => 'required',
            'destination_account' => 'required',
            'source_text' => 'required',
            'destination_text' => 'required',
        ]);
        //dd($request);

        //create item
        $transfer = $transferStore->createItem($request);
        $transfer = json_decode($transfer);
        $result_message = $transfer->message;
        //dd($result_message);
        
        if (!$transfer->error) {
            //$result_message = json_decode($result_message);
            //dd($result_message);
            $new_id = $result_message->message->id;
            Session::flash('success', 'Successfully created new transfer');
            return redirect()->route('transfers.show', $new_id);
        } else {
            Session::flash('error', $result_message->message);
            return redirect()->back()->withInput()->withErrors($result_message->message);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        //get item
        $companies = getUserCompanyIds();
        $transfer = $this->model->where('id', $id)
                       ->whereIn('company_id', $companies)
                       ->first();
        //dd($transfer);
        //if transfer is a loan account
        $company_product_name = "";
        if ($transfer->destination_account_type == 'loan_account') {
            //get the loan product name
            $loan_account_id = $transfer->destination_account_id;
            $loan_account_data = LoanAccount::find($loan_account_id);
            $company_product_name = $loan_account_data->companyproduct->name;
        }

        if ($transfer) {

            return view('transfers.show', compact('transfer', 'company_product_name'));

        } else {

            abort(404);

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

        //get item
        $companies = getUserCompanies();
        $company_ids = getUserCompanyIds();
        $branchmember = Transfer::where('id', $id)
                       ->whereIn('company_id', $company_ids)
                       ->first();

        if ($branchmember) {

            $countries = Country::all();
            $companybranches = CompanyBranch::whereIn('company_id', $company_ids)->get();

            return view('transfers.edit', compact('companybranches', 'countries', 'branchmember'));

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

        $user_id = auth()->user()->id;

        $this->validate($request, [
            'name' => 'required|max:255',
            'phone_number' => 'sometimes|max:13,phone_number,'.$id,
            'company_id' => 'required|max:255'
        ]);

        $phone_number = '';
        if ($request->phone_number) {
            if (!isValidPhoneNumber($request->phone_number)){
                $message = \Config::get('constants.error.invalid_phone_number');
                Session::flash('error', $message);
                return redirect()->back()->withInput();
            }
            $phone_number = formatPhoneNumber($request->phone_number);
        }

        $group = Group::findOrFail($id);
        $group->name = $request->name;
        $group->company_id = $request->company_id;
        $group->phone_number = $phone_number;
        $group->description = trim($request->description);
        $group->email = $request->email;
        $group->physical_address = trim($request->physical_address);
        $group->box = $request->box;
        $group->updated_by = $user_id;
        $group->save();

        Session::flash('success', 'Successfully updated group - ' . $group->name);
        return redirect()->route('transfers.show', $group->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
