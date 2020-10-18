<?php

namespace App\Http\Controllers\Web\CompanyBranch;

use App\Entities\Company;
use App\Entities\Country;
use App\Entities\CompanyBranch;
use App\User;
use App\Services\CompanyBranch\CompanyBranchIndex;
use App\Services\CompanyBranch\CompanyBranchStore;
use App\Services\CompanyBranch\CompanyBranchUpdate;
use Dingo\Api\Exception\StoreResourceFailedException;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class CompanyBranchController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *
     * @param Request $request
     * @return mixed
    */
    public function index(Request $request, CompanyBranchIndex $companyBranchIndex)
    {

        //get the data
        $data = $companyBranchIndex->getData($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }

        //dd($data);

        return view('companybranches.index', [
            'companybranches' => $data->appends(Input::except('page'))
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth_user = auth()->user();

        $countries = Country::all();
        $companies = getUserCompanies();
        $company_ids = getUserCompanyIds();
        //dd($companies);

        //DB::enableQueryLog();

        //get branch managers in company
        $users = DB::table('users')
                    ->join('role_user', 'role_user.user_id', '=', 'users.id')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->select('users.*')
                    ->where('roles.name', 'branchmanager')
                    ->whereIn('users.company_id', $company_ids)
                    ->get();

        //print_r(DB::getQueryLog());
        //dd("here"); 

        return view('companybranches.create', compact('countries', 'companies', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CompanyBranchStore $companyBranchStore)
    {

        //dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'phone_country' => 'required_with:phone',
            'phone' => 'required|phone', 
        ]);
 
        //dd($request->all());

        //create item
        $companybranch = $companyBranchStore->createItem($request->all());
        $companybranch = json_decode($companybranch);
        $result_message = $companybranch->message;
        //dd($result_message);

        if (!$companybranch->error) {
            $companybranch = $result_message->message;
            Session::flash('success', 'Successfully created new company branch - ' . $companybranch->name);
            return redirect()->route('companybranches.show', $companybranch->id);
        } else {
            Session::flash('error', $result_message->message);
            return redirect()->back()->withInput()->withErrors($result_message->message);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $companies = getUserCompanyIds();
        $companybranch = CompanyBranch::where('id', $id)
                       ->whereIn('company_id', $companies)
                       ->first();
        
        if ($companybranch) {

            //get branch members
            $branchmembers = $companybranch->branchmembers()->paginate(5);
            $branchmemberscount = $companybranch->branchmembers()->count();

            $branchgroups = $companybranch->branchgroups()->paginate(5);
            $branchgroupscount = $companybranch->branchgroups()->count();

            return view('companybranches.show', compact('companybranch', 'branchmembers', 'branchmemberscount', 
                        'branchgroups', 'branchgroupscount'));

        } else {

            abort(404);

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $auth_user = auth()->user();

        $countries = Country::all();
        $companies = Company::all();

        //DB::enableQueryLog();

        //get branch managers in company
        $users = DB::table('users')
                    ->join('role_user', 'role_user.user_id', '=', 'users.id')
                    ->join('roles', 'roles.id', '=', 'role_user.role_id')
                    ->select('users.*')
                    ->where('roles.name', 'branchmanager')
                    ->where('users.company_id', $auth_user->company->id)
                    ->get();
        
        $companybranch = CompanyBranch::find($id);

        //print_r(DB::getQueryLog());
        //dd("here");

        return view('companybranches.edit', compact('countries', 'companies', 'users', 'companybranch'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, CompanyBranchUpdate $companyBranchUpdate)
    {

        //dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'phone_country' => 'required_with:phone',
            'phone' => 'required|phone',
        ]);

        //dd($request->all());

        //update item
        $companybranchdata = CompanyBranch::find($id); 
        $companybranch = $companyBranchUpdate->updateItem($id, $request->all());
        $companybranch = json_decode($companybranch);
        $result_message = $companybranch->message;
        //dd($result_message);

        if (!$companybranch->error) {
            $companybranch = $result_message->message;
            Session::flash('success', 'Successfully updated company branch - ' . $companybranchdata->name);
            return redirect()->route('companybranches.show', $companybranchdata->id);
        } else {
            Session::flash('error', $result_message->message);
            return redirect()->back()->withInput()->withErrors($result_message->message);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
