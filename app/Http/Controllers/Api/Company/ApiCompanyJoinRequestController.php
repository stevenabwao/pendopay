<?php

namespace App\Http\Controllers\Api\Company;

use App\Entities\Company;
use App\Entities\CompanyJoinRequest;
use App\Http\Controllers\BaseController;
use App\Services\Company\CompanyIndex;
use App\Transformers\Company\CompanyJoinRequestTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Session;

class ApiCompanyJoinRequestController extends BaseController
{
    
    /**
     * @var company
     */
    protected $model;

    /**
     * CompanyController constructor.
     *
     * @param Company $model
     */
    public function __construct(CompanyJoinRequest $model)
    {
        $this->model = $model; 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CompanyJoinRequestIndex $companyJoinRequestIndex)
    {

        //get the data
        $data = $companyJoinRequestIndex->getCompanyJoinRequests($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new CompanyJoinRequestTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new CompanyJoinRequestTransformer());

        }

        return $data;

    }

    /**
     * @param $id
     * @return mixed
    */
    public function show($id)
    {
        $item = $this->model->findOrFail($id);

        return $this->response->item($item, new CompanyJoinRequestTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'company_id' => 'required'
        ];

        $payload = app('request')->only('company_id');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        //create item
        $this->model->create($request->all());

        return ['message' => 'Company Join Request created.'];

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

        $company = $this->model->findOrFail($id);

        $rules = [
            'company_id' => 'required'
        ];

        $payload = app('request')->only('company_id');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }
        // update data fields
        $this->model->updatedata($id, $request->all());

        return $this->response->item($item->fresh(), new CompanyJoinRequestTransformer());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
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
