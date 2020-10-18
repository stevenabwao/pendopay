<?php

namespace App\Services\EmailBatch;

use App\Entities\EmailQueue;
use App\Entities\EmailBatchDetail;
use App\Entities\EmailBatch;
use App\Entities\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmailBatchStore
{

	public function createItem() {

        $sent_status = config('constants.status.sent');
        $pending_status = config('constants.status.pending');
        //get queued emails
        $queued_emails = EmailQueue::where('status_id', '!=', $sent_status)
                         ->limit(50)
                         ->orderBy('created_at', 'desc')
                         ->get();

        if (count($queued_emails)) {

            $email_count = 0;
            
            //create a new batch 
            $emailBatch = new EmailBatch();

                $emailBatch->created_by_name = "System";
                //$emailBatch->created_at = getCurrentDate(1);

            $newEmailBatch = $emailBatch->save();

            //store emails in batch
            foreach ($queued_emails as $queued_email){
                //store each email in email batch
                $emailBatchDetail = new EmailBatchDetail();

                    $emailBatchDetail->email_queue_id = $queued_email->id;
                    $emailBatchDetail->email_batch_id = $emailBatch->id;
                    $emailBatchDetail->status_id = $pending_status;

                $emailBatchDetail->save();

                $email_count++;
            }

            //update email_batch email count
            //update record
            $email_batch_update = $emailBatch
                ->update([
                    'number_emails' => $email_count
                ]);

        }

        dd($queued_emails);

        try {

            //create new loan application
            $email_queue = new EmailQueue();

            $new_email_queue = $email_queue->create($attributes);

            $response['message'] = "Email has been added to the emails queue";

        } catch(\Exception $e) { +

            DB::rollback();
            //dd($e);
            $message = $e->getMessage();
            log_this($message);
            $message['message'] = $message;
            return show_json_error($message);

        }

        //dd($new_loan_application);
        
        DB::commit();
        
        return show_json_success($response);


    }

}