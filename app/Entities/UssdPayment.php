<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\UssdEvent;
use App\Entities\UssdPayment;
use App\Entities\UssdPaymentDeposit;
use App\Entities\UssdRegistration;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UssdPayment extends Model
{

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'ussd_event_id', 'amount', 'mpesa_trans_id', 'phone', 'user_agent', 'browser', 'browser_version', 'os', 'device', 'src_ip'
    ];


    public function ussdevent() {
        return $this->belongsTo(UssdEvent::class, 'ussd_event_id', 'id');
    }


    /**
      * @param array $attributes
      * @return \Illuminate\Database\Eloquent\Model
      */
    public static function create(array $attributes = [])
    {
 
        $message = "";

        //get submitted data
        $mpesa_trans_id = $attributes['mpesa_trans_id'];
        $ussd_event_id = $attributes['ussd_event_id'];
        $phone = $attributes['phone'];
        $amount_paid = $attributes['amount'];
        $full_name = "";
        if (array_key_exists('full_name', $attributes)) {
            $full_name = $attributes['full_name'];
        }

        //create a new payment or update if it exists
        $existing_payment = UssdPayment::where('phone', $phone)
                            ->where('ussd_event_id', $ussd_event_id)
                            ->first();

        if ($existing_payment) {

            $old_amount = $existing_payment->amount;
            //update existing payment
            $existing_payment->mpesa_trans_id = $mpesa_trans_id;
            $existing_payment->phone = $phone;
            $existing_payment->amount = $old_amount + $amount_paid;
            $existing_payment->save();

            $model = $existing_payment;

        } else {
            
            //create new payment
            $agent = new \Jenssegers\Agent\Agent;
     
            $attributes['user_agent'] = serialize($agent);
            $attributes['browser'] = $agent->browser();
            $attributes['browser_version'] = $agent->version($agent->browser());
            $attributes['os'] = $agent->platform();
            $attributes['device'] = $agent->device();
            $attributes['src_ip'] = getIp();
            //end add user env
     
            $model = static::query()->create($attributes);

         }
 
         if ($model) {
             
            //start store payment deposit entry
            $attributes = $model->toArray();
            $ussd_payment_deposit = new UssdPaymentDeposit();
            $attributes['amount'] = $amount_paid;
            $ussd_payment_deposit = $ussd_payment_deposit->create($attributes);
            //end store payment deposit entry

            //start if account is active, show error message
            $registration_data = UssdRegistration::where('phone', $phone)
                                  ->where('ussd_event_id', $ussd_event_id)
                                  ->where('registered', 'yes')
                                  ->first();

             //get total event registration payments by this user/ account
             $user_payments = UssdPayment::select(DB::raw('sum(amount) as total_paid'))
                              ->where('phone', $phone)
                              ->where('ussd_event_id', $ussd_event_id)
                              ->first();

            //get reg details
            $ussd_registration = UssdRegistration::where('phone', $phone)
                              ->where('ussd_event_id', $ussd_event_id)
                              ->first();
 
             //calculate total already paid for event by user/ account
             $total_paid = $user_payments->total_paid;
 
             //find total required amount to be paid
             $required_payment_data = UssdEvent::find($ussd_event_id);
             $required_payment = $required_payment_data->amount;
             $company_name = $required_payment_data->company->name;

             //start if reg data exists
             if (count($registration_data)) {

                if (!$full_name) {
                  $full_name = $registration_data->name;
                }
                $message = "Dear $full_name, payment of Ksh $amount_paid received.";
                $message .= " Registration is already active!";
                $message .= ", Name: " . $registration_data->name;
                $message .= ", Phone: " . $registration_data->phone;
                $message .= ", Event: " . $registration_data->ussdevent->name;
                //$message .= ", Amount Paid: " . $amount_paid;
                $message .= ".\n" . $registration_data->ussdevent->company->name;

            }
            //end if reg data exists
 
            //check if full payment has been made, if so, activate user account
            if ($total_paid >= $required_payment) {
                
                if ($ussd_registration) {

                    //payment complete, activate account 
                    $ussd_registration->registered = 'yes';
                    $ussd_registration->save();
                
                    if (!$message) {
                        if (!$full_name) {
                          $full_name = $ussd_registration->name;
                        }
                        $message = "Dear $full_name, Payment of Ksh $amount_paid received.";
                        $message .= " Registration activated.\n";
                        $message .= ", Name: " . $ussd_registration->name;
                        $message .= ", Phone: " . $ussd_registration->phone;
                        $message .= ", Event: " . $ussd_registration->ussdevent->name;
                        //$message .= ", Amount Paid: " . $amount_paid;
                        $message .= ".\n" . $ussd_registration->ussdevent->company->name;
                    }

                } else {

                    $message = "Dear $full_name, Payment of Ksh $amount_paid received. Your registration data could not be found. Please contact us.\n$company_name";

                }

            } else {
                
                if (!$message) {
                    if (!$full_name) {
                      $full_name = $ussd_registration->name;
                    }
                    //get account balance
                    $balance = $required_payment - $total_paid;
                    $message = "Dear $full_name, Payment of Ksh $amount_paid received. Please pay balance of Ksh $balance to activate registration.\n$company_name";
                }

            }
 
        }

        //start get company details
        $ussd_payment = UssdPayment::where('ussd_event_id', $ussd_event_id)
                        ->first();
        //get company sms details
        $sms_user_name = $ussd_payment->ussdevent->company->sms_user_name;
        $company_id = $ussd_payment->ussdevent->company->id;
        //end get company details

        //start create new outbox
        createSmsOutbox($message, $phone, $company_id, $sms_user_name);
        //end create new outbox
 
        return $model;
 
    }


    //start convert dates to local dates
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }


    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }
    //end convert dates to local dates


}
