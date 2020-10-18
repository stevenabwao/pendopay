<?php

namespace App\Http\Controllers\Web\BranchGroup;

use Illuminate\Http\Request;
use App\Entities\Group;
use App\Entities\Country;
use App\User;
use App\Entities\Company;
use App\Entities\CompanyBranch;
use App\Entities\BranchMember;
use App\Entities\BranchGroup;
use App\Services\BranchGroup\BranchGroupIndex;
use App\Services\BranchGroup\BranchGroupStore;
use App\Services\BranchGroup\BranchGroupUpdate;
;
use Session; 

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class BranchGroupController extends Controller
{

    /**
     * @var state
     */
    protected $model;

    /**
     *
     * @param BranchGroup $model
     */
    public function __construct(BranchGroup $model)
    {
        $this->model = $model;
        //$this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, BranchGroupIndex $branchGroupIndex)
    {

        if (isUserHasPermissions("1", ['read-company-branch-group'])) {

            //get the data
            $data = $branchGroupIndex->getData($request);

            //are we in report mode? return get results
            if ($request->report) {

                $data = $data->get();

            }

            return view('companybranches.branchgroups.index', [
                'branchgroups' => $data
            ]);

        } else {

            abort(503);

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $companies = getUserCompanyIds();
        $countries = Country::all();
        $companybranches = CompanyBranch::whereIn('company_id', $companies)->get();
        $branchusers = BranchMember::whereIn('company_id', $companies)->get();
        //dd($companybranches);

        return view('companybranches.branchgroups.create', compact('companybranches', 'countries', 'branchusers'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, BranchGroupStore $branchGroupStore)
    {

        //dd($request);

        $user_id = auth()->user()->id;

        $this->validate($request, [
            'name' => 'required',
            'phone_country' => 'required_with:phone',
            'phone' => 'required|phone'
        ]);

        //create item
        $branchgroup = $branchGroupStore->createItem($request->all());
        $branchgroup = json_decode($branchgroup);
        $result_message = $branchgroup->message;
        //dd($result_message);

        if (!$branchgroup->error) {
            $branchgroup = $result_message->message;
            Session::flash('success', 'Successfully created new branch group - ' . $branchgroup->name);
            return redirect()->route('branchgroups.show', $branchgroup->id);
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

        //get item
        $companies = getUserCompanyIds();
        $branchgroup = BranchGroup::where('id', $id)
                       ->whereIn('company_id', $companies)
                       ->with('companybranch')
                       ->first();

        if ($branchgroup) {
            //get group members
            $groupmembers = $branchgroup->groupmembers()->paginate(10);
            $groupmemberscount = $branchgroup->groupmembers()->count();
            //dd($branchgroup, $groupmembers, $groupmemberscount);

            return view('companybranches.branchgroups.show', compact('branchgroup', 'groupmembers', 'groupmemberscount'));

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

        //get item
        $companies = getUserCompanies();
        $company_ids = getUserCompanyIds();
        $branchgroup = BranchGroup::where('id', $id)
                       ->whereIn('company_id', $company_ids)
                       ->with('companybranch')
                       ->first();

        if ($branchgroup) {

            $countries = Country::all();
            $companybranches = CompanyBranch::whereIn('company_id', $company_ids)->get();
            $branchgroupusers = $branchgroup->members();
            //dd($companybranches);

            return view('companybranches.branchgroups.edit', compact('companybranches', 'countries', 'branchgroup', 'branchgroupusers'));

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
    public function update(Request $request, $id, BranchGroupUpdate $branchGroupUpdate)
    {

        $user_id = auth()->user()->id;

        $this->validate($request, [
            'name' => 'required',
            'phone_country' => 'required_with:phone',
            'phone' => 'required|phone'
        ]);

        //create item
        $company_ids = getUserCompanyIds();
        $branchgroupitem = BranchGroup::where('id', $id)
                                        ->whereIn('company_id', $company_ids)
                                        ->first();
        
        if ($branchgroupitem) {

            $branchgroup = $branchGroupUpdate->updateItem($id, $request->all());
            $branchgroup = json_decode($branchgroup);
            $result_message = $branchgroup->message;
            //dd($result_message);

            if (!$branchgroup->error) {
                $branchgroup = $result_message->message;
                Session::flash('success', 'Successfully updated branch group - ' . $branchgroupitem->name);
                return redirect()->route('branchgroups.show', $branchgroupitem->id);
            } else {
                Session::flash('error', $result_message->message);
                return redirect()->back()->withInput()->withErrors($result_message->message);
            }

        } else {

            abort(404);

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
