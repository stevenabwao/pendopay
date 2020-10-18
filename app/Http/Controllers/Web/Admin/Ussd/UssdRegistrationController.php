<?php

namespace App\Http\Controllers\Web\Ussd;

use App\Company;
use App\Group;
use App\Http\Controllers\Controller;
use App\User;
use App\UssdRegistration;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;

class UssdRegistrationController extends Controller
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
    public function __construct(UssdRegistration $model)
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
            $ussdregistrations = new UssdRegistration();

        } else if ($user->hasRole('administrator')){
            
            //get user company 
            $user_company_id = $user->company->id;

            //get paybills accounts for showing in dropdown
            $ussdregistrations = UssdRegistration::where('company_id', $user_company_id);

        }

        //filter request
        $id = $request->id;
        $report = $request->report;
        $phone_number = $request->phone_number;
        $account_name = $request->account_name;
        $start_date = $request->start_date;
        $lipanampesa_code = $request->lipanampesa_code;
        if ($start_date) { $start_date = Carbon::parse($request->start_date); }
        $end_date = $request->end_date;
        if ($end_date) { $end_date = Carbon::parse($request->end_date); }
        
        //filter results
        if ($id) { 
            $ussdregistrations = $ussdregistrations->where('id', $id); 
        }
        if ($phone_number) { 
            //format the phone number
            $phone_number = formatPhoneNumber($phone_number);
            $ussdregistrations = $ussdregistrations->where('mobile', $phone_number); 
        }
        if ($lipanampesa_code) { 
            $ussdregistrations = $ussdregistrations->whereIn('lipanampesacode', $lipanampesa_code); 
        }
        if ($account_name) { 
            $ussdregistrations = $ussdregistrations->where('name', $account_name); 
        }
        if ($start_date) { 
            $ussdregistrations = $ussdregistrations->where('created_at', '>=', $start_date); 
        }
        if ($end_date) { 
            $ussdregistrations = $ussdregistrations->where('created_at', '<=', $end_date); 
        }

        $ussdregistrations = $ussdregistrations->orderBy('created_at', 'desc');

        if (!$report) {
            $ussdregistrations = $ussdregistrations->paginate($request->get('limit', config('app.pagination_limit')));

        } else {
        
            $ussdregistrations = $ussdregistrations->get();

        }
        //end filter request

        //return view with appended url params 
        return view('ussd.ussd-registration.index', [
            'ussdregistrations' => $ussdregistrations->appends(Input::except('page'))
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('ussd-registration.create');

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
    
        //get details for this mpesaincoming
        $request['id'] = $id;

        //get details for this ussd reg
        $ussdregistration = UssdRegistration::find($id);
        
        return view('ussd.ussd-registration.show', compact('ussdregistration'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
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
        
        return view('ussd-registration.edit')->withGroup($group)->withCompanies($companies);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $user_id = auth()->user()->id;

        $this->validate($request, [
            'name' => 'required|max:255',
            'phone_number' => 'required|max:255',
            'company_id' => 'required|max:255'
        ]);

        $group = Group::findOrFail($id);
        $group->name = $request->name;
        $group->company_id = $request->company_id;
        $group->phone_number = $request->phone_number;
        $group->email = $request->email;
        $group->physical_address = $request->physical_address;
        $group->box = $request->box;
        $group->updated_by = $user_id;
        $group->save();

        Session::flash('success', 'Successfully updated group - ' . $group->name);
        return redirect()->route('ussd-registration.show', $group->id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
