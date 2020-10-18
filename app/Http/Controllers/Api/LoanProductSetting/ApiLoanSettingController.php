<?php

namespace App\Http\Controllers\Api\LoanProductSetting;

use App\Entities\Company;
use App\Entities\DepositAccount;
use App\Entities\Group;
use App\Entities\LoanProductSetting;
use App\Entities\Product;
use App\Entities\CompanyProduct;
use App\Services\LoanProductSetting\LoanProductSettingIndex;
use App\Services\LoanProductSetting\LoanProductSettingStore;
use App\Services\LoanProductSetting\LoanProductSettingShow;
use App\Http\Controllers\BaseController;
use App\Transformers\LoanProductSetting\LoanProductSettingTransformer;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use Illuminate\Support\Facades\DB;

class ApiLoanProductSettingController extends BaseController
{

    /**
     * @var state
     */
    protected $model;

    /**
     * LoanProductSettingController constructor.
     *
     * @param LoanProductSetting $model
     */
    public function __construct(LoanProductSetting $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, LoanProductSettingIndex $loanApplicationIndex)
    {


        DB::enableQueryLog();

        /*start cache settings*/
        $url = request()->url();
        $params = request()->query();
        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration('low');
        /*end cache settings*/

        //get the data
        $data = $loanApplicationIndex->getLoanProductSettings($request);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new LoanProductSettingTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new LoanProductSettingTransformer());

        }

        // dd(DB::getQueryLog());

        //return api data
        /* return Cache::remember($fullUrl, $minutes, function () use ($data) {
            return $data;
        }); */

        return $data;

    }


    /**
     * @param $id
     * @return mixed
    */
    public function show($id)
    {
        $item = $this->model->findOrFail($id);

        return $this->response->item($item, new LoanProductSettingTransformer());
    }


    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request, LoanProductSettingStore $loanApplicationStore)
    {

        $rules = [
            'loan_amt' => 'required',
            'company_id' => 'required',
            'phone' => 'required'
        ];
        $company_product_id = "";

        $payload = app('request')->only('loan_amt', 'company_id', 'phone');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }

        $phone = $request->phone;
        try{
            $phone = getDatabasePhoneNumber($phone);
        } catch (\Exception $e) {
            $message = "Please enter correct phone number as the account no!";
            return show_error($message);
        }

        $company_product_id = getSentLoanProductId($request);

        //get companyuserid
        $account_data = DB::table('users')
            ->join('accounts', 'users.id', '=', 'accounts.user_id')
            ->join('company_user', 'users.id', '=', 'company_user.user_id')
            ->select('company_user.id', 'accounts.account_name')
            ->where('company_user.company_id', $request->company_id)
            ->where('accounts.company_id', $request->company_id)
            ->where('accounts.phone', $phone)
            ->first();
            //dd($account_data);
        $company_user_id = $account_data->id;
        //add to request
        $request->merge(['company_user_id' => $company_user_id, 'company_product_id' => $company_product_id]);

        //dd($request->all());

        //create item
        try{
            $loanapplication = $loanApplicationStore->createItem($request->all());
        } catch (\Exception $e) {
            //dd($e);
            $message = "Error creating loan application";
            return show_error($message);
        }
        //dd($loanapplication);

        $result_json = json_decode($loanapplication);

        //dd($result_json);
        $error = $result_json->error;
        $message = $result_json->message;

        if ($error){
            $response = $message->message;
            //Session::flash('error', $response);
            return show_error($response);
        } else {
            $response = $message->message;
            //generate repayment schedule
            if (!empty($message->repayment_schedule)) {
                $repayment_schedule = $message->repayment_schedule;
                $repay_data = "\n\nRepayment schedule:\n";
                for ($i=0; $i<count($repayment_schedule); $i++){
                    $repay_data .= $repayment_schedule[$i]->date;
                    $repay_data .= "\t\t-\t\t" . $repayment_schedule[$i]->amount . "\n";
                }
                //add message to repayment schedule
                $response .= $repay_data;
            }
            //Session::flash('success', $response); 
            return show_success($response);
        }   
        //dd($response);

        //return ['message' => 'Loan application created.'];

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function update(Request $request, $id, LoanProductSettingApprove $loanApplicationApprove)
    {

        $user_id = auth()->user()->id;
        $request->merge([
            'updated_by' => $user_id
        ]);

        //$item = $this->model->findOrFail($id);

        $rules = [
            'action' => 'required'
        ];

        $payload = app('request')->only('action');
        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new StoreResourceFailedException($validator->errors());
        }
        // update data fields
        $result = $loanApplicationApprove->approveItem($id, $request->all());

        return $result;

    }

    /**
     * request update existing b2c record. == called from pendoadmin
     */
     public function requestUpdate(Request $request, LoanProductSettingUpdate $loanApplicationUpdate)
     {
 
         $user = auth()->user();

         //$company_id = "55";
         //dd(checkIfMpesaBalanceLimitReached($company_id));

         //dd($user); 
 
         // process data
         if (($user->hasRole('superadministrator')) ||
             ($user->hasRole('administrator')) ||
             ($user->can('create-mpesab2c'))){ 
 
             //error check 
             /*
             $rules = [
                 'request_id' => 'required',
                 'orig_con_id' => 'required',
                 'trans_status' => 'required', 
             ];
 
             $payload = app('request')->only('request_id'. 'orig_con_id', 'trans_status');
 
             $validator = app('validator')->make($payload, $rules);
 
             if ($validator->fails()) {
                 throw new StoreResourceFailedException($validator->errors());
             }
             */

            if (($request->request_id) && ($request->trans_status)) {
 
                //dd($request->request_id, $request->trans_status);
                //update item
                try{
                    $result = $loanApplicationUpdate->updateItem($request->all());
                    $result_message = json_decode($result);
                } catch (\Exception $e) {
                    dd($e);
                    log_this($e->getMessage());
                }

                if ($result_message->error) {
                    throw new StoreResourceFailedException($result_message->message->message);
                } else {
                    return show_success($result_message->message);
                }

            } else {

                throw new StoreResourceFailedException("Error. Please enter all required data");

            }
  
         } else {
 
             throw new StoreResourceFailedException("Error. Cannot perform transaction");
 
         }
 
     }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
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
