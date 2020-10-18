<?php

namespace App\Http\Controllers\Api\GlAccount;

use App\Entities\GlAccount;
use App\Http\Controllers\BaseController;
use App\Services\GlAccount\GlAccountIndex;
use App\Services\GlAccount\GlAccountStore;
use App\User;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Session;

class ApiGlAccountController extends BaseController
{
    
   
    /**
     * @var GlAccount
     */
    protected $model;

    /**
     * GlAccountController constructor.
     *
     * @param GlAccount $model
     */
    public function __construct(GlAccount $model)
    {
        $this->model = $model;

    }

    
    public function index(Request $request, GlAccountIndex $glAccountIndex)
    {

        /*start cache settings*/
        $url = request()->url();
        $params = request()->query();
        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration('low'); 
        /*end cache settings*/

        //get the data
        $data = $glAccountIndex->getGlAccounts($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new GLAccountTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new GlAccountTransformer());

        }

        //return api data
        return Cache::remember($fullUrl, $minutes, function () use ($data) {
            return $data;
        });

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, GlAccountStore $glAccountStore)
    {
        
        $rules = [
            'account_type_id' => 'required',
            'company_id' => 'required',
            'description' => 'required',
        ];

        $payload = app('request')->only('account_type_id', 'company_id', 'description');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            //throw new StoreResourceFailedException($validator->errors());
            $message = "An error occured - " . $validator->errors();
            return show_error($message);
        }

        //create item
        $result = $glAccountStore->createItem($request->all());
        $result = json_decode($result);
        //dd($result);

        return show_success($result->message);

    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $glaccount = $this->model->findOrFail($id);

        return $this->response->item($glaccount, new GlAccountTransformer());

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $glaccount = $this->model->findOrFail($id);

        $rules = [
            'gl_account_no' => 'required',
            'description' => 'required',
        ];

        $payload = app('request')->only('gl_account_no', 'description');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        // update data fields
        $this->model->updatedata($id, $request->all());

        return $this->response->item($glaccount->fresh(), new GlAccountTransformer());

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = auth()->user()->id;

        $item = $this->model->findOrFail($id);
        
        if ($item) {
            //update deleted by field
            $item->update(['deleted_by' => $user_id]);
            $result = $item->delete();
        }

        return $this->response->noContent();
    }

}
