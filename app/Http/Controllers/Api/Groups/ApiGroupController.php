<?php

namespace App\Http\Controllers\Api\Groups;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Entities\Group;
use App\User;
use App\Entities\Company;
use Session;

class ApiGroupController extends BaseController
{
    
    /**
     * @var state
     */
    protected $model;

    /**
     * LoanApplicationController constructor.
     *
     * @param LoanApplication $model
     */
    public function __construct(Group $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = auth()->user();

        //get data
        if ($user->hasRole('superadministrator')){
            //get data
            $groups = $this->model;
        } else if ($user->hasRole('administrator')){
            //get user company 
            $user_company_id = $user->company->id;
            $groups = $this->model->where('company_id', $user_company_id);
        }

        //filter request
        $id = $request->id;
        $report = $request->report;
        $company_id = $request->company_id;        
        
        //filter results
        if ($id) { 
            $groups = $groups->where('id', $id); 
        }
        if ($company_id) { 
            $groups = $groups->where('company_id', $company_id); 
        }
        
        $groups = $groups->orderBy('company_id', 'desc');

        if (!$report) {
            $groups = $groups->paginate($request->get('limit', config('app.pagination_limit')));
            $data = $this->response->paginator($groups, new GroupTransformer());
        } else {
            $groups = $groups->get();
            $data = $this->response->collection($groups, new GroupTransformer());
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
            'name' => 'required|max:255',
            'phone_number' => 'sometimes|max:13',
            'company_id' => 'required'
        ];

        $payload = app('request')->only('phone', 'company_id', 'message');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        //create item
        $group = $this->model->create($request->all());

        return ['message' => 'Group successfully created'];

    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $group = $this->model->findOrFail($id);
        return $this->response->item($group, new GroupTransformer());

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $group = $this->model->findOrFail($id);
        $rules = [
            'name' => 'required|max:255',
            'phone_number' => 'sometimes|max:13',
            'company_id' => 'required'
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'name' => 'required|max:255',
                'phone_number' => 'sometimes|max:13',
                'company_id' => 'required'
            ];
        }

        $payload = app('request')->only('name', 'phone_number', 'company_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        $group->update($request->except('created_at'));

        return $this->response->item($group->fresh(), new GroupTransformer());

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
