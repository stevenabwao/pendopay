<?php

namespace App\Http\Controllers\Web\Admin\GlAccount;

use App\Entities\GlAccount;
use App\Entities\GlAccountType;
use App\Entities\Company;
use App\Entities\Status;
use App\Services\GlAccount\GlAccountIndex;
use App\Services\GlAccount\GlAccountStore;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class GlAccountController extends Controller
{

    /**
     * @var state
     */
    protected $model;

    /**
     * GlAccountController constructor.
     *
     * @param GlAccount $model
     */
    public function __construct(GlAccount $model)
    {
        $this->model = $model;

    }

    /**
     *
     * @param Request $request
     * @return mixed
    */
    public function index(Request $request, GlAccountIndex $glAccountIndex)
    {

        /*start cache settings*/
        $url = request()->url();
        $params = request()->query();
        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration('low');
        /*end cache settings*/

        //get the data
        $data = $glAccountIndex->getGlAccounts($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }

        //dd($data);

        //return cached data or cache if cached data not exists
        //return Cache::remember($fullUrl, $minutes, function () use ($data) {
            return view('_admin.manage.glaccounts.index', [
                'glaccounts' => $data
            ]);
        //});

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $statuses = Status::all();
        $glaccounttypes = GlAccountType::where('status_id', getStatusActive())
                                       ->where('id', '!=', getGlAccountTypeClientDeposits())
                                       ->get();
        $companies = Company::where('status_id', getStatusActive())->get();
        // dd($glaccounttypes);

        return view('_admin.manage.glaccounts.create', compact('statuses', 'glaccounttypes', 'companies'));

    }

    /**
     * @param $id
     * @return mixed
    */
    public function show($id)
    {
        $glaccount = $this->model->findOrFail($id);

        //Log::info('glaccount ', $glAccount->toArray());

        return view('_admin.manage.glaccounts.show', compact('glaccount'));

    }

    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request, GlAccountStore $glAccountStore)
    {

        $rules = [
            'gl_account_type_id' => 'required',
            'description' => 'required',
            'company_id' => 'required'
        ];

        $payload = app('request')->only('gl_account_type_id', 'description', 'company_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //create item
        try {

            $gl_account = $glAccountStore->createItem($request->all());
            $result_json = json_decode($gl_account);

            $message = $result_json->message->message;
            $success_message = $message->message;
            $new_data = $message->data;
            // dd($message);

            Session::flash('success', $success_message);
            return redirect()->route('admin.manage.glaccounts.index');

        } catch(\Exception $e) {
            // dd($e);
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

    }

    public function edit($id)
    {

        $glaccount = $this->model->findOrFail($id);
        $statuses = Status::all();

        return view('_admin.manage.glaccounts.edit', compact('glaccount', 'statuses'));

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function update(Request $request, $id)
    {

        $glAccount = $this->model->findOrFail($id);

        $rules = [
            'glaccount_cd' => 'required',
            'glaccount_cat_ty' => 'required',
            'start_at' => 'required',
            'name' => 'required'
        ];

        $payload = app('request')->only('glaccount_cd', 'glaccount_cat_ty', 'start_at', 'name');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        // update fields
        $this->model->updatedata($id, $request->all());

        Session::flash('success', 'Successfully updated GlAccount - ' . $glAccount->name);
        return redirect()->route('admin.manage.glaccounts.show', $glAccount->id);

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

        return redirect()->route('admin.manage.glaccounts.index');
    }

}
