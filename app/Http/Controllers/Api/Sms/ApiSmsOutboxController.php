<?php

namespace App\Http\Controllers\Api\Sms;

use App\Entities\Company;
use App\Entities\Group;
use App\Http\Controllers\BaseController;
use App\Entities\ScheduleSmsOutbox;
use App\Entities\SmsOutbox;
use App\Transformers\Sms\SmsOutboxTransformer;
use App\User;
use Carbon\Carbon;
use Excel;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Http\Request;
use Session;

class ApiSmsOutboxController extends BaseController
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
    public function __construct(SmsOutbox $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        //get logged in user
        $user = auth()->user();

        //get companies data sent via url
        $companies_request = $request['companies'];
        $companies_array = [];

        if ($companies_request) { $companies_array[] = $companies_request; }
        
        //get account companies
        if ($user->hasRole('superadministrator')){
            
            //companies used to fetch remote data
            if (!count($companies_array)) {
                //get all companies
                $companies_array = Company::pluck('id')
                        ->toArray();
            }

            //get companies accounts for showing in dropdown
            $companies = Company::all();

        } else if ($user->hasRole('administrator')){
            
            //get user company 
            $user_company_id = $user->company->id;

            //companies used to fetch remote data
            if (!count($companies_array)) {
                $companies_array = Company::where('id', $user_company_id)
                        ->pluck('id')
                        ->toArray();
            }

            //get companies for showing in dropdown
            $companies = Company::where('id', $user_company_id)
                        ->get();

        } else {

            throw new StoreResourceFailedException("Permission Error");

        }

        //filter request
        $id = $request->id;
        $report = $request->report;
        $status_id = $request->status_id;
        $company_id = $request->company_id;
        $start_date = $request->start_date;
        if ($start_date) { 
            $start_date = Carbon::parse($request->start_date); 
            $start_date = $start_date->startOfDay();
        }
        $end_date = $request->end_date;
        if ($end_date) { 
            $end_date = Carbon::parse($request->end_date); 
            $end_date = $end_date->endOfDay();
        }

        //create new SmsOutbox object
        $smsoutboxes = $this->model;
        
        //filter results
        if (count($companies_array)) { 
            $smsoutboxes = $smsoutboxes->whereIn('company_id', $companies_array); 
        }
        if ($company_id) { 
            $smsoutboxes = $smsoutboxes->where('company_id', $company_id); 
        }
        if ($status_id) { 
            $ussdevents = $ussdevents->where('status_id', $status_id); 
        }
        if ($start_date) { 
            $smsoutboxes = $smsoutboxes->where('created_at', '>=', $start_date); 
        }
        if ($end_date) { 
            $smsoutboxes = $smsoutboxes->where('created_at', '<=', $end_date); 
        }
        
        $smsoutboxes = $smsoutboxes->orderBy('created_at', 'desc');

        if (!$report) {
            $smsoutboxes = $smsoutboxes->paginate($request->get('limit', config('app.pagination_limit')));
            $data = $this->response->paginator($smsoutboxes, new SmsOutboxTransformer());
        } else {
            $smsoutboxes = $smsoutboxes->get();
            $data = $this->response->collection($smsoutboxes, new SmsOutboxTransformer());
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
            'sms_message' => 'required'
        ];

        $payload = app('request')->only('sms_message');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        //get params
        $client_id = config('constants.bulk_sms.client_id');
        $client_secret = config('constants.bulk_sms.client_secret');
        $token_url = config('constants.bulk_sms.token_url');
        $username = config('constants.bulk_sms.username');
        $password = config('constants.bulk_sms.password');
        
        //get access token
        $access_token = prepare_access_token($token_url, $username, $password, $client_id, $client_secret);

        //get sent variables 
        $send_sms_url = config('constants.bulk_sms.send_sms_url');
        $params = [
            'json' => [
                "sms_message"=> $request->sms_message,
                "phone_number"=> $request->phone_number
            ]
        ];

        //start create new sms
        sendAuthPostApi($send_sms_url, $access_token, $params);
        //end create new sms

        return ['message' => 'SMS created'];

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        //get details for this smsoutbox
        $smsoutbox = SmsOutbox::where('id', $id)
                 ->with('company')
                 ->first();
        
        return view('smsoutbox.show', compact('smsoutbox'));

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $user_id = auth()->user()->id;

        $this->validate($request, [
            'name' => 'required|max:255',
            'phone_number' => 'required|max:255',
            'company_id' => 'required|max:255'
        ]);

        $group = Group::findOrFail($id);
        $group->name = $request->name;
        $group->company_id = $request->company_id;
        $group->phone_number = $request->phone_number;
        $group->email = $request->email;
        $group->physical_address = $request->physical_address;
        $group->box = $request->box;
        $group->updated_by = $user_id;
        $group->save();

        Session::flash('success', 'Successfully updated group - ' . $group->name);
        return redirect()->route('smsoutbox.show', $group->id);

    }


}
