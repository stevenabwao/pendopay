<?php

namespace App\Http\Controllers\Api\MpesaC2B;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Services\MpesaC2B\StkPushStore;
use Carbon\Carbon;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Response\paginator;
use Illuminate\Database\Eloquent\paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiMpesaC2BController extends BaseController
{

    protected $model;

    /**
     * DepositsController constructor.
     *
     * @param MpesaB2C $model
     */
    /* public function __construct(MpesaB2C $model)
    {
        $this->model = $model;

    } */

    public function checkout(Request $request, StkPushStore $stkPushStore)
    {

        // dd("hapa == ", $request->all());

        $rules = [
            'amount' => 'required',
            'paybill' => 'required',
            'phone' => 'required'
        ];

        $payload = app('request')->only('amount', 'paybill', 'phone');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            log_this("************** FAILED STKPUSH VALIDATION **************");
            throw new StoreResourceFailedException($validator->errors());
        }

        $data = $stkPushStore->save($request);

        $resp_message = 'Mpesac2b created';
                
        return show_success($resp_message);

    }


}
