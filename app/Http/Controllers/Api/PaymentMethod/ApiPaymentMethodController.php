<?php

namespace App\Http\Controllers\Api\PaymentMethod;

use App\Http\Controllers\BaseController;
use App\Transformers\PaymentMethod\PaymentMethodTransformer;
use App\Services\PaymentMethod\PaymentMethodIndex;
use App\Entities\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class ApiPaymentMethodController extends BaseController
{

    /**
     * @var PaymentMethod
     */
    protected $model;

    /**
     * Controller constructor.
     *
     * @param PaymentMethod $model
     */
    public function __construct(PaymentMethod $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PaymentMethodIndex $paymentIndex)
    {

        // get the data
        // DB::enableQueryLog();

        $data = $paymentIndex->getData($request);

        // dd(DB::getQueryLog());
        // dd($data);

        //are we in report mode?
        if (!$request->report) {

            $data = $this->response->paginator($data, new PaymentMethodTransformer());

        } else {

            $data = $data->get();
            $data = $this->response->collection($data, new PaymentMethodTransformer());

        }

        return $data;

    }


    /**
     * Display the specified resource.
     */

    public function show($id)
    {

        $paymentMethod = $this->model->findOrFail($id);

        return $this->response->item($paymentMethod, new PaymentMethodTransformer());

    }

}
