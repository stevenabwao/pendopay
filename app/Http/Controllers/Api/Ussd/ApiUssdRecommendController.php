<?php

namespace App\Http\Controllers\Api\Ussd;

use App\Entities\Company;
use App\Http\Controllers\BaseController;
use App\Transformers\Ussd\UssdRecommendTransformer;
use App\User;
use App\Entities\UssdRecommend;
use App\Services\UssdRecommend\UssdRecommendStore;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Session;

class ApiUssdRecommendController extends BaseController
{
    
    /**
     * @var UssdRecommend
     */
    protected $model;

    /**
     * Controller constructor.
     *
     * @param UssdRecommend $model
     */
    public function __construct(UssdRecommend $model)
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
            $ussdrecommend = new UssdRecommend();

        } else if ($user->hasRole('administrator')){
            
            //get user company 
            $user_company_id = $user->company->id;
            $ussdrecommend = UssdRecommend::where('company_id', $user_company_id);

        }

        //filter request
        $id = $request->id;
        $report = $request->report;
        $company_id = $request->company_id;
        $sender_phone_number = $request->sender_phone_number;
        $receiver_phone_number = $request->receiver_phone_number;
        $created_at = $request->created_at;
        if ($created_at) { $created_at = Carbon::parse($request->created_at); }
        
        //filter results
        if ($id) { 
            $ussdrecommend = $ussdrecommend->where('id', $id); 
        }
        if ($company_id) { 
            $ussdrecommend = $ussdrecommend->where('company_id', $company_id); 
        }
        if ($sender_phone_number) { 
            //format the phone number
            $sender_phone_number = formatPhoneNumber($sender_phone_number);
            $ussdrecommend = $ussdrecommend->where('mobile', $sender_phone_number); 
        }
        if ($receiver_phone_number) { 
            //format the phone number
            $receiver_phone_number = formatPhoneNumber($receiver_phone_number);
            $ussdrecommend = $ussdrecommend->where('rec_mobile', $receiver_phone_number); 
        }
        if ($created_at) { 
            $ussdrecommend = $ussdrecommend->where('created_at', '>=', $created_at); 
        }

        $ussdrecommend = $ussdrecommend->orderBy('created_at', 'desc');

        if (!$report) {
            
            $ussdrecommend = $ussdrecommend->paginate($request->get('limit', config('app.pagination_limit')));
            $data = $this->response->paginator($ussdrecommend, new UssdRecommendTransformer());

        } else {
        
            $ussdrecommend = $ussdrecommend->get();
            $data = $this->response->collection($ussdrecommend, new UssdRecommendTransformer());

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
    public function store(Request $request, UssdRecommendStore $ussdRecommendStore)
    {
        

        $rules = [
            'phone' => 'required',
            'rec_phone' => 'required',
            'full_name' => 'required', 
            'rec_name' => 'required',
            'company_id' => 'required'
        ];

        $payload = app('request')->only('phone', 'rec_phone', 'full_name', 'rec_name', 'company_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            $error_message = $validator->errors();
            return show_json_error($error_message);
            //throw new StoreResourceFailedException($error_message);
        }

        //create item
        $result = $ussdRecommendStore->createItem($request->all());
        $result = json_decode($result);
        //dd($result);
        $result_message = $result->message; 

        if (!$result->error) {
            $message = 'Successfully created';
            return show_success($message);
        } else {
            $message = $result_message;
            return show_error($message);
        }

    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $ussdrecommend = $this->model->findOrFail($id);
        
        return $this->response->item($ussdrecommend, new UssdRecommendTransformer());

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
        
        $ussdrecommend = $this->model->findOrFail($id);
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

        $ussdrecommend->update($request->except('created_at'));

        return $this->response->item($ussdrecommend->fresh(), new UssdRecommendTransformer());

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }


}
