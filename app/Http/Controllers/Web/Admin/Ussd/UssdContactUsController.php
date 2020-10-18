<?php

namespace App\Http\Controllers\Web\Ussd;

use App\Company;
use App\Http\Controllers\Controller;
use App\User;
use App\UssdContactUs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;

class UssdContactusController extends Controller
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
    public function __construct(UssdContactUs $model)
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
            $ussdcontactus = new UssdContactUs();

        } else if ($user->hasRole('administrator')){
            
            //get user company 
            $user_company_id = $user->company->id;
            $ussdcontactus = UssdContactUs::where('company_id', $user_company_id);

        }

        //filter request
        $id = $request->id;
        $report = $request->report;
        $phone_number = $request->phone_number;
        $company_id = $request->company_id;
        $start_date = $request->start_date;
        if ($start_date) { $start_date = Carbon::parse($request->start_date); }
        $end_date = $request->end_date;
        if ($end_date) { $end_date = Carbon::parse($request->end_date); }
        
        //filter results
        if ($id) { 
            $ussdcontactus = $ussdcontactus->where('id', $id); 
        }
        if ($phone_number) { 
            $ussdcontactus = $ussdcontactus->where('phone', $phone_number); 
        }
        if ($company_id) { 
            $ussdcontactus = $ussdcontactus->where('company_id', $company_id); 
        }
        if ($start_date) { 
            $ussdcontactus = $ussdcontactus->where('created_at', '>=', $start_date); 
        }
        if ($end_date) { 
            $ussdcontactus = $ussdcontactus->where('created_at', '<=', $end_date); 
        }

        $ussdcontactus = $ussdcontactus->orderBy('created_at', 'desc');

        if (!$report) {
            
            $ussdcontactus = $ussdcontactus->paginate($request->get('limit', config('app.pagination_limit')));

        } else {
        
            $ussdcontactus = $ussdcontactus->get();

        }
        //end filter request

        //return view with appended url params 
        return view('ussd.ussd-contactus.index', [
            'ussdcontactus' => $ussdcontactus->appends(Input::except('page'))
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('ussd-contactus.create');

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
        $ussdcontactus = UssdContactUs::find($id);
        
        return view('ussd.ussd-contactus.show', compact('ussdcontactus'));

    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
