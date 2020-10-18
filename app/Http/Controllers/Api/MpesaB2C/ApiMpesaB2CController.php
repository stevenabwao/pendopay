<?php

namespace App\Http\Controllers\Api\MpesaB2C;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Entities\MpesaB2C;
use App\Services\MpesaB2C\MpesaB2CUpdate;
use Carbon\Carbon;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Response\paginator;
use Illuminate\Database\Eloquent\paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiMpesaB2CController extends BaseController
{

    /**
     * @var MpesaB2C
     */
    protected $model;

    /**
     * DepositsController constructor.
     *
     * @param MpesaB2C $model
     */
    public function __construct(MpesaB2C $model)
    {
        $this->model = $model;

    }


    /**
     * update existing b2c record. 
     */
    public function update(Request $request, MpesaB2CUpdate $mpesaB2CUpdate)
    {

        $user = auth()->user();

        // process data
        if (($user->hasRole('superadministrator')) ||
            ($user->can('create-mpesab2c'))){

            //error check
            $rules = [
                'request_id' => 'required', 
                'orig_con_id' => 'required',
                'trans_status' => 'required',
            ];

            $payload = app('request')->only('request_id', 'orig_con_id', 'trans_status');

            $validator = app('validator')->make($payload, $rules);

            if ($validator->fails()) {
                throw new StoreResourceFailedException($validator->errors());
            }

            //update item
            $mpesab2c_update = $mpesaB2CUpdate->updateItem($request->all());

            //dd($mpesab2c);
            return ['message' => 'Mpesab2c updated'];

        } else {

            throw new StoreResourceFailedException("Error. Cannot perform transaction");

        }

    }

    public function store2(Request $request, LocalDisbursementDataFetch $localDisbursementDataFetch)
    {

        //get logged in user
        $user = auth()->user();

        if (($user->hasRole('superadministrator')) ||
            (($user->can('create-yehu-disbursement-data')) && ($user->company->id=='52'))){

            //get deposit details
            $request->merge(['report' => '1']);
            $request->merge(['sync' => '1']);

            $data = $localDisbursementDataFetch->getData($request);
            $inner_data = $data['message']->data;

            //start insert multiple records
            $disb_records = [];

            // Add needed information
            foreach($inner_data as $disbdata)
            {
                //dump($disbdata['member_nm']);

                if(!empty($disbdata))
                {

                    $date = Carbon::now();

                    try {

                        //format phone number
                        $contact = $disbdata->contact;
                        //$contact = getDatabasePhoneNumber($contact, 'KE');

                        //dd($contact);

                        // Formulate record that will be saved
                        $disb_records[] = [
                            'member_nm' => $disbdata->member_nm,
                            'member_no' => $disbdata->member_no,
                            'social_security_no' => $disbdata->social_security_no,
                            'cr_appl_grp_disbrsmnt_id' => $disbdata->cr_appl_grp_disbrsmnt_id,
                            'cr_appl_member_disbrsmnt_id' => $disbdata->cr_appl_member_disbrsmnt_id,
                            'disbrsmnt_amt' => $disbdata->disbrsmnt_amt,
                            'contact' => $contact,
                            'row_ts' => $disbdata->row_ts,
                            'status_id' => config('constants.status.pending'),
                            'updated_by' => $user->id,
                            'created_by' => $user->id,
                            'updated_at' => $date,
                            'created_at' => $date
                        ];

                    } catch(\Exception $e) {

                        $message = "Error: " . $e->getMessage();
                        Session::flash('error', $message);
                        return redirect()->back()->withInput();

                    }

                }
            }

            // Insert disb records
            YehuDisbursementLocal::insert($disb_records);

            return redirect()->route('yehu-disbursement-data.index');

        } else {
            abort(404);
        }

    }


}
