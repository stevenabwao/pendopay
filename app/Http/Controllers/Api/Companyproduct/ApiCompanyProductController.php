<?php

namespace App\Http\Controllers\Api\CompanyProduct;

use App\Entities\CompanyProduct;
use App\Http\Controllers\BaseController;
use App\Services\CompanyProduct\CompanyProductIndex;
use App\Transformers\CompanyProduct\CompanyProductTransformer;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Session;

class ApiCompanyProductController extends BaseController
{
    
    /**
     * @var CompanyProduct
     */
    protected $model;

    /**
     * CompanyController constructor.
     *
     * @param CompanyProduct $model
     */
    public function __construct(CompanyProduct $model)
    {
        $this->model = $model; 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CompanyProductIndex $companyProductIndex)
    {

        ////////////////////
        /* $result_array = array();

        //start get data
        $url = "http://41.215.126.10/snb/api/companyproducts?companies=55";
        $access_token = "";
		$params = [
			'json' => []
		];
        $result = sendAuthGetApi($url, $access_token, $params);
        //dd($result);
        $result_decode = json_decode($result);
        $result_decode_data = $result_decode->data;
        foreach ($result_decode_data as $item){

            //get product data
            $product_data = $item->product->data;
            //dd($item, $product_data);

            $company = array();

            $company["id"] = $item->id;
            $company["product_id"] = $item->product_id;
            $company["name"] = $item->name;
            $company["product_name"] = $product_data->name;
            $company["product_cd"] = $product_data->product_cd;
            
            //add to result array
            array_push($result_array, $company);

        }
        dd($result_array); */

        //////////////////////



        //get the data
        //dd($request->all());
        $data = $companyProductIndex->getData($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new CompanyProductTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new CompanyProductTransformer());

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

            $data = $this->response->paginator($data, new CompanyProductTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new CompanyProductTransformer());

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
        $item = $this->model->findOrFail($id);

        return $this->response->item($item, new CompanyProductTransformer());
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

        return ['message' => 'CompanyProduct created.'];

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

        $company = CompanyProduct::findOrFail($id);

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

        return $this->response->item($item->fresh(), new CompanyProductTransformer());

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
