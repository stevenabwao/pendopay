<?php

namespace App\Http\Controllers\Web\Manage\Setting;

use App\Entities\LoanProductSetting;
use App\Entities\Company;
use App\Entities\Product;
use App\Entities\Status;
use App\Entities\Term;
use App\Entities\LoanLimitCalculation;
use App\Events\LoanProductSettingUpdated;
use App\Services\Setting\LoanSetting\LoanSettingIndex;
use App\Services\Setting\LoanSetting\LoanSettingStore;
use App\Services\Setting\LoanSetting\LoanSettingUpdate;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;

class LoanSettingController extends Controller
{
    
    /**
     * @var state
     */
    protected $model;

    /**
     * LoanSettingController constructor.
     *
     * @param LoanProductSetting $model
     */
    public function __construct(LoanProductSetting $model)
    {
        $this->model = $model;

    }

    /**
     *
     * @param Request $request
     * @return mixed
    */
    public function index(Request $request, LoanSettingIndex $loanSettingIndex)
    {

        //get the data
        $data = $loanSettingIndex->getData($request);

        //are we in report mode? return get results
        if ($request->report) {
            $data = $data->get(); 
        }
        //dd($data);

        return view('manage.settings.loansettings.index', [
            'loansettings' => $data->appends(Input::except('page'))
        ]);

    } 


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $statuses = Status::all();

        return view('manage.settings.loansettings.create', compact('statuses'));

    }

    /**
     * @param $id
     * @return mixed
    */
    public function show($id)
    {
        $loansetting = $this->model->findOrFail($id);
        //dd($loansetting);
        $terms = Term::all();
        $loanlimitcalculations = LoanLimitCalculation::where('status_id', '1')->get();
        
        return view('manage.settings.loansettings.show', compact('loansetting', 'terms', 'loanlimitcalculations'));

    }

    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request)
    {

        $rules = [
            'product_cd' => 'required',
            'product_cat_ty' => 'required',
            'start_at' => 'required',
            'name' => 'required'
        ];

        $payload = app('request')->only('product_cd', 'product_cat_ty', 'start_at', 'name');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //create item
        $product = $this->model->create($request->all());

        Session::flash('success', 'Successfully created loan setting - ' . $product->name);
        return redirect()->route('loansettings.index');

    }

    public function edit($id)
    {
        
        $loansetting = $this->model->findOrFail($id);
        //dd($loansetting);
        $statuses = Status::all();
        $companies = Company::where('status_id', '1')->get();
        $terms = Term::all();
        $loanlimitcalculations = LoanLimitCalculation::where('status_id', '1')->get();

        return view('manage.settings.loansettings.edit', compact('loansetting', 'statuses', 'companies', 'terms', 'loanlimitcalculations'));

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function update(Request $request, $id, LoanSettingUpdate $loanSettingUpdate)
    {
        
        $loansetting = $this->model->findOrFail($id);

        //dd($loansetting);

        $rules = [
            'loan_product_status' => 'required',
            'interest_type' => 'required',
            'interest_method' => 'required', 
            'id' => 'required',
            'interest_amount' => 'required',
            'loan_instalment_period' => 'required',
            'loan_instalment_cycle' => 'required',
            'initial_exposure_limit' => 'required',
            'increase_exposure_limit' => 'required',
            'decrease_exposure_limit' => 'required',
            'loan_limit_calculation_id' => 'required',
            'minimum_contributions' => 'required_with:minimum_contributions_condition_id',
            'minimum_contributions_condition_id' => 'required_with:minimum_contributions'
        ];

        $payload = app('request')->only('loan_product_status', 'interest_type', 'interest_method', 'id', 
        'interest_amount', 'loan_instalment_period', 'loan_instalment_cycle',
        'initial_exposure_limit', 'increase_exposure_limit', 'decrease_exposure_limit', 
        'loan_limit_calculation_id', 'minimum_contributions', 'minimum_contributions_condition_id');
        //dd($loansetting, $request->all());

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        // update fields
        $loanSettingUpdate->updateItem($id, $request->all());
        //$this->model->updatedata($id, $request->all());

        //start execute event
        $loansetting_updated = $this->model->findOrFail($id);
        event(new LoanProductSettingUpdated($loansetting_updated));
        //end execute event

        Session::flash('success', 'Successfully updated loan settings- ' . $loansetting->companyproduct->product->name);
        return redirect()->route('loansettings.show', $loansetting->id);

    }


}