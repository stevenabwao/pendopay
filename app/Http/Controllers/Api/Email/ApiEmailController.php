<?php

namespace App\Http\Controllers\Api\Email;

use App\Company;
use App\Http\Controllers\BaseController;
use App\Transformers\Email\EmailTransformer;
use App\Services\Email\EmailIndex;
use App\Services\Email\EmailStore;
use App\Services\Email\EmailMainStore;
use App\Transformers\Users\UserTransformer;
use App\User;
use App\Entities\Email;
use App\Entities\EmailQueue;
use App\Services\EmailQueue\EmailQueueIndex;
use App\Services\EmailQueue\EmailQueueStore;
use App\Services\EmailSend\EmailSendStore;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input; 
use Illuminate\Support\Facades\DB;
use Session;

class ApiEmailController extends BaseController
{

    /**
     * @var Email
     */
    protected $model;

    /**
     * Controller constructor.
     *
     * @param Email $model
     */
    public function __construct(EmailQueue $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, EmailQueueIndex $emailQueueIndex)
    {

        // get the data
        // DB::enableQueryLog();

        $data = $emailQueueIndex->getData($request);

        // dd(DB::getQueryLog());
        // dd($data);

        //are we in report mode?
        if (!$request->report) {

            // $data = $this->response->paginator($data, new EmailQueueTransformer());

        } else {

            $data = $data->get();
            // $data = $this->response->collection($data, new EmailQueueTransformer());

        }

        return $data;

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, EmailQueueStore $emailQueueStore)
    {

        $rules = [
            'parent_id' => 'required|integer',
            'reminder_message_id' => 'required|integer',
            'email_text' => 'required',
            'email_address' => 'required|email',
            'company_id' => 'required',
            'subject' => 'required',
            'has_attachments' => 'required'
        ];

        $payload = app('request')->only('email_text', 'email_address', 'company_id', 
                                        'subject', 'has_attachments', 'parent_id', 'reminder_message_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) { 

            return showValidationErrors($validator->errors());

        }

        //start create email queue entry
        DB::beginTransaction();

            try {

                //create item
                $email_result = $emailQueueStore->createItem($request->all());
                $result_json = json_decode($email_result);

                log_this($result_json);

                // $message = "Email saved to queue";

                ////////////////////////////
               // dd($result_json);

                $error = $result_json->error;
                $message = $result_json->message;

                if ($error){
                    $response = $message->message;
                    // return show_success($response);
                    return showCompoundMessage(200, $message);
                } else {
                    $response = $message->message;
                    // return show_success($response);
                    return showCompoundMessage(200, $message);
                }   
                ////////////////////////////

            } catch(\Exception $e) {

                DB::rollback(); 
                //dd($e);
                $message = 'Error. Could not save email to queue - ' . $e->getMessage();
                $show_message = $message . ' - ' . $e;
                log_this($show_message);
            
                /* $email_update = EmailQueue::find($email_main_result_message->id)
                                ->update([
                                    'fail_reason' => $message,
                                    'failed' => '1',
                                    'failed_at' => getCurrentDate()
                                ]); */

                // return show_error($message);
                return showCompoundMessage(422, $message);
                
            }

        DB::commit();
        //end create other email data in transaction

        // return show_success($message);
        return showCompoundMessage(200, $message);

    }

    public function send(Request $request, EmailSendStore $emailSendStore)
    {

        /* $rules = [
            'email_text' => 'required',
            'email' => 'required|email',
            'company_id' => 'required',
            'subject' => 'required',
            'has_attachments' => 'required'
        ];

        $payload = app('request')->only('email_text', 'email', 'company_id', 'subject', 'has_attachments');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) { 
            return showValidationErrors($validator->errors());
        } */

        //start send email
        DB::beginTransaction();

            try {

                //create item
                $email_result = $emailSendStore->createItem();
                $email_result = json_decode($email_result);
                // dd("email_result HERERE *** ", $email_result);

                log_this($email_result);

                $message = "Email sent successfully";

            } catch(\Exception $e) {

                DB::rollback(); 
                //dd($e);
                $message = 'Error. Could not send email - ' . $e->getMessage();
                $show_message = $message . ' - ' . $e;
                log_this($show_message);

                // return show_error($message);
                return showCompoundMessage(422, $message);
                
            }

        DB::commit();
        //end create other email data in transaction

        // return show_success($message);
        return showCompoundMessage(200, $message);

    }

    /**
     * Display the specified resource.
     */

    /* public function show($id)
    {

        $email = $this->model->findOrFail($id);

        return $this->response->item($email, new EmailTransformer());

    } */


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

        $ussdemail = $this->model->findOrFail($id);
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'tsc_no' => 'required'
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'name' => 'sometimes|required',
                'phone' => 'sometimes|required',
                'tsc_no' => 'sometimes|required'
            ];
        }

        $payload = app('request')->only('name', 'phone', 'tsc_no');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            $error_messages = formatValidationErrors($validator->errors());
            //throw new StoreResourceFailedException($error_messages);
            $message = "Please enter all required fields";
            // return show_error($message);
            return showCompoundMessage(422, $message);
        }

        $ussdemail->update($request->except('created_at'));

        // return $this->response->item($ussdemail->fresh(), new UssdEmailTransformer());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
