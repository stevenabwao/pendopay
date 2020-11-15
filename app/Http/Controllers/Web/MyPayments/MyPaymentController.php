<?php

namespace App\Http\Controllers\web\MyPayments;

use App\Http\Controllers\Controller;
use App\Services\MyPayment\MyPaymentStore;
use Illuminate\Http\Request;
use Session;

class MyPaymentController extends Controller
{
    //
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('_web.my-payments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('_web.my-payments.create');
    }

    public function store(Request $request, MyPaymentStore $myPaymentStore)
    {

        $this->validate($request, [
            'amount' => 'required|numeric',
            'phone' => 'required|phone:KE,mobile',
        ]);

        //create item
        try {
            $new_item = $myPaymentStore->createItem($request->all());
            $new_item = json_decode($new_item);
            $result = $new_item->message->message;
            $success_message = $result->message;
            $new_item_data = $result->data;

            // success response
            Session::flash('success', $success_message);
            return redirect(route('my-payments.index'));

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

        return view('_web.my-payments.show', compact('transaction'));

    }


}


