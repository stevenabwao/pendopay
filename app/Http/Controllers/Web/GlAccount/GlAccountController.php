<?php

namespace App\Http\Controllers\Web\GlAccount;

use App\Entities\GlAccount;
use App\Entities\GlAccountType;
use App\Entities\Company;
use App\Entities\Status;
use App\Entities\CompanyProduct;
use App\Services\GlAccount\GlAccountIndex;
use App\Services\GlAccount\GlAccountStore;
use App\Services\GlAccount\GlAccountUpdate;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
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
            return view('manage.glaccounts.index', [
                'glaccounts' => $data->appends(Input::except('page'))
            ]);
        //});

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $statuses = Status::all();
        $glaccounttypes = GlAccountType::all();
        $company_ids = getUserCompanyIds();
        $companyproducts = CompanyProduct::whereIn("company_id", $company_ids)->get();
        $companies = Company::all();

        return view('manage.glaccounts.create', compact('statuses', 'glaccounttypes', 'companies', 'companyproducts'));

    }

    /**
     * @param $id
     * @return mixed
    */
    public function show($id)
    {
        $glaccount = $this->model->findOrFail($id);

        //Log::info('glaccount ', $glAccount->toArray());

        return view('manage.glaccounts.show', compact('glaccount'));

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
        $gl_account = $glAccountStore->createItem($request->all());
        $result_json = json_decode($gl_account);

        $error = $result_json->error;
        $message = $result_json->message;

        if (!$error){
            //Session::flash('error', $response);
            Session::flash('success', 'Successfully created new GlAccount');
            return redirect()->route('glaccounts.index');
        } else {
            Session::flash('error', $message);
            return redirect()->back()->withInput();
        }

    }

    public function edit($id) 
    {

        $glaccount = GlAccount::findOrFail($id);
        $company_ids = getUserCompanyIds();
        $companyproducts = CompanyProduct::whereIn("company_id", $company_ids)->get();
        $statuses = Status::all();
        $companies = Company::all(); 
        $glaccounttypes = GlAccountType::all();       

        return view('manage.glaccounts.edit', compact('glaccount', 'glaccounttypes', 'statuses', 'companyproducts', 'companies'));

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function update(Request $request, $id, GlAccountUpdate $glAccountUpdate)
    {

        $glAccount = $this->model->findOrFail($id);

        $rules = [
            'description' => 'required',
            'gl_account_type_id' => 'required',
            'company_id' => 'required',
            'company_product_id' => 'required'
        ];

        $payload = app('request')->only('description', 'gl_account_type_id', 'company_id', 'company_product_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //create item
        $gl_account = $glAccountUpdate->updateItem($id, $request->all());
        $result_json = json_decode($gl_account);

        $error = $result_json->error;
        $message = $result_json->message;

        if (!$error){
            //Session::flash('error', $response);
            Session::flash('success', 'Successfully updated GL Account');
            return redirect()->route('glaccounts.show', $glAccount->id);
        } else {
            Session::flash('error', $message);
            return redirect()->back()->withInput();
        }
        
        //return redirect()->route('glaccounts.show', $glAccount->id);        

        // update fields
        /* $this->model->updatedata($id, $request->all());

        Session::flash('success', 'Successfully updated GlAccount - ' . $glAccount->name);
        return redirect()->route('glaccounts.show', $glAccount->id); */

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

        return redirect()->route('glaccounts.index');
    }

}
