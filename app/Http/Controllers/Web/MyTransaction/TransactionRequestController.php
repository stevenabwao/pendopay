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
        return view('_web.my-transactions.create');
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

    // accept a transaction request
    public function accept($token, Request $request)
    {


        $itemdata = $this->model->where('id', $token)
                       ->where('status_id', getStatusInactive())
                       ->first();

        $trans_message = getMyTransactionMessage($itemdata);
        $itemdata->trans_message = $trans_message;

        // get trans partner role
        $trans_partner_role = getTransactionPartnerRole($itemdata);
        $itemdata->trans_partner_role = $trans_partner_role;

        return view('_web.my-transactions.create_step2', [
            'trans_data' => $itemdata
        ]);
    }

    public function storeStep2(Request $request, MyTransactionStoreStepTwo $myTransactionStoreStepTwo)
    {

        $this->validate($request, [
            'partner_details_select' => 'required',
            'transaction_partner_details' => 'required'
        ]);
        $request_id = $request->id;

        //create item
        try {
            $new_item = $myTransactionStoreStepTwo->createItem($request->all());
            $new_item_decode = json_decode($new_item);
            $new_item_message = $new_item_decode->message;

            // check if we found the user
            if ($new_item_message->error) {

                // error occured, user not found
                $result = $new_item_message->message;
                $the_message = $result->message;
                // dd($the_message);

                // show user form asking them to enter user email or phone OR go back and search again
                return redirect(route('my-transactions.create-step3', [
                    'id' => $request_id,
                    'error_message' => $the_message
                ]));

            } else {

                // no error user was found
                $result = $new_item_message->message;
                $user_data = $result->data;
                // dd($user_data);

                // show user form asking them to send request to this user
                return redirect(route('my-transactions.create-step3', [
                    'id' => $request_id,
                    'user_id' => $user_data->id
                ]));

            }

        } catch (\Exception $e) {

            $error_message = $e->getMessage();
            Session::flash('error', $error_message);
            return redirect()->back()->withInput()->withErrors($error_message);

        }

    }

    // send transaction request selected buyer/ seller
    public function create_step3($id, Request $request)
    {

        $user_id = NULL;
        $error_message = "";
        $itemdata = NULL;
        $userdata = NULL;
        // dd("chh", $request->all());

        // error message
        if ($request->error_message) {
            $error_message = $request->error_message;
        }

        // user data
        if ($request->user_id) {
            $user_id = $request->user_id;
            $userdata = User::find($user_id);

            $itemdata = $this->model->where('id', $id)
                       ->where('status_id', getStatusInactive())
                       ->first();

            $trans_message = getMyTransactionMessage($itemdata);
            $itemdata->trans_message = $trans_message;

            // get trans partner role
            $trans_partner_role = getTransactionPartnerRole($itemdata);
            $itemdata->trans_partner_role = $trans_partner_role;
        }
        // dd($itemdata);

        return view('_web.my-transactions.create_step3', [
            'id' => $id,
            'trans_data' => $itemdata,
            'user_data' => $userdata,
            'error_message' => $error_message
        ]);
    }

    public function storeStep3(Request $request, MyTransactionStoreStepThree $myTransactionStoreStepThree)
    {



        $this->validate($request, [
            'trans_partner_role' => 'required'
        ]);

        //create item
        try {
            $new_item = $myTransactionStoreStepThree->createItem($request->all());
            $new_item_decode = json_decode($new_item);
            $new_item_message = $new_item_decode->message;

            // check if we found the user
            if ($new_item_message->error) {
                // error occured, user not found
                $result = $new_item_message->message;
                $the_message = $result->message;
                // show user form asking them to enter user email or phone OR go back and search again
                dd($the_message);
            } else {
                // no error user was found
                $result = $new_item_message->message;
                $new_item_data = $result->data;
                // show user form asking them to send request to this user
                dd($new_item_data);
            }
            dd("end");

            // check whether user is buyer or seller
            // display screen to ask user to enter details of buyer/ seller
            /* Session::flash('success', $the_message);
            return redirect(route('my-transactions.create-step2', [
                'id' => $new_item_data->id
            ])); */

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

        return view('_web.my-transactions.show', compact('transaction'));

    }

}
