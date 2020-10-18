<?php

namespace App\Http\Controllers\Api\Ussd;

use App\Company;
use App\Group;
use App\Http\Controllers\BaseController;
use App\SmsOutbox;
use App\Transformers\Ussd\UssdRegistrationTransformer;
use App\User;
use App\UssdEvent;
use App\UssdPayment;
use App\UssdRegistration;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Excel;
use Illuminate\Database\Eloquent\hydrate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Session;

class ApiUssdRegistrationController extends BaseController
{
    
    /**
     * @var 
     */
    protected $model;

    /**
     * Controller constructor.
     *
     * @param UssdRegistration $model
     */
    public function __construct(UssdRegistration $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        //get logged in user
        $user = auth()->user();
        
        //get data
        if ($user->hasRole('superadministrator')){

            //get data
            $ussdregistrations = new UssdRegistration();

        } else if ($user->hasRole('administrator')){
            
            //get user company 
            $user_company_id = $user->company->id;

            //get paybills accounts for showing in dropdown
            $ussdregistrations = UssdRegistration::where('company_id', $user_company_id);

        }

        //filter request
        $id = $request->id;
        $report = $request->report;
        $phone_number = $request->phone_number;
        $account_name = $request->account_name;
        $start_date = $request->start_date;
        $lipanampesa_code = $request->lipanampesa_code;
        if ($start_date) { $start_date = Carbon::parse($request->start_date); }
        $end_date = $request->end_date;
        if ($end_date) { $end_date = Carbon::parse($request->end_date); }
        
        //filter results
        if ($id) { 
            $ussdregistrations = $ussdregistrations->where('id', $id); 
        }
        if ($phone_number) { 
            //format the phone number
            $phone_number = formatPhoneNumber($phone_number);
            $ussdregistrations = $ussdregistrations->where('phone', $phone_number); 
        }
        if ($lipanampesa_code) { 
            $ussdregistrations = $ussdregistrations->whereIn('lipanampesacode', $lipanampesa_code); 
        }
        if ($account_name) { 
            $ussdregistrations = $ussdregistrations->where('name', $account_name); 
        }
        if ($start_date) { 
            $ussdregistrations = $ussdregistrations->where('created_at', '>=', $start_date); 
        }
        if ($end_date) { 
            $ussdregistrations = $ussdregistrations->where('created_at', '<=', $end_date); 
        }

        $ussdregistrations = $ussdregistrations->orderBy('created_at', 'desc');

        if (!$report) {
            
            $ussdregistrations = $ussdregistrations->paginate($request->get('limit', config('app.pagination_limit')));
            $data = $this->response->paginator($ussdregistrations, new UssdRegistrationTransformer());

        } else {
        
            $ussdregistrations = $ussdregistrations->get();
            $data = $this->response->collection($ussdregistrations, new UssdRegistrationTransformer());

        }
        //end filter request

        return $data;

    }

    //confirm registration
    public function confirm(Request $request)
    {

        //$ussdregistration = DB::table('ussd_registrations');
        $ussdregistration = new UssdRegistration();

        //filter request
        $id = $request->id;
        $phone_number = $request->phone_number;
        $tsc_no = $request->tsc_no;
        $ussd_event_id = $request->ussd_event_id;
        
        //get data
        if ($id) { 
            $ussdregistration = $ussdregistration->where('id', $id); 
        }

        if ($phone_number && $ussd_event_id) { 
            //format the phone number
            $phone_number = formatPhoneNumber($phone_number);
            $ussdregistration = $ussdregistration->where('phone', $phone_number)
                                                 ->where('ussd_event_id', $ussd_event_id); 
        }

        if ($tsc_no && $ussd_event_id) { 
            $ussdregistration = $ussdregistration->where('tsc_no', $tsc_no)
                                                 ->where('ussd_event_id', $ussd_event_id); 
        }

        $ussdregistration = $ussdregistration->first();

        $message = "No registration exists.";

        if (count($ussdregistration)) {
            
            //event
            $ussd_event_data = UssdEvent::find($ussdregistration->ussd_event_id);
            $event_name = $ussd_event_data->name;
            $company_id = $ussd_event_data->company_id;
            $company_name = $ussd_event_data->company->name;
            $event_cost = $ussd_event_data->amount;
            //company
            $payment_data = UssdPayment::where('phone', $phone_number)
                            ->where('ussd_event_id', $ussd_event_id)
                            ->first();

            if ($payment_data) {
                $amount_paid = $payment_data->amount;
            } else {
                $amount_paid = 0;
            }

            if ($ussdregistration->registered=='no') {

                //get account balance
                $balance = $event_cost - $amount_paid;
                $message = "Account not yet activated. ";
                if ($amount_paid  > 0) {
                    $message .= "You have paid Ksh $amount_paid. ";
                }
                $message .= "Please pay balance of Ksh $balance to activate.";

            } else {

                $message = "Registered.";
                $message .= " ID: " . $ussdregistration->id;
                $message .= ", Name: " . $ussdregistration->name;
                $message .= ", Phone: " . $ussdregistration->phone;
                $message .= ", Event: " . $event_name;
                $message .= ", Amount Paid: " . $amount_paid;
                $message .= ",\n" . $company_name;
                
            }

        }

        //get company sms details
        $sms_user_name = $ussdregistration->ussdevent->company->sms_user_name;
        $company_id = $ussdregistration->ussdevent->company->id;
        $phone = $ussdregistration->phone;
        //end get company details

        //start send an sms back with message
        createSmsOutbox($message, $phone, $company_id, $sms_user_name);
        //end send an sms back with message

        return ['message' => $message];

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        request()->merge(array(
                    'phone_country' => 'KE'
                ));

        $rules = [
            'name' => 'required',
            'phone' => 'required|phone:mobile',
            'phone_country' => 'required_with:phone',
            'tsc_no' => 'required',
            'ussd_event_id' => 'required',
        ];

        $payload = app('request')->only('name', 'phone', 'phone_country', 'tsc_no', 'ussd_event_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            //$error_messages = $validator->errors();
            //throw new StoreResourceFailedException($error_messages);
            $error_message = "An error occured";
            return $this->response->error($error_message, 503);
        }

        //VALIDATE
        $phone = getDatabasePhoneNumber($request->phone);
        $tsc_no = $request->tsc_no;
        $ussd_event_id = $request->ussd_event_id;

        //start if account with phone and ussd_event_id exists
        $registration_data = UssdRegistration::where('phone', $phone)
                             ->where('ussd_event_id', $ussd_event_id)
                             ->first();

        if ($registration_data) {
            
            //get event
            $name = $registration_data->name;
            $phone = $registration_data->phone;
            $company_name = $registration_data->ussdevent->company->name;
            $company_id = $registration_data->ussdevent->company->id;
            $ussd_code = $registration_data->ussdevent->company->ussd_code;
            $sms_user_name = $registration_data->ussdevent->company->sms_user_name;

            $message = sprintf("Dear %s. We already have your records. Dial *533*%s to confirm registration or recommend to a friend!", $name, $ussd_code);

            //user exists, start create new outbox/ sms
            createSmsOutbox($message, $phone, $company_id, $sms_user_name);
            //end create new outbox

            //user registration already exists, return status_code = 553
            return $this->response->item($registration_data, new UssdRegistrationTransformer)->setStatusCode(553);
        
        }
        //end if account with phone and ussd_event_id exists

        //start if account with tsc_no and ussd_event_id exists
        $tsc_registration_data = UssdRegistration::where('tsc_no', $tsc_no)
                                 ->where('ussd_event_id', $ussd_event_id)
                                 ->first();

        if (count($tsc_registration_data)) {

            //get event
            $name = $tsc_registration_data->name;
            $phone = $tsc_registration_data->phone;
            $company_name = $tsc_registration_data->ussdevent->company->name;
            $company_id = $tsc_registration_data->ussdevent->company->id;
            $ussd_code = $tsc_registration_data->ussdevent->company->ussd_code;
            $sms_user_name = $tsc_registration_data->ussdevent->company->sms_user_name;

            $message = sprintf("Dear %s. We already have your records. Dial *533*%s to confirm registration or recommend to a friend!", $name, $ussd_code);

            //user exists, start create new outbox/ sms
            createSmsOutbox($message, $phone, $company_id, $sms_user_name);
            //end create new outbox

            //user registration already exists, return status_code = 553
            return $this->response->item($tsc_registration_data, new UssdRegistrationTransformer)->setStatusCode(553);

        }
        //end if account with phone and ussd_event_id exists
        //END VALIDATE

        //create item
        $ussd_registration = $this->model->create($request->all());

        return $this->response->item($ussd_registration, new UssdRegistrationTransformer);

    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {

        $ussdregistration = $this->model->findOrFail($id);

        $data = $this->response->item($ussdregistration, new UssdRegistrationTransformer());

        return $data;

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
        
        $ussd_registration = $this->model->findOrFail($id);
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
            throw new StoreResourceFailedException($error_messages);
        }

        $ussd_registration->update($request->except('created_at'));

        return $this->response->item($ussd_registration->fresh(), new UssdRegistrationTransformer());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
