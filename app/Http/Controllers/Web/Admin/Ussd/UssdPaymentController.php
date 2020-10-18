<?php

namespace App\Http\Controllers\Web\Ussd;

use App\Company;
use App\Group;
use App\Http\Controllers\Controller;
use App\User;
use App\UssdPayment;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;

class UssdPaymentController extends Controller
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
    public function __construct(UssdPayment $model)
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
            $ussdpayments = new UssdPayment();

        } else if ($user->hasRole('administrator')){
            
            //get user company 
            $user_company_id = $user->company->id;

            $ussdpayments = UssdPayment::select('ussd_payments.*')
                    ->join('ussd_events' , 'ussd_payments.ussd_event_id' ,'=' , 'ussd_events.id')
                    ->where('ussd_events.company_id', $user_company_id);

        }

        //filter request
        $id = $request->id;
        $report = $request->report;
        $phone_number = $request->phone_number;
        $ussd_event_id = $request->ussd_event_id;
        $start_date = $request->start_date;
        if ($start_date) { $start_date = Carbon::parse($request->start_date); }
        $end_date = $request->end_date;
        if ($end_date) { $end_date = Carbon::parse($request->end_date); }
        
        //filter results
        if ($id) { 
            $ussdpayments = $ussdpayments->where('ussd_payments.id', $id); 
        }
        if ($phone_number) { 
            //format the phone number
            $phone_number = formatPhoneNumber($phone_number);
            $ussdpayments = $ussdpayments->where('ussd_payments.phone', $phone_number); 
        }
        if ($ussd_event_id) { 
            $ussdpayments = $ussdpayments->where('ussd_payments.ussd_event_id', $ussd_event_id); 
        }
        if ($start_date) { 
            $ussdpayments = $ussdpayments->where('ussd_payments.created_at', '>=', $start_date); 
        }
        if ($end_date) { 
            $ussdpayments = $ussdpayments->where('ussd_payments.created_at', '<=', $end_date); 
        }

        $ussdpayments = $ussdpayments->orderBy('ussd_payments.created_at', 'desc');

        if (!$report) {
            $ussdpayments = $ussdpayments->paginate($request->get('limit', config('app.pagination_limit')));

        } else {
        
            $ussdpayments = $ussdpayments->get();

        }
        //end filter request

        //return view with appended url params 
        return view('ussd.ussd-payments.index', [
            'ussdpayments' => $ussdpayments->appends(Input::except('page'))
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('ussd-payments.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        //get details for this ussd payment
        $ussdpayment = UssdPayment::find($id);
        
        return view('ussd.ussd-payments.show', compact('ussdpayment'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit($id)
    {
        
        $group = Group::where('id', $id)
                 ->with('company')
                 ->first();

        $user = auth()->user();
        //if user is superadmin, show all companies, else show a user's companies
        if ($user->hasRole('superadministrator')){
            $companies = Company::all();
        } else {
            $companies = $user->company;
        }
        
        return view('ussd-payments.edit')->withGroup($group)->withCompanies($companies);

    }*/

    /**
     * Update the specified resource in storage.
     */
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
