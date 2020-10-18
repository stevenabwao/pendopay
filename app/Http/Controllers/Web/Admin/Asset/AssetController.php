<?php

namespace App\Http\Controllers\Web\Asset;

use App\Entities\Company;
use App\Entities\Asset;
use App\Entities\AssetType;
use App\Entities\UssdEventMap;
use App\Entities\Status;
use App\Http\Controllers\Controller;
use App\Services\Asset\AssetIndex;
use App\Services\Asset\AssetStore;
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Session;

class AssetController extends Controller
{

    /**
     * @var state
     */
    protected $model;

    /**
     * AssetController constructor.
     *
     * @param Asset $model
     */
    public function __construct(Asset $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AssetIndex $assetIndex)
    {

        //get the data
        $companies = getAllUserCompanies($request);

        $data = $assetIndex->getData($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }

        return view('manage.assets.index', [
            'assets' => $data->appends(Input::except('page')),
            'companies' => $companies
        ]);

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {


        //get the data
        $companies = getUserCompanies($request);
        $company_ids = extractUserCompanyIdsArray($companies);
        //DB::enableQueryLog();
        $ussdeventmaps = UssdEventMap::whereIn('company_id', $company_ids)
                        ->with('ussdevent')
                        ->get();
        //print_r(DB::getQueryLog());
        //dd('here');
        $assettypes = AssetType::all();
        //$statuses = Status::all();
        //dd($ussdeventmaps, $assettypes);

        return view('manage.assets.create', [
            'companies' => $companies,
            'ussdeventmaps' => $ussdeventmaps,
            'assettypes' => $assettypes
            //'statuses' => $statuses
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, AssetStore $assetStore)
    {

        $rules = [
            'name' => 'required',
            'asset_url' => 'required',
            'company_id' => 'required',
            'asset_type_id' => 'required'
        ];

        $payload = app('request')->only('name', 'asset_url', 'company_id', 'asset_type_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //create item
        $asset = $assetStore->createItem($request->all());

        Session::flash('success', 'Asset successfully created');

        return redirect()->back();

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = auth()->user();

        //if user is superadmin, proceed, else, abort
        if ($user->hasRole('superadministrator')){

            $account = $this->model->find($id);
            $products = Product::where('product_cat_ty', 'DP')->get();
            $companies = Company::all();
            $statuses = Status::all();

            return view('accounts.deposit-accounts.savings.edit', compact('account', 'companies', 'products', 'statuses'));

        } else {

            abort(404);

        }

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

        $user = auth()->user();

        //if user is superadmin, proceed, else, abort
        if ($user->hasRole('superadministrator')){

            $account = $this->model->find($id);

            $rules = [
                'account_name' => 'required',
                'company_id' => 'required',
                'product_id' => 'required',
                'account_no' => 'required|unique:accounts,account_no,'.$account->id,
            ];

            $payload = app('request')->only('account_no', 'account_name', 'company_id', 'product_id');

            $validator = app('validator')->make($payload, $rules);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            // update fields
            $this->model->updatedata($id, $request->all());

            Session::flash('success', 'Successfully updated user savings account - ' . $account->account_no);
            //show updated record
            return redirect()->route('user-savings-accounts.show', $account->id);

        } else {

            abort(404);

        }




    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        //get details for this item
        $account = $this->model->find($id);

        return view('accounts.gl-accounts.gl-accounts-history.show', [
            'glaccounthistory' => $account
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user_id = auth()->user()->id;

        $item = $this->model->findOrFail($id);

        if ($item) {
            //update deleted by field
            $item->update(['deleted_by' => $user_id]);
            $result = $item->delete();
        }

        return redirect()->route('loan-applications.index');
    }

}
