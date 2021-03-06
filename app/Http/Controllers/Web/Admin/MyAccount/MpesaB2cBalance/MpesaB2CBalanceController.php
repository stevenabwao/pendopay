<?php

namespace App\Http\Controllers\Web\MyAccount\MpesaB2CBalance;

use Illuminate\Http\Request;
use App\User;
use App\Entities\Company;
use App\Services\MyAccount\MpesaB2CBalance\MpesaB2CBalanceIndex;

use Session;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class MpesaB2CBalanceController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, MpesaB2CBalanceIndex $mpesaB2CBalanceIndex)
    {

        //get the data
        $companies = getAllUserCompanies($request);

        $data = $mpesaB2CBalanceIndex->getData($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }

        return view('transfers.index', [
            'companies' => $companies,
            'transfers' => $data
        ]);

    }

    //get mpesa balance
    public function getmpesab2cbalance(Request $request)
    {

        //get the data
        $companies = getAllUserCompanies($request);
        $company_id = $companies[0]->id;
        $company_id = "55";
        //dd($company_id);

        $the_company_name = "";
        //start get company mpesa shortcode data
        $mpesa_shortcode_data = getMainCompanyMpesaShortcode($company_id);
        log_this(json_encode($mpesa_shortcode_data));
        $mpesa_shortcode_data = json_decode($mpesa_shortcode_data);
        //dd($mpesa_shortcode_data);
        $mpesa_shortcode_data = $mpesa_shortcode_data->data;
        $mpesa_shortcode_company_data = $mpesa_shortcode_data->company->data;
        //dd($mpesa_shortcode_data, $mpesa_shortcode_company_data);
        $shortcode_number = $mpesa_shortcode_data->shortcode_number;
        //company details
        $phone_number = $mpesa_shortcode_data->company->data->phone;
        $company_email = $mpesa_shortcode_data->company->data->email;
        $company_name = $mpesa_shortcode_data->company->data->name;
        $company_short_name = $mpesa_shortcode_data->company->data->short_name;
        //set company name
        if ($company_short_name) {
            $the_company_name = $company_short_name;
        } else {
            $the_company_name = $company_name;
        }
        //end get company mpesa shortcode data

        //start get company mpesa balance
		$mpesa_balance_data = getMpesaB2cBalanceData($shortcode_number);
		log_this("mpesa_balance_data - ".  json_encode($mpesa_balance_data));

		if ($mpesa_balance_data) {
			$mpesa_balance_data = json_decode($mpesa_balance_data);
			//dd($mpesa_balance_data, $limit_amount);
			$mpesa_balance_data = $mpesa_balance_data->data;
			$mpesa_balance_amount = $mpesa_balance_data->utility_bal;
            $balance_amount_fmt = formatCurrency($mpesa_balance_amount);
            //dd($mpesa_balance_data, $balance_amount_fmt);

            return view('manage.myaccount.mpesab2c.balance', [
                'companies' => $companies,
                'mpesabalancedata' => $mpesa_balance_data,
                'mpesashortcodedata' => $mpesa_shortcode_data,
                'mpesacompanydata' => $mpesa_shortcode_company_data
            ]);

        } else {

            abort(404);

        }        

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

                $source_accounts = getMyAccountAccountData($request, $company_ids_array, $account_type);

            }

            //destination
            //deposit account
            if ($request->destination_account == $deposit_account_text) {

                $destination_title = getAccountNameText($deposit_account_text);
                $destination_text = $deposit_account_text;
                $account_type = $deposit_account_text;
                
                $destination_accounts = getMyAccountAccountData($request, $company_ids_array, $account_type);

            }

            //shares account
            if ($request->destination_account == $shares_account_text){
                
                $destination_title = getAccountNameText($shares_account_text);
                $destination_text = $shares_account_text;
                $account_type = $shares_account_text;

                $destination_accounts = getMyAccountAccountData($request, $company_ids_array, $account_type);
                
            }


            //loan account
            if ($request->destination_account == $loan_account_text){
                
                $destination_title = getAccountNameText($loan_account_text);
                $destination_text = $loan_account_text;
                $account_type = $loan_account_text;

                $destination_accounts = getMyAccountAccountData($request, $company_ids_array, $account_type);                

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

        $transfer_data = getMyAccountSummaryData($request);
        $transfer_data = json_decode($transfer_data);
        //dd($transfer_data);

        /* if ($request->has('order_by')) {
            $data->appends('order_by', $request->get('order_by'));
        }
        if ($request->has('order_style')) {
            $data->appends('order_style', $request->get('order_style'));
        } */

        //continue if list exists
        if ($transfer_data) {

            return view('transfers.create3', [
                'source_account' => $transfer_data->source_account,
                'destination_account' => $transfer_data->destination_account,
                'source_title' => $transfer_data->source_title,
                'destination_title' => $transfer_data->destination_title,
                'source_text' => $transfer_data->source_text,
                'destination_text' => $transfer_data->destination_text
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
    public function store(Request $request, MyAccountStore $transferStore)
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

        if ($transfer) {

            return view('transfers.show', compact('transfer'));

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
        $branchmember = MyAccount::where('id', $id)
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
