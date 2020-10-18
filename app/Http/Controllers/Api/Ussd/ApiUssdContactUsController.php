<?php

namespace App\Http\Controllers\Api\Ussd;

use App\Company;
use App\Http\Controllers\BaseController;
use App\Transformers\Ussd\UssdContactUsTransformer;
use App\User;
use App\UssdContactUs;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Session;

class ApiUssdContactUsController extends BaseController
{
    
    /**
     * @var UssdContactUs
     */
    protected $model;

    /**
     * Controller constructor.
     *
     * @param UssdContactUs $model
     */
    public function __construct(UssdContactUs $model)
    {
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        /*start cache settings*/
        $url = request()->url();
        $params = request()->query();

        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration('low'); 
        /*end cache settings*/

        //get logged in user
        $user = auth()->user();
        
        //get data
        if ($user->hasRole('superadministrator')){

            //get data
            $ussdcontactus = new UssdContactUs();

        } else if ($user->hasRole('administrator')){
            
            //get user company 
            $user_company_id = $user->company->id;
            $ussdcontactus = UssdContactUs::where('company_id', $user_company_id);

        }

        //filter request
        $id = $request->id;
        $report = $request->report;
        $company_id = $request->company_id;
        $phone_number = $request->phone_number;
        $created_at = $request->created_at;
        if ($created_at) { $created_at = Carbon::parse($request->created_at); }
        
        //filter results
        if ($id) { 
            $ussdcontactus = $ussdcontactus->where('id', $id); 
        }
        if ($company_id) { 
            $ussdcontactus = $ussdcontactus->where('company_id', $company_id); 
        }
        if ($phone_number) { 
            //format the phone number
            $phone_number = formatPhoneNumber($phone_number);
            $ussdcontactus = $ussdcontactus->where('mobile', $phone_number); 
        }
        
        if ($created_at) { 
            $ussdcontactus = $ussdcontactus->where('created_at', '>=', $created_at); 
        }

        $ussdcontactus = $ussdcontactus->orderBy('created_at', 'desc');

        if (!$report) {
            
            $ussdcontactus = $ussdcontactus->paginate($request->get('limit', config('app.pagination_limit')));
            $data = $this->response->paginator($ussdcontactus, new UssdContactUsTransformer());

        } else {
        
            $ussdcontactus = $ussdcontactus->get();
            $data = $this->response->collection($ussdcontactus, new UssdContactUsTransformer());

        }
        //end filter request

        //return cached data or cache if cached data not exists
        return Cache::remember($fullUrl, $minutes, function () use ($data) {
            return $data;
        });

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        

        $rules = [
            'phone' => 'required',
            'company_id' => 'required',
            'message' => 'required'
        ];

        $payload = app('request')->only('phone', 'company_id', 'message');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            $error_messages = formatValidationErrors($validator->errors());
            throw new StoreResourceFailedException($error_messages);
        }

        //create item
        $ussdcontactus = $this->model->create($request->all());

        return ['message' => 'USSD contact us created'];

    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $ussdcontactus = $this->model->findOrFail($id);
        return $this->response->item($ussdcontactus, new UssdContactUsTransformer());

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
        
        $ussdcontactus = $this->model->findOrFail($id);
        $rules = [
            'msg_text' => 'required',
            'phone' => 'required',
            'company_id' => 'required'
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'msg_text' => 'sometimes|required',
                'phone' => 'sometimes|required',
                'company_id' => 'sometimes|required'
            ];
        }

        $payload = app('request')->only('msg_text', 'phone', 'company_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            $error_messages = formatValidationErrors($validator->errors());
            throw new StoreResourceFailedException($error_messages);
        }

        $ussdcontactus->update($request->except('created_at'));

        return $this->response->item($ussdcontactus->fresh(), new UssdContactUsTransformer());

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }


}
