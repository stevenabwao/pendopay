<?php

namespace App\Http\Controllers\Web\Payment;

use App\Company;
use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Entities\PaymentMethod;
use App\Entities\Payment;
use App\Services\Payment\PaymentIndex;
use App\Services\Payment\PaymentShow;
use App\Services\Payment\PaymentUpdate;
use App\Services\Payment\PaymentRepost;
use App\Services\Payment\PaymentMainStore;
use App\Services\Payment\PaymentStore;
use App\Transformers\Payment\PaymentTransformer;
use App\User;
use Carbon\Carbon;
use Excel;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Session;

class PaymentController extends Controller
{

    /**
     * @var state
     */
    protected $model;

    /**
     *
     * @param Payment $model
     */
    public function __construct(Payment $model)
    {
        $this->model = $model;
        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PaymentIndex $paymentIndex)
    {

        //get logged in user
        $user = auth()->user();

        //get paybills
        $paybills_array = getAllUserMpesaPaybills($user);

        //dd($paybills_array);

        //if paybills records exist
        if (count($paybills_array)) {
            $paybills = $paybills_array;
        }

        //get the data
        $data = $paymentIndex->getData($request);

        //are we in report mode?
        if ($request->report) {
            $data = $data->get();
        }

        $paymentmethods = PaymentMethod::where('status_id', '1')->get();

        //return view with appended url params
        return view('payments.index', [
            'payments' => $data,
            'mpesapaybills' => $paybills_array,
            'paymentmethods' => $paymentmethods
        ]);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $user = auth()->user();
        $companies = getUserCompanies();
        $paymentmethods = PaymentMethod::where('status_id', '1')->orderBy('id', 'desc')->get();

        return view('payments.create', compact('companies', 'paymentmethods', 'user'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PaymentStore $paymentStore, PaymentMainStore $paymentMainStore)
    {

        $rules = [
            'company_id'    => 'required',
            'amount'        => 'required',
            'full_name'     => 'required',
            'phone'         => 'required',
            'payment_at'    => 'required|date|date_format:d-m-Y'
        ];

        $payload = app('request')->only('company_id', 'amount', 'full_name', 'phone', 'payment_at');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //create main payment first
        try {

            //create item
            $payment_main_result = $paymentMainStore->createItem($request->all());
            $payment_main_result = json_decode($payment_main_result);
            $payment_main_result_message = $payment_main_result->message;
            $payment_main_result_message = $payment_main_result_message->message;
            //dd($payment_main_result, $payment_main_result_message);

        } catch(\Exception $e) {

            //dd($e);
            $message = 'Error. Could not create payments entry ' . ' - ' . $e->getMessage();

            $show_message = $message . ' - ' . $e;
            log_this($show_message);

            Session::flash('error', $message);
            return redirect()->back()->withInput()->withErrors($message);

        }


        //start create other payment data in transaction
        DB::beginTransaction();

            try {

                //create item
                $payment_result = $paymentStore->createItem($request->all(), $payment_main_result_message);
                $payment_result = json_decode($payment_result);

                //get new record entry
                $new_id = $payment_main_result_message->id;

            } catch(\Exception $e) {

                DB::rollback();
                dd($e);
                $message = 'Error. Could not complete payment transactions - ' . $e->getMessage();
                $show_message = $message . ' - ' . $e;
                log_this($show_message);

                $payment_update = Payment::find($payment_main_result_message->id)
                                ->update([
                                    'fail_reason' => $message,
                                    'failed' => '1',
                                    'failed_at' => getCurrentDate()
                                ]);

                Session::flash('error', $message);
                return redirect()->back()->withInput()->withErrors($message);

            }

        DB::commit();

        Session::flash('success', 'Successfully created new payment');
        return redirect()->route('payments.show', $new_id);

    }


    /**
     * Display the specified resource.
     */
    public function show($id, PaymentShow $paymentShow)
    {

        $companies = getUserCompanyIds();
        $paymentdata = $this->model->where('id', $id)
                       ->whereIn('company_id', $companies)
                       ->first();
                       //dd($id, $companies, $paymentdata);

        if ($paymentdata) {

            //get the data
            $payment = $paymentShow->getData($id);
            $payment_id = $payment->id;
            //dd($payment);

            //get deposit record
            $deposit_record = $paymentShow->getDepositRecord($payment_id);
            //dd($deposit_record);

            return view('payments.show', compact('payment', 'deposit_record'));

        } else {

            abort(404);

        }

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, PaymentShow $paymentShow)
    {

        //get the data
        $payment = $paymentShow->getData($id);

        return view('payments.edit', compact('payment'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, PaymentUpdate $paymentUpdate)
    {

        //error check
        $rules = [
            'account_no' => 'required',
        ];

        $payload = app('request')->only('account_no');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //update the data
        $result = $paymentUpdate->updateItem($id, $request);
        $result = json_decode($result);
        $result_message = $result->message;
        //dd($result);

        //return show_success($result->message);

        //return success or error message
        if (!$result->error) {

            Session::flash('success', 'Successfully updated payment id - ' . $id);
            return redirect()->route('payments.show', $id);

        } else {

            //error occured while updating record
            Session::flash('error', $result_message);
            return redirect()->back()->withInput();

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Repost the transaction.
     */
    public function repost($id, Request $request, PaymentRepost $paymentRepost)
    {

        $companies = getUserCompanyIds();
        //dd($companies);
        $paymentdata = $this->model->where('id', $id)
                       ->whereIn('company_id', $companies)
                       ->first();

        //dd($id, $companies, $paymentdata);

        if ($paymentdata) {

            //start repost the payment
            DB::beginTransaction();

                try {

                    //create item
                    $result = $paymentRepost->updateItem($id, $request);
                    $result = json_decode($result);
                    $result_message = $result->message;
                    //dd($result_message, $id);

                } catch(\Exception $e) {

                    DB::rollback();
                    //dd($e);

                    $message = 'Error. Could not repost payment - ' . $e->getMessage();
                    $show_message = $message . ' - ' . $e;
                    log_this($show_message);

                    $payment_update = Payment::find($id)
                                    ->update([
                                        'fail_reason' => $message,
                                        'failed' => '1',
                                        'failed_at' => getCurrentDate()
                                    ]);

                    Session::flash('error', $message);
                    return redirect()->back()->withInput()->withErrors($message);

                }

            DB::commit();
            //end  repost the payment

            //return result
            Session::flash('success', 'Successfully reposted payment id - ' . $id);
            return redirect()->route('payments.show', $id);

        } else {

            abort(404);

        }

    }

    public function repost2($id, Request $request)
    {

        $user = auth()->user();
        $logged_user_full_names = $user->first_name . ' ' . $user->last_name;

        //if user is superadmin, show all companies, else show a user's companies
        if (($user->hasRole('superadministrator')) ||
            ($user->hasRole('administrator') && ($user->company->id=='52'))){

            //get deposit details
            $request->merge(['id' => $id]);

            //get the deposit and verify its processed status
            $yehudeposit = getLocalpayments($request);
            $yehudeposit_data = $yehudeposit['message'];
            //dd($yehudeposit_data, $request);

            //proceed if there is no error
            if (!$yehudeposit['error']) {

                //proceed only if item actually exists in table
                if (count($yehudeposit_data->data)){

                    //get first item from array
                    $yehudeposit_data = $yehudeposit_data->data[0];
                    //dd($yehudeposit_data);

                    //get processed status
                    $processed = $yehudeposit_data->processed;

                    //if record is not processed yet, proceed
                    if (!$processed) {

                        //set the acct_no back & other required params
                        $acct_no = $yehudeposit_data->acct_no;
                        $amount = $yehudeposit_data->amount;
                        $phone_number = $yehudeposit_data->phone_number;
                        $full_name = $yehudeposit_data->full_name;

                        $request['acct_no'] = $acct_no;
                        $request['amount'] = $amount;
                        $request['phone_number'] = $phone_number;
                        $request['full_name'] = $full_name;
                        $request['paybill_number'] = $yehudeposit_data->paybill_number;
                        $request['src_ip'] = $yehudeposit_data->src_ip;
                        $request['trans_id'] = $yehudeposit_data->trans_id;

                        $request['action'] = 'repost';
                        $request['reposted_by'] = $logged_user_full_names;

                        //create a new deposit entry to remote yehu db
                        $yehudeposit_insert = createYehuDeposit($request);

                        //return success or error message
                        if ((!$yehudeposit_insert['error']) && ($yehudeposit_insert["message"])) {

                            Session::flash('success', 'Successfully reposted remote yehu deposit id - ' . $id);
                            return redirect()->route('payments.index');

                        } else {

                            //error occured while updating record
                            Session::flash('error', $yehudeposit_insert['message']);
                            return redirect()->back()->withInput();

                        }

                    } else {

                        //record is already processed, throw back an error
                        Session::flash('error', 'Record has already been processed!');
                        return redirect()->route('payments.show', $id);

                    }

                } else {

                    //record non-existent, throw back an error
                    Session::flash('error', 'Non-existent record!');
                    return redirect()->route('payments.index');

                }

            } else {

                //error occured in accessing record
                Session::flash('error', 'Error accessing record!');
                return redirect()->route('payments.index');

            }

        } else {

            abort(404);

        }

    }

}
