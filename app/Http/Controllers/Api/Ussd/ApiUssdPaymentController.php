<?php

namespace App\Http\Controllers\Api\Ussd;

use App\Company;
use App\Http\Controllers\BaseController;
use App\Transformers\Ussd\UssdPaymentTransformer;
use App\User;
use App\UssdPayment;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Session;

class ApiUssdPaymentController extends BaseController
{
    
    /**
     * @var UssdPayment
     */
    protected $model;

    /**
     * Controller constructor.
     *
     * @param UssdPayment $model
     */
    public function __construct(UssdPayment $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        //define constants
        //DEFINE('USSD_API_URL', 'http://41.215.126.10/public/api/');
        //DEFINE('USSD_API_URL', 'http://localhost:8000/api/');
        
        //MESSAGES    
        /*DEFINE('ERROR_RECORD_EXISTS', '423');
        DEFINE('ERROR_NOT_FOUND', '404');
        DEFINE('ERROR_OCCURED', '503');

        DEFINE('MESSAGE_OK', '200');*/

        //AFRIKAA SETTINGS
        /*DEFINE('USSD_AFRIKAA_EVENT_ID', '1');
        DEFINE('USSD_AFRIKAA_COMPANY_ID', '58');

        $url = USSD_API_URL . 'ussd-registration';
        $curl_post_data = array(
          'ussd_event_id' => USSD_AFRIKAA_EVENT_ID,
          'phone' => '254720743211',
          'alternate_phone' => '254720111222',
          'name' => 'Nikklass KKK',
          'tsc_no' => '467234',
          'company_id' => USSD_AFRIKAA_COMPANY_ID,
          'email' => 'aaa@bbb.com',
          'county' => 'Nairobi',
          'sub_county' => 'Nairobi',
          'ict_level' => 'Good',
          'workplace' => 'HB',
          'subjects' => 'Maths'
        );

        //dd($curl_post_data);

        $data_string = json_encode($curl_post_data);
        //dd($data_string);
        $method = "post";
        $curl_response = executeCurl($url, $method, $data_string);
        $response_status = getCurlHttpStatus($url);
        dump('HTTP:/' . $response_status . ' - ' . $curl_response);
        $response = json_decode($curl_response);

        //handle error result
        if ($response_status == ERROR_RECORD_EXISTS) {
$data = $response->data;
            $name = $data->name;
            dump(sprintf("\n\n=========== CLIENT [ %s:%s ] ALREADY REGISTERED! =================\n\n", $msisdn, $name));
            $menu = sprintf("Dear %s.\nWe already have your records. Dial *533*44# to confirm registration or recommend to a friend!", $name);
        }


        if ($response_status == MESSAGE_OK) {
$data = $response->data;
            $name = $data->name;
            dump(sprintf("\n\n=========== CLIENT IS [ %s:%s ] UNKNOWN! =================\n\n", $msisdn, $data));
$menu = sprintf("Dear %s.\nRegistration successful. Please make payment to activate registration.", $name);
        }

        exit;*/


        /*start cache settings*/
        /*$url = request()->url();
        $params = request()->query();

        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration('low'); */
        /*end cache settings*/

        //get logged in user
        //$user = auth()->user();
        
        //get data
        /*if ($user->hasRole('superadministrator')){

            //get data
            $ussdpayments = new UssdPayment();

        } else if ($user->hasRole('administrator')){
            
            //get user company 
            $user_company_id = $user->company->id;

            $ussdpayments = UssdPayment::select('ussd_payments.*')
                    ->join('ussd_events' , 'ussd_payments.event_id' ,'=' , 'events.id')
                    ->where('ussd_events.company_id', $user_company_id);

        }*/

        //get data
        $ussdpayments = new UssdPayment();

        //filter request
        $id = $request->id;
        $report = $request->report;
        $phone_number = $request->phone_number;
        $event_id = $request->event_id;
        $start_date = $request->start_date;
        $lipanampesa_code = $request->lipanampesa_code;
        if ($start_date) { $start_date = Carbon::parse($request->start_date); }
        $end_date = $request->end_date;
        if ($end_date) { $end_date = Carbon::parse($request->end_date); }
        
        //filter results
        if ($id) { 
            $ussdpayments = $ussdpayments->where('ussd_payments.id', $id); 
        }
        if ($phone_number) { 
            //format the phone number
            $phone_number = formatPhoneNumber($phone_number);
            $ussdpayments = $ussdpayments->where('ussd_payments.phone', $phone_number); 
        }
        if ($lipanampesa_code) { 
            $ussdpayments = $ussdpayments->whereIn('lipanampesacode', $lipanampesa_code); 
        }
        if ($event_id) { 
            $ussdpayments = $ussdpayments->where('ussd_payments.ussd_event_id', $account_name); 
        }
        if ($start_date) { 
            $ussdpayments = $ussdpayments->where('created_at', '>=', $start_date); 
        }
        if ($end_date) { 
            $ussdpayments = $ussdpayments->where('created_at', '<=', $end_date); 
        }

        $ussdpayments = $ussdpayments->orderBy('created_at', 'desc');

        if (!$report) {
            
            $ussdpayments = $ussdpayments->paginate($request->get('limit', config('app.pagination_limit')));
            $data = $this->response->paginator($ussdpayments, new UssdPaymentTransformer());

        } else {
        
            $ussdpayments = $ussdpayments->get();
            $data = $this->response->collection($ussdpayments, new UssdPaymentTransformer());

        }
        //end filter request

        return $data;

        //return cached data or cache if cached data not exists
        /*return Cache::remember($fullUrl, $minutes, function () use ($data) {
            return $data;
        });*/

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        

        $rules = [
            'phone' => 'required',
            'amount' => 'required',
            'ussd_event_id' => 'required',
            'mpesa_trans_id' => 'required'
        ];

        $payload = app('request')->only('phone', 'amount', 'ussd_event_id', 'mpesa_trans_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            $error_messages = formatValidationErrors($validator->errors());
            throw new StoreResourceFailedException($error_messages);
        }

        //create item
        $ussdpayment = $this->model->create($request->all());

        return ['message' => 'USSD payment created'];

    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {

        /*start cache settings*/
        /*$url = request()->url();
        $params = $id;

        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration(); */
        /*end cache settings*/

        $ussdpayment = $this->model->findOrFail($id);

        return $this->response->item($ussdpayment, new UssdPaymentTransformer());

        //return cached data or cache if cached data not exists
        /*return Cache::remember($fullUrl, $minutes, function () use ($data) {
            return $data;
        });*/

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
        
        $ussdpayment = $this->model->findOrFail($id);
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

        $ussdpayment->update($request->except('created_at'));

        return $this->response->item($ussdpayment->fresh(), new UssdPaymentTransformer());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
