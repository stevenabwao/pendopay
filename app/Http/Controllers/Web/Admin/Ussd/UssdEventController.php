<?php

namespace App\Http\Controllers\Web\Ussd;

use App\Company;
use App\Group;
use App\Http\Controllers\Controller;
use App\User;
use App\UssdEvent;
use App\UssdPayment;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;

class UssdEventController extends Controller
{
    
    /**
     * @var state
     */
    protected $model;

    /**
     * DepositsController constructor.
     *
     * @param Deposit $model
     */
    public function __construct(UssdEvent $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        //get logged in user
        $user = auth()->user();
        
        //get data
        if ($user->hasRole('superadministrator')){

            //get data
            $ussdevents = new UssdEvent();

        } else if ($user->hasRole('administrator')){
            
            //get user company 
            $user_company_id = $user->company->id;

            $ussdevents = UssdEvent::where('company_id', $user_company_id);

        }

        //filter request
        $id = $request->id;
        $report = $request->report;
        $company_id = $request->company_id;
        $status_id = $request->status_id;
        $start_date = $request->start_date;
        if ($start_date) { $start_date = Carbon::parse($request->start_date); }
        $end_date = $request->end_date;
        if ($end_date) { $end_date = Carbon::parse($request->end_date); }
        
        //filter results
        if ($id) { 
            $ussdevents = $ussdevents->where('id', $id); 
        }
        if ($status_id) { 
            $ussdevents = $ussdevents->where('status_id', $status_id); 
        }
        if ($company_id) { 
            $ussdevents = $ussdevents->where('company_id', $company_id); 
        }
        if ($start_date) { 
            $ussdevents = $ussdevents->where('created_at', '>=', $start_date); 
        }
        if ($end_date) { 
            $ussdevents = $ussdevents->where('created_at', '<=', $end_date); 
        }

        $ussdevents = $ussdevents->orderBy('created_at', 'desc');

        if (!$report) {
            $ussdevents = $ussdevents->paginate($request->get('limit', config('app.pagination_limit')));

        } else {
        
            $ussdevents = $ussdevents->get();

        }
        //end filter request

        //return view with appended url params 
        return view('ussd.ussd-events.index', [
            'ussdevents' => $ussdevents->appends(Input::except('page'))
        ]);

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //get logged in user
        $user = auth()->user();

        $userCompany = User::where('id', $user->id)
            ->with('company')
            ->first();

        //if user is superadmin, show all companies, else show a user's companies
        $companies = [];
        $company_ids = [];
        if ($user->hasRole('superadministrator')) {
            $company_ids = Company::all()->pluck('id');
            $companies = Company::all();
        } else if ($user->hasRole('administrator')) {
            if ($user->company) {
                $company_ids[] = $user->company->id;
                $companies[] = $user->company;
            }
        }

        return view('ussd.ussd-events.create')
               ->withCompanies($companies);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 

        $this->validate($request, [
            'name' => 'required',
            'company_id' => 'required',
            'amount' => 'required|numeric'
        ]);

        //create item
        $ussdevent = $this->model->create($request->all());

        Session::flash('success', 'USSD event successfully created');
        
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

        $ussdevent = UssdEvent::where('id', $id)->first();

        //dd($ussdevent);

        $user = auth()->user();
        //if user is superadmin, show all companies, else show a user's companies
        if ($user->hasRole('superadministrator')){
            $companies = Company::all();
        } else {
            $companies = $user->company;
        }
        
        //return view with appended url params 
        /*return view('ussd.ussd-events.edit', [
            'ussdevent' => $ussdevent,
            'companies' => $companies
        ]);*/

        return view('ussd.ussd-events.edit', compact('ussdevent', 'companies'));

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
        
        $this->validate($request, [
            'name' => 'required',
            'company_id' => 'required',
            'amount' => 'required|numeric'
        ]);

        $start_at = Carbon::parse($request->start_at);

        $end_at = Carbon::parse($request->end_at);
        $end_at = $end_at->addDay();
        $end_at = $end_at->subMinute();

        $ussdevent = UssdEvent::findOrFail($id);
            $ussdevent->name = $request->name;
            $ussdevent->company_id = $request->company_id;
            $ussdevent->amount = $request->amount;
            $ussdevent->description = $request->description;
            $ussdevent->start_at = $start_at;
            $ussdevent->end_at = $end_at;
        $ussdevent->save();

        Session::flash('success', 'Successfully updated USSD event - ' . $ussdevent->name);
        //show updated record
        return redirect()->route('ussd-events.show', $ussdevent->id);

    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        //get details for this ussd reg
        $ussdevent = UssdEvent::find($id);
        
        return view('ussd.ussd-events.show', compact('ussdevent'));

    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
