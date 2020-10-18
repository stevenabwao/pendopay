<?php

namespace App\Http\Controllers\Web\Ussd;

use App\Company;
use App\Group;
use App\Http\Controllers\Controller;
use App\User;
use App\UssdRecommend;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;

class UssdRecommendController extends Controller
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
    public function __construct(UssdRecommend $model)
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
            $ussdrecommends = new UssdRecommend();

        } else if ($user->hasRole('administrator')){
            
            //get user company 
            $user_company_id = $user->company->id;
            $ussdrecommends = UssdRecommend::where('company_id', $user_company_id);

        }

        //filter request
        $id = $request->id;
        $report = $request->report;
        $sender_phone_number = $request->sender_phone_number;
        $receiver_phone_number = $request->receiver_phone_number;
        $company_id = $request->company_id;
        $start_date = $request->start_date;
        if ($start_date) { $start_date = Carbon::parse($request->start_date); }
        $end_date = $request->end_date;
        if ($end_date) { $end_date = Carbon::parse($request->end_date); }
        
        //filter results
        if ($id) { 
            $ussdrecommends = $ussdrecommends->where('id', $id); 
        }
        if ($sender_phone_number) { 
            $ussdrecommends = $ussdrecommends->where('phone', $sender_phone_number); 
        }
        if ($receiver_phone_number) { 
            $ussdrecommends = $ussdrecommends->where('rec_phone', $receiver_phone_number); 
        }
        if ($company_id) { 
            $ussdrecommends = $ussdrecommends->where('company_id', $company_id); 
        }
        if ($start_date) { 
            $ussdrecommends = $ussdrecommends->where('created_at', '>=', $start_date); 
        }
        if ($end_date) { 
            $ussdrecommends = $ussdrecommends->where('created_at', '<=', $end_date); 
        }

        $ussdrecommends = $ussdrecommends->orderBy('created_at', 'desc');

        if (!$report) {
            
            $ussdrecommends = $ussdrecommends->paginate($request->get('limit', config('app.pagination_limit')));

        } else {
        
            $ussdrecommends = $ussdrecommends->get();

        }
        //end filter request

        //return view with appended url params 
        return view('ussd.ussd-recommends.index', [
            'ussdrecommends' => $ussdrecommends->appends(Input::except('page'))
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

        //get details
        $ussdrecommend = UssdRecommend::find($id);
        
        return view('ussd.ussd-recommends.show', compact('ussdrecommend'));

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
