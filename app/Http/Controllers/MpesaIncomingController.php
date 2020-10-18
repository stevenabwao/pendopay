<?php

namespace App\Http\Controllers;

use App\Entities\Company;
use App\Entities\Group;
use App\Entities\MpesaIncoming;
use App\Entities\MpesaPaybill;
use App\User;
use Carbon\Carbon;
use Excel;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Session;

class MpesaIncomingController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) 
    {

        //get logged in user
        $user = auth()->user();

        if (isUserHasPermissions("1", ['read-mpesaincoming'])) {

            //get paybills data sent via url
            $paybills = $request['paybills'];
            $paybills_array = [];

            if ($paybills) { 
                //$paybills_array[] = explode(",", $paybills); 
                //trim all whitespaces in array values
                $paybills_array = array_map('trim', explode(',', $paybills)); 
            }
            
            //get account paybills
            if ($user->hasRole('superadministrator')){
                
                //paybills used to fetch remote data
                if (!count($paybills_array)) {
                    //get all paybills
                    $paybills_array = MpesaPaybill::pluck('paybill_number')
                            ->toArray();
                }

                //get paybills accounts for showing in dropdown
                $mpesapaybills = MpesaPaybill::all();

            } else {
                
                //get user company 
                $user_company_id = $user->company->id;
                //dd($user_company_id);

                //paybills used to fetch remote data
                if (!count($paybills_array)) {
                    $paybills_array = MpesaPaybill::where('company_id', $user_company_id)
                            ->pluck('paybill_number')
                            ->toArray();
                }
                //dd($paybills_array);

                //get paybills accounts for showing in dropdown
                $mpesapaybills = MpesaPaybill::where('company_id', $user_company_id)
                            ->get();

            }
            //dd($user, $paybills_array);

            //if records exist
            if (count($paybills_array)) {
                $paybills = implode(',', $paybills_array);
                $request['paybills'] = $paybills;
                
                //get user transactions from paybills
                //dd($request);
                $mpesaincoming_data = getMpesaPayments($request);

                if ($mpesaincoming_data) {
                    
                    $mpesaincoming_data = json_decode($mpesaincoming_data);
                    //dd($mpesaincoming_data);

                    $mpesaincoming = $mpesaincoming_data->data;
                    $paginator_data = $mpesaincoming_data->meta->pagination;
                    
                    $total = $paginator_data->total;
                    $page = $paginator_data->current_page;
                    $perPage = $paginator_data->per_page;
                    $count = $paginator_data->count;

                } else {

                    $mpesaincoming = [];
                    $total = "";
                    $perPage = 20; 
                    $page = 1;

                }
                
            } else {
                
                $mpesaincoming = [];
                $total = "";
                $perPage = 20; 
                $page = 1;

            }

            //paginate incoming results
            $mpesaincoming = new LengthAwarePaginator(
                    $mpesaincoming,
                    $total, 
                    $perPage, 
                    $page, 
                    ['path'=>url('mpesa-incoming')]
                );

            //return view with appended url params 
            return view('mpesa-incoming.index', [
                'mpesaincoming' => $mpesaincoming->appends(Input::except('page')),
                'mpesapaybills' => $mpesapaybills
            ]);

        } else {

            abort(404);

        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('mpesa-incoming.create');

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
    public function show($id, Request $request)
    {
    
        if (isUserHasPermissions("1", ['read-mpesaincoming'])) {

            //get details for this mpesaincoming
            $request['id'] = $id;
            $mpesaincoming = getMpesaPayments($request);
            //get first item from array
            $mpesaincoming = $mpesaincoming->data[0]; 
            //dd($mpesaincoming);
            
            return view('mpesa-incoming.show', compact('mpesaincoming'));

        } else {

            abort(404);

        }

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
        
        return view('mpesa-incoming.edit')->withGroup($group)->withCompanies($companies);

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
        return redirect()->route('mpesa-incoming.show', $group->id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
