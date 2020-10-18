<?php

namespace App\Http\Controllers\Api\Ussd;

use App\Entities\Company;
use App\Entities\UssdEvent;
use App\Http\Controllers\BaseController;
use App\Transformers\Ussd\UssdEventTransformer;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Session;

class ApiUssdEventController extends BaseController
{
    
    /**
     * @var UssdEvent
     */
    protected $model;

    /**
     * Controller constructor.
     *
     * @param UssdEvent $model
     */
    public function __construct(UssdEvent $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $res = generate_account_number();
        //dd($result);

        /*start cache settings*/
        /*$url = request()->url();
        $params = request()->query();

        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration('low'); */
        /*end cache settings*/

        /*function getEvents() {
            
            $code   = $_REQUEST["USSD_PARAMS"];
            $inputs = explode("*", $code);
            $ussd_code = $inputs[1];

            $ussd_code = 44;

            $url = USSD_API_URL . 'ussd-events?ussd_code=' . $ussd_code . '&report=1';
            $curl_response = executeCurl($url);
            $response = json_decode($curl_response);

            log_this("url - " . $url);
            log_this("ussd_code - " . $ussd_code);
            log_this($response);

            $result = "";
            $i = 1;
            foreach($response->data as $item) {
                $result .= '\n' . $i . '. ' . $item->name;
                $i++;
            }
            return $result;

        }*/

        $ussdevents = new UssdEvent();

        //filter request
        $id = $request->id;
        $report = $request->report;
        $status_id = $request->status_id;
        $company_id = $request->company_id;
        $ussd_code = $request->ussd_code;
        $status = $request->status;
        $start_date = $request->start_date;
        if ($start_date) { $start_date = Carbon::parse($request->start_date); }
        $end_date = $request->end_date;
        if ($end_date) { $end_date = Carbon::parse($request->end_date); }
        
        //filter results
        if ($id) { 
            $ussdevents = $ussdevents->where('id', $id); 
        }
        if ($company_id) { 
            $ussdevents = $ussdevents->where('company_id', $company_id); 
        }
        if ($ussd_code) { 
            //get company id from ussd code
            $company_data = Company::where('ussd_code', $ussd_code)->first();
            $company_id = $company_data->id;
            $ussdevents = $ussdevents->where('company_id', $company_id); 
        }
        if ($status_id) { 
            $ussdevents = $ussdevents->where('status_id', $status_id); 
        }
        if ($start_date) { 
            $ussdevents = $ussdevents->where('created_at', '>=', $start_date); 
        }
        if ($end_date) { 
            $ussdevents = $ussdevents->where('created_at', '<=', $end_date); 
        }

        $ussdevents = $ussdevents->orderBy('created_at', 'desc');

        if (!$report) {
            $ussdevents = $ussdevents->paginate($request->get('limit', config('app.pagination_limit')));
            $data = $this->response->paginator($ussdevents, new UssdEventTransformer());
        } else {
            $ussdevents = $ussdevents->get();
            $data = $this->response->collection($ussdevents, new UssdEventTransformer());
        }
        //end filter request

        return $data;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required',
            'company_id' => 'required',
            'amount' => 'required',
        ];

        $payload = app('request')->only('name', 'amount', 'company_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            $error_messages = formatValidationErrors($validator->errors());
            throw new StoreResourceFailedException($error_messages);
        }

        //create item
        $ussdpayment = $this->model->create($request->all());

        return ['message' => 'USSD event created'];

    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {

        $ussdpayment = $this->model->findOrFail($id);

        return $this->response->item($ussdpayment, new UssdEventTransformer());

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

        return $this->response->item($ussdpayment->fresh(), new UssdEventTransformer());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
