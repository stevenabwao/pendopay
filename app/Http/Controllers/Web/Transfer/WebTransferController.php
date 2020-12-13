<?php

namespace App\Http\Controllers\Web\Transfer;

use Illuminate\Http\Request;
use App\Entities\Group;
use App\Entities\Country;
use App\Entities\CompanyBranch;
use App\Entities\Transfer;
use App\Entities\LoanAccount;
use App\Entities\TransactionAccount;
use App\Services\Transfer\TransferIndex;
use App\Services\Transfer\TransferStore;
use App\Services\Transfer\TransferUpdate;
use Session;
use App\Http\Controllers\Controller;
use App\Services\Transfer\TransferAccountCheck;
use App\Services\Transfer\TransferAccountCheckConfirm;
use Illuminate\Support\Facades\DB;

class WebTransferController extends Controller
{

    /**
     */
    protected $model;

    /**
     * constructor.
     *
     * @param Transfer $model
     */
    public function __construct(Transfer $model)
    {
        $this->model = $model;
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

        return view('_web.transfer.create');

    }

    public function create_step2(Request $request, TransferAccountCheck $transferAccountCheck)
    {

        $this->validate($request, [
            'destination_account_type' => 'required',
            'destination_account_no' => 'required'
        ]);

        // check if request is valid
        // if not, return appropriate error
        try {

            $transfer = $transferAccountCheck->createItem($request);
            // $transfer = json_decode($transfer);
            // $result_message_object = $transfer->message;
            // $result_message = $result_message_object->message;
            // $result_data = $result_message_object->data;
            // dd($result_message, $result_data);

            $transaction_account = NULL;
            $wallet_account = NULL;

            if ($request->destination_account_type == getAccountTypeTransactionAccount()) {
                $transaction_account = getDestinationAccountData($request->destination_account_type, $request->destination_account_no);
            } else {
                $wallet_account = getDestinationAccountData($request->destination_account_type, $request->destination_account_no);
            }

            // get user deposit account summary
            $deposit_account_summary = getUserDepositAccountSummaryData();

            return view('_web.transfer.create_step2', [
                'transaction_account' => $transaction_account,
                'wallet_account' => $wallet_account,
                'deposit_account_summary' => $deposit_account_summary
            ]);

        } catch (\Exception $e) {

            DB::rollback();
            // dd($e);
            $error_message = $e->getMessage();
            log_this($error_message);
            Session::flash('error', $error_message);
            return redirect()->back()->withInput()->withErrors($error_message);

        }

    }

    public function create_step3(Request $request, TransferAccountCheck $transferAccountCheck,
                                 TransferAccountCheckConfirm $transferAccountCheckConfirm)
    {

        $this->validate($request, [
            'destination_account_type' => 'required',
            'destination_account_no' => 'required',
            'transfer_amount' => 'required'
        ]);

        // check if request is valid
        // if not, return appropriate error
        try {

            $transfer = $transferAccountCheck->createItem($request);

        } catch (\Exception $e) {

            DB::rollback();
            // dd($e);
            $error_message = $e->getMessage();
            log_this($error_message);
            Session::flash('error', $error_message);
            return redirect()->back()->withInput()->withErrors($error_message);

        }

        // confirm transfer amount details
        try {

            $transfer = $transferAccountCheckConfirm->createItem($request);

            $transaction_account = NULL;
            $wallet_account = NULL;

            if ($request->destination_account_type == getAccountTypeTransactionAccount()) {
                $transaction_account = getDestinationAccountData($request->destination_account_type, $request->destination_account_no);
            } else {
                $wallet_account = getDestinationAccountData($request->destination_account_type, $request->destination_account_no);
            }
            // dd($transaction_account, $transaction_account->transaction);

            // get user deposit account summary
            $deposit_account_summary = getUserDepositAccountSummaryData();

            return view('_web.transfer.create_step3', [
                'transaction_account' => $transaction_account,
                'wallet_account' => $wallet_account,
                'deposit_account_summary' => $deposit_account_summary,
                'transfer_amount' => $request->transfer_amount
            ]);

        } catch (\Exception $e) {

            DB::rollback();
            // dd($e);
            $error_message = $e->getMessage();
            log_this($error_message);
            Session::flash('error', $error_message);
            return redirect()->back()->withInput()->withErrors($error_message);

        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TransferStore $transferStore, TransferAccountCheck $transferAccountCheck,
                          TransferAccountCheckConfirm $transferAccountCheckConfirm)
    {

        $this->validate($request, [
            'destination_account_type' => 'required',
            'destination_account_no' => 'required',
            'transfer_amount' => 'required'
        ]);

        // check if request is valid
        // if not, return appropriate error
        try {

            $transfer = $transferAccountCheck->createItem($request);

        } catch (\Exception $e) {

            $error_message = $e->getMessage();
            log_this($error_message);
            Session::flash('error', $error_message);
            return redirect()->back()->withInput()->withErrors($error_message);

        }

        // confirm transfer amount details
        try {

            $transfer = $transferAccountCheckConfirm->createItem($request);

        } catch (\Exception $e) {

            $error_message = $e->getMessage();
            log_this($error_message);
            Session::flash('error', $error_message);
            return redirect()->back()->withInput()->withErrors($error_message);

        }
        // dd($request->all());

        // create transfer item
        try {

            $transfer = $transferStore->createItem($request);
            $transfer = json_decode($transfer);
            $result_object = $transfer->message;
            $result_message = $result_object->message;
            $result_data = $result_object->data;
            //dd($result_message);

            $new_id = $result_data->id;
            Session::flash('success', 'Successfully transferred funds');
            // return redirect()->route('my-account.transferfund.show', $new_id);
            return redirect()->route('my-transactions.index');

        } catch(\Exception $e) {

            DB::rollback();
            dd($e);
            $message = 'Error. Could not create transfer entry - ' . $e->getMessage();
            log_this($message);
            Session::flash('error', $message);
            return redirect()->back()->withInput()->withErrors($message);

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

            return view('_web.transfer.show', compact('transfer', 'company_product_name'));

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
