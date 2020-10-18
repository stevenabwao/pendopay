<?php

namespace App\Http\Controllers\Web\Admin\Till;

use App\Entities\Till;
use App\Entities\Product;
use App\Entities\Company;
use App\Entities\Status;
use App\Services\Till\TillIndex;
use App\Services\Till\TillStore;
use App\Services\Till\TillUpdate;
use App\Http\Controllers\Controller;
use App\Services\Till\TillActivate;
use Illuminate\Http\Request;
use Session;

class TillController extends Controller
{

    /**
     */
    protected $model;

    /**
     * TillController constructor.
     *
     * @param Till $model
     */
    public function __construct(Till $model)
    {
        $this->model = $model;

    }

    /**
     *
     * @param Request $request
     * @return mixed
    */
    public function index(Request $request, TillIndex $tillIndex)
    {

        if (isUserHasPermissions("1", ['read-till'])) {

            //get the data
            $data = $tillIndex->getData($request);

            //are we in report mode? return get results
            if ($request->report) {
                $data = $data->get();
            }

            $statuses = Status::where('section', 'LIKE', '%till%')->get();
            $companies = getUserCompanies();

            return view('_admin.tills.index', [
                'tills' => $data,
                'statuses' => $statuses,
                'companies' => $companies
            ]);

        } else {

            abort(503);

        }

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        if (isUserHasPermissions("1", ['create-till'])) {

            $statuses = Status::where('section', 'LIKE', '%till%')->get();
            $companies = getAllUserCompanies($request);

            return view('_admin.tills.create', compact('statuses', 'companies'));

        } else {

            abort(503);

        }

    }

    /**
     * @param $id
     * @return mixed
    */
    public function show($id)
    {
        if (isUserHasPermissions("1", ['read-till'])) {

            $till = $this->model->findOrFail($id);
            // dd($till);

            return view('_admin.tills.show', compact('till'));

        } else {

            abort(503);

        }

    }

    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request, TillStore $tillStore)
    {

        if (isUserHasPermissions("1", ['create-till'])) {

            $rules = [
                'till_number' => 'required',
                'till_name' => 'required',
                'company_id' => 'required',
                'phone_number' => 'required'
            ];

            $payload = app('request')->only('till_number', 'till_name', 'company_id', 'phone_number');

            $validator = app('validator')->make($payload, $rules);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            try {

                //create item
                $createResult = $tillStore->createItem($request->all());
                $createResult = json_decode($createResult);
                $result_message = $createResult->message;
                // dd($result_message);

                if (!$createResult->error) {
                    $createResult_message = $result_message->message;
                    Session::flash('success', $createResult_message);
                    return redirect()->route('admin.tills.index');
                } else {
                    Session::flash('error', $result_message->message);
                    return redirect()->back()->withInput()->withErrors($result_message->message);
                }

            } catch (\Exception $e) {

                log_this($e);
                Session::flash('error', $e->getMessage());
                return redirect()->back()->withInput()->withErrors($e->getMessage());

            }

        } else {

            abort(503);

        }

    }

    // confirm till store
    public function confirmTillStore(Request $request, TillActivate $tillActivate)
    {

        // dd($request);
        if (isUserHasPermissions("1", ['activate-till'])) {

            $rules = [
                'confirm_code' => 'required',
                'phone_number' => 'required'
            ];

            $payload = app('request')->only('confirm_code', 'phone_number');

            $validator = app('validator')->make($payload, $rules);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            try {

                //update item
                $updateResult = $tillActivate->updateItem($request->confirm_code, $request->phone_number);
                $updateResult = json_decode($updateResult);

                $result_message = $updateResult->message;

                if (!$updateResult->error) {
                    $updateResult_message = $result_message->message;
                    Session::flash('success', $updateResult_message);
                    return redirect()->route('admin.tills.index');
                } else {
                    Session::flash('error', $result_message->message);
                    return redirect()->back()->withInput()->withErrors($result_message->message);
                }

            } catch (\Exception $e) {

                log_this($e);
                Session::flash('error', $e->getMessage());
                return redirect()->back()->withInput()->withErrors($e->getMessage());

            }

        } else {

            abort(503);

        }

    }

    /* Show confirm a till form */
    public function confirmTillCreate($id)
    {

        if (isUserHasPermissions("1", ['activate-till'])) {

            $till = $this->model->findOrFail($id);
            $statuses = Status::where('section', 'LIKE', '%till%')->get();
            $companies = getUserCompanies();

            return view('_admin.tills.activate-till-create', compact('statuses', 'companies', 'till'));

        } else {

            abort(503);

        }

    }

    /* Activate a till */
    public function activateTill($activationCode, TillActivate $tillActivate)
    {

        try {

            // update item
            $createResult = $tillActivate->updateItem($activationCode);
            $createResult = json_decode($createResult);
            $result_message = $createResult->message;

            if (!$createResult->error) {
                $createResult_message = $result_message->message;
                Session::flash('success', $createResult_message);
                return redirect()->route('admin.tills.index');
            } else {
                Session::flash('error', $result_message->message);
                return redirect()->back()->withInput()->withErrors($result_message->message);
            }

        } catch (\Exception $e) {

            // dd($e);
            log_this($e);
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput()->withErrors($e->getMessage());

        }

    }

    public function edit($id, Request $request)
    {

        if (isUserHasPermissions("1", ['update-till'])) {

            $till = $this->model->findOrFail($id);
            $statuses = Status::where('section', 'LIKE', '%till%')->get();
            $companies = getAllUserCompanies($request);
            // dd($till);

            return view('_admin.tills.edit', compact('till', 'statuses', 'companies'));

        } else {

            abort(503);

        }

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function update(Request $request, $id, TillUpdate $tillUpdate)
    {

        // dd($request->all());
        if (isUserHasPermissions("1", ['update-till'])) {

            $thisitem = $this->model->findOrFail($id);

            $rules = [
                'till_name' => 'required',
                'till_number' => 'required',
                'phone_number' => 'required',
                'company_id' => 'required',
                /* 'status_id' => 'required' */
            ];

            $payload = app('request')->only('till_name', 'till_number', 'phone_number', 'company_id');
            // $payload = app('request')->only('till_name', 'till_number', 'phone_number', 'company_id', 'status_id');

            $validator = app('validator')->make($payload, $rules);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            // update item
            $updateResult = $tillUpdate->updateItem($id, $request->all());
            $updateResult = json_decode($updateResult);
            $result_message = $updateResult->message;
            // dd($thisitem, $result_message);

            if (!$updateResult->error) {
                $updateResult_message = $result_message->message;
                Session::flash('success', $updateResult_message);
                return redirect()->route('admin.tills.show', $thisitem->id);
            } else {
                Session::flash('error', $result_message->message);
                return redirect()->back()->withInput()->withErrors($result_message->message);
            }

        } else {

            abort(503);

        }

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function destroy(Request $request, $id)
    {


        if (isUserHasPermissions("1", ['delete-till'])) {

            $user_id = auth()->user()->id;

            $item = $this->model->findOrFail($id);

            if ($item) {
                //update deleted by field
                $item->update(['deleted_by' => $user_id]);
                $result = $item->delete();
            }

            return redirect()->route('companyproducts.index');

        } else {

            abort(503);

        }

    }

}
