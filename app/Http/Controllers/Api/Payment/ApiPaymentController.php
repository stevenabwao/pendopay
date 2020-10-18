<?php
namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\BaseController;
use App\Services\Payment\PaymentIndex;
use App\Services\Payment\PaymentStore;
use App\Services\Payment\PaymentMainStore;
use App\Entities\Payment;
use App\Http\Resources\Payment\PaymentCollection;
use App\Http\Resources\Payment\PaymentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class ApiPaymentController extends BaseController
{

    /**
     * @var Payment
     */
    protected $model;

    /**
     * Controller constructor.
     *
     * @param Payment $model
     */
    public function __construct(Payment $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PaymentIndex $paymentIndex)
    {

        // get the data
        $data = $paymentIndex->getData($request);

        //are we in report mode?
        if (!$request->report) {

            $data = new PaymentCollection($data);

        } else {

            $data = $data->get();
            $data = PaymentResource::collection($data);

        }

        return $data;

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PaymentMainStore $paymentMainStore, PaymentStore $paymentStore)
    {

        $rules = [
            'payment_method_id' => 'required',
            'amount' => 'required',
            //'account_no' => 'required',
            'full_name' => 'required'
        ];

        $payload = app('request')->only('payment_method_id', 'amount', 'full_name');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            $message = "Please enter all required fields";
            return show_error_response($validator->errors());
        }

        //create main payment first
        try {
            $payment_main_result = $paymentMainStore->createItem($request->all());
            $payment_main_result = json_decode($payment_main_result);
            // dd($payment_main_result);
        } catch(\Exception $e) {
            log_this($e->getMessage());
            dd($e);
        }

        $payment_main_result_message = $payment_main_result->message;
        $new_payment_main_result_message = $payment_main_result_message->message;
        // dd($new_payment_main_result_message->id);

        //start create other payment data in transaction
        DB::beginTransaction();

            try {

                //create item
                $payment_result = $paymentStore->createItem($request->all(), $new_payment_main_result_message);
                $payment_result = json_decode($payment_result);

                log_this($payment_result);
                $message = "Payment created";

            } catch(\Exception $e) {

                DB::rollback();
                // dd($e);
                $message = 'Error. Could not complete payment transactions - ' . $e->getMessage();
                $show_message = $message . ' - ' . $e;
                log_this($show_message);

                $payment_update = Payment::find($new_payment_main_result_message->id)
                                ->update([
                                    'fail_reason' => $message,
                                    'failed' => '1',
                                    'failed_at' => getCurrentDate(1)
                                ]);

                return show_error($message);

            }

        DB::commit();
        //end create other payment data in transaction

        return show_success($message);

    }


    public function makePaymentStore(Request $request, PaymentStore $paymentStore)
    {

        $this->validate($request, [
            'phone_number' => 'required',
            'user_id' => 'required',
            'order_id' => 'required',
            'amount' => 'required',
        ]);

        //create item
        $payment_result = $paymentStore->createItem($request->all());
        $payment_result = json_decode($payment_result);
        $result_message = $payment_result->message;

        if (!$payment_result->error) {
            $payment_result_message = $result_message->message;
            Session::flash('success', $payment_result_message);
            return redirect()->back()->with('add_cart', '1');
        } else {
            Session::flash('error', $result_message->message);
            return redirect()->back()->withInput()->withErrors($result_message->message);
        }

    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {

        $payment = $this->model->findOrFail($id);

        return new PaymentResource($payment);

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
