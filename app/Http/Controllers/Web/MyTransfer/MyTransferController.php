<?php

namespace App\Http\Controllers\Web\MyTransfer;

use App\Entities\Transfer;
use App\Entities\Status;
use App\Http\Controllers\Controller;
use App\Services\MyTransfer\MyTransferIndex;
use App\Services\MyTransfer\MyTransferStore;
use App\Services\MyTransfer\MyTransferStoreStepThree;
use App\Services\MyTransfer\MyTransferStoreStepTwo;
use App\User;
use Illuminate\Http\Request;
use Session;

class MyTransferController extends Controller
{

    /**
     */
    protected $model;

    /**
     * constructor.
     *
     * @param Transfer $model
     */
    public function __construct(Transfer $model)
    {
        $this->model = $model;
    }

    /**
     *
     * @param Request $request
     * @return mixed
    */
    public function index(Request $request, MyTransferIndex $myTransferIndex)
    {

        // get trans data
        $data = $myTransferIndex->getData($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }

        $statuses = Status::where("section", "LIKE", "%trans%")->get();

        return view('_web.my-transfers.index', [
            'transfers' => $data,
            'statuses' => $statuses
        ]);

    }

    public function show($id)
    {

        // get logged user
        // $logged_user_id = getLoggedUser()->id;

        // get statuses array
        /* $status_ids_array = [];
        $status_ids_array[] = getStatusPending();
        $status_ids_array[] = getStatusActive();
        $status_ids_array[] = getStatusCompleted();
        $status_ids_array[] = getStatusCancelled();
        $status_ids_array[] = getStatusExpired(); */
        // dd("status_ids_array === ", $status_ids_array);

        // get records where user is seller or buyer
        $transfer = $this->model->where('id', $id)
                       // ->whereIn('status_id', $status_ids_array)
                       ->firstOrFail();

        return view('_web.my-transfers.show', compact('transfer'));

    }

}
