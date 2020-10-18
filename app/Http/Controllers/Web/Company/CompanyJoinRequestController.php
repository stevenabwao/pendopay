<?php

namespace App\Http\Controllers\Web\Company;

use App\Entities\Company;
use App\Entities\CompanyJoinRequest;
use App\Entities\Status;
use App\Http\Controllers\Controller;
use App\Services\Company\CompanyJoinRequestIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;

class CompanyJoinRequestController extends Controller
{
    
    /**
     * @var CompanyJoinRequest
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

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get(); 

        }

        return view('company-join-requests.index', [
            'companyjoinrequests' => $data->appends(Input::except('page'))
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $statuses = Status::all();

        return view('company-join-requests.create', compact('statuses'));

    }

    /**
     * @param $id
     * @return mixed
    */
    public function show($id)
    {
        $companyjoinrequest = $this->model->findOrFail($id); 

        return view('company-join-requests.show', compact('companyjoinrequest'));
    }

    
    /**
     * Show the form for processing new join request.
     */
    public function showProcessJoinRequest($id)
    {
        $statuses = Status::all();
        //get company join request
        $companyjoinrequest = $this->model->findOrFail($id); 
        //dd($companyjoinrequest);

        return view('company-join-requests.process', compact('statuses', 'companyjoinrequest'));

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function processJoinRequest(Request $request)
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
