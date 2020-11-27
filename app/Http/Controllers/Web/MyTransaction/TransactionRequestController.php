<?php

namespace App\Http\Controllers\Web\MyTransaction;

use App\Entities\Transaction;
use App\Entities\Status;
use App\Entities\TransactionRequest;
use App\Http\Controllers\Controller;
use App\Services\MyTransaction\MyTransactionIndex;
use App\Services\MyTransaction\MyTransactionStore;
use App\Services\MyTransaction\MyTransactionStoreStepThree;
use App\Services\MyTransaction\MyTransactionStoreStepTwo;
use App\Services\TransactionRequest\TransactionRequestAcceptStore;
use App\User;
use Illuminate\Http\Request;
use Session;

class TransactionRequestController extends Controller
{

    /**
     */
    protected $model;

    /**
     * constructor.
     *
     * @param TransactionRequest $model
     */
    public function __construct(TransactionRequest $model)
    {
        $this->model = $model;
    }

    /**
     *
     * @param Request $request
     * @return mixed
    */
    public function index(Request $request, MyTransactionIndex $myTransactionIndex)
    {

        // get trans data
        $data = $myTransactionIndex->getData($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }

        $statuses = Status::where("section", "LIKE", "%trans%")->get();

        return view('_web.my-transactions.index', [
            'transactions' => $data,
            'statuses' => $statuses
        ]);

    }

    public function create(Request $request)
    {
        return view('_web.transaction-requests.create');
    }

    public function store(Request $request, MyTransactionStore $myTransactionStore)
    {

        $this->validate($request, [
            'title' => 'required',
            'transaction_amount' => 'required',
            'transaction_date' => 'required|date|date_format:d-m-Y|after:yesterday',
            'transaction_role' => 'required',
            'terms' => 'required'
        ]);

        //create item
        try {
            $new_item = $myTransactionStore->createItem($request->all());
            $new_item = json_decode($new_item);
            $result = $new_item->message->message;
            $success_message = $result->message;
            $new_item_data = $result->data;
            // dd($new_item_data, $success_message);

            // check whether user is buyer or seller
            // display screen to ask user to enter details of buyer/ seller
            Session::flash('success', $success_message);
            return redirect(route('my-transactions.create-step2', [
                'id' => $new_item_data->id
            ]));

        } catch (\Exception $e) {

            $error_message = $e->getMessage();
            Session::flash('error', $error_message);
            return redirect()->back()->withInput()->withErrors($error_message);

        }

    }

    public function show($id)
    {

        // get logged user
        $logged_user_id = getLoggedUser()->id;

        // get statuses array
        $status_ids_array = [];
        $status_ids_array[] = getStatusPending();
        $status_ids_array[] = getStatusActive();
        $status_ids_array[] = getStatusCompleted();
        $status_ids_array[] = getStatusCancelled();
        $status_ids_array[] = getStatusExpired();

        // get records where user is seller or buyer
        $transaction = $this->model->where('id', $id)
                       ->whereIn('status_id', $status_ids_array)
                       ->where(function($q) use ($logged_user_id){
                            $q->orWhere('seller_user_id', '=', $logged_user_id);
                            $q->orWhere('buyer_user_id', '=', $logged_user_id);
                       })
                       ->firstOrFail();

        return view('_web.transaction-requests.show', compact('transaction'));

    }

    // accept a transaction request
    public function accept($token, Request $request)
    {

        // get transaction request data
        $transrequestdata = $this->model->where('confirm_code', $token)
                       ->where('status_id', getStatusActive())
                       ->first();

        if($transrequestdata) {

            $transaction_id = $transrequestdata->transaction_id;

        } else {

            // transaction request not found
            $error_message = "Invalid transaction request status";
            Session::flash('error', $error_message);
            abort(403);

        }

        // get transaction data
        $itemdata = Transaction::find($transaction_id);
        // dd("itemdata --- ", $itemdata);

        /* $trans_message = getMyTransactionMessage($itemdata);
        $itemdata->trans_message = $trans_message; */

        // get trans role
        // check whether user is seller or buyer in transaction
        try {

            $trans_role = isAcceptingUserSellerOrBuyer($itemdata);
            $itemdata->trans_role = $trans_role;

        } catch(\Exception $e) {

            $error_msg = $e->getMessage();
            $itemdata->error_msg = $error_msg;

        }

        // get site setting - transaction terms and conditions
        $site_settings = getSiteSettings();
        $terms_and_conditions = $site_settings['transaction_terms_and_conditions'];

        return view('_web.transaction-requests.accept_transaction', [
            'transaction_data' => $itemdata,
            'transaction_request_data' => $transrequestdata,
            'terms_and_conditions' => $terms_and_conditions,
            'token' => $token
        ]);

    }

    // accept a transaction request store
    public function acceptStore(Request $request, $token, TransactionRequestAcceptStore $transactionRequestAcceptStore)
    {

        $this->validate($request, [
            'submit_btn' => 'required',
            'transaction_id' => 'required',
            'transaction_request_id' => 'required'
        ]);

        // merge with token flag
        $request->merge([
            'token' => $token
        ]);

        //create item
        try {
            $new_item = $transactionRequestAcceptStore->createItem($request->all());
            $new_item_decode = json_decode($new_item);
            $new_item_message = $new_item_decode->message->message;
            // dd($new_item_message, $new_item_message->message);

            // get trans request data
            $transaction_data = $new_item_message->data;
            $transaction_id = $transaction_data->id;
            // dd("transaction_id +++ ", $transaction_id);

            // no error user was found
            $success_message = $new_item_message->message;

            // redirect to success page/ transaction request show
            Session::flash('success', $success_message);
            return redirect()->route('my-transactions.show', $transaction_id);

        } catch (\Exception $e) {

            $error_message = $e->getMessage();
            Session::flash('error', $error_message);
            return redirect()->back()->withInput()->withErrors($error_message);

        }

    }

}
