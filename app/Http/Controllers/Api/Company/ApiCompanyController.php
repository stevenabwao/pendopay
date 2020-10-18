<?php

namespace App\Http\Controllers\Api\Company;

use App\Entities\Company;
use App\Entities\CompanyJoinRequest;
use App\Http\Controllers\BaseController;
use App\Services\Company\CompanyIndex;
use App\Transformers\Company\CompanyTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Session;

class ApiCompanyController extends BaseController
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
    public function __construct(Company $model)
    {
        $this->model = $model; 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CompanyIndex $companyIndex)
    {

        //get the data
        $data = $companyIndex->getCompanies($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new CompanyTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new CompanyTransformer());

        }

        return $data;

    }

    /**
     * Display a listing of the resource by auth user.
     *
     * @return \Illuminate\Http\Response
     */
    //public function authUserCompanies(Request $request, CompanyIndex $companyIndex)
    public function authUserCompanies(Request $request, CompanyIndex $companyIndex)
    {

        //get the data
        $data = $companyIndex->getCompanies($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new CompanyTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new CompanyTransformer());

        }

        return $data;

    }

    //start user sends request to gain company membership
    public function sendJoinRequest($company_id) {
                  
      $user_id = auth()->user()->id;
      //create new company join request
      $attributes['user_id'] = $user_id;
      $attributes['company_id'] = $company_id;

      $company_join_request = CompanyJoinRequest::create($attributes);
      
      return $company_join_request;

    }
    //end user sends request to gain company membership

    //start get user company membership status
    public function userCompanyStatus($company_id) {
        
        //start get whether user is signed up to this company/ sacco or not
        if (auth()->user()) {
          $item['user_signed'] = false;
          $user_id = auth()->user()->id;
          //is user signed up to company?
          $user_signed_company = $this->model
                            ->join('company_user', 'companies.id','=','company_user.company_id')
                            ->join('users','users.id','=','company_user.user_id')
                            ->where('users.id', $user_id)
                            ->where('companies.id', $company_id)
                            ->first();
          if ($user_signed_company) {
            $item['user_signed'] = true;
          } else {
            $item['user_signed'] = false;
          }
        } else {
          $item['user_signed'] = false;
        }
        //end get whether user is signed up to this company/ sacco or not

        //start check whether user has created a company join request
        $item['user_join_request'] = false;
        if (auth()->user()) {
          $user_id = auth()->user()->id;
          //has user sent join request to company?
          $user_company_join_request = $this->model
                            ->join('company_join_requests', 'companies.id','=','company_join_requests.company_id')
                            ->join('users','users.id','=','company_join_requests.user_id')
                            ->where('users.id', $user_id)
                            ->where('companies.id', $company_id)
                            ->first();
          if ($user_company_join_request) {
            $item['user_join_request'] = true;
          } else {
            $item['user_join_request'] = false;
          }
        } else {
          $item['user_join_request'] = false;
        }
        //end check whether user has created a company jon request

        return $this->response->array($item);

    }
    //end get user company membership status

    /**
     * @param $id
     * @return mixed
    */
    public function show($id)
    {
      
        /* $sms_user_name = "steve";
        //getRealSMSData($sms_user_name);

        $company_user_id = 2;
        $company_id  = 55;
        $data = getUserIncompletedLoans($company_user_id, $company_id);
        $incomplete_loans_data = json_decode($data);
        $user_loan_accounts_data = $incomplete_loans_data->user_loan_accounts;
        $total_loans_balance_data = $incomplete_loans_data->total_loans_balance;
        $total_loans_count_data = $incomplete_loans_data->total_loans_count;
        dd($user_loan_accounts_data, $total_loans_balance_data, $total_loans_count_data); */

        $item = $this->model->findOrFail($id);

        return $this->response->item($item, new CompanyTransformer());
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
            'name' => 'unique:companies|required|max:255',
            'phone' => 'required|max:20'
        ];

        $payload = app('request')->only('name', 'phone');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        //create item
        $this->model->create($request->all());

        return ['message' => 'Company created.'];

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

        $company = Company::findOrFail($id);

        $rules = [
            'name' => 'unique:companies|required|max:255',
            'phone' => 'required|max:20'
        ];

        $payload = app('request')->only('name', 'phone');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }
        // update data fields
        $this->model->updatedata($id, $request->all());

        return $this->response->item($item->fresh(), new CompanyTransformer());

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
