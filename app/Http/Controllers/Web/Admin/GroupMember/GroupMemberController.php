<?php

namespace App\Http\Controllers\Web\GroupMember;

use Illuminate\Http\Request;
use App\Entities\Group;
use App\Entities\Country;
use App\User;
use App\Entities\Company;
use App\Entities\CompanyBranch;
use App\Entities\BranchMember;
use App\Entities\GroupMember;
use App\Entities\BranchGroup;
use App\Services\GroupMember\GroupMemberIndex;
use App\Services\GroupMember\GroupMemberStore;
use App\Services\GroupMember\GroupMemberUpdate;
;
use Session;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class GroupMemberController extends Controller
{

    /**
     * @var state
     */
    protected $model;

    /**
     *
     * @param GroupMember $model
     */
    public function __construct(GroupMember $model)
    {
        $this->model = $model;
        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, GroupMemberIndex $groupMemberIndex)
    {

        //get the data
        $data = $groupMemberIndex->getData($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }

        //dd($data);

        return view('companybranches.groupmembers.index', [
            'groupmembers' => $data
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_step1()
    {

        $companies = getUserCompanyIds();
        $companybranches = CompanyBranch::whereIn('company_id', $companies)->get();
        //dd($companybranches);

        return view('companybranches.groupmembers.create-step1', compact('companybranches'));

    }

    public function create_step1_store(Request $request)
    {

        $this->validate($request, [
            'company_branch_id' => 'required',
        ]);

        //dd($request);

        //check if user has permissions to branch data
        $companies = getUserCompanyIds();
        $companybranch = CompanyBranch::whereIn('company_id', $companies)
                                        ->where('id', $request->company_branch_id)
                                        ->first();
        if ($companybranch){

            //pass branch groups only
            
            return redirect(route('groupmembers.create-step2', ['company_branch_id' => $request->company_branch_id]));
            //return redirect(route('groupmembers.create-step2') . "/" . $request->company_branch_id);  
            //, compact('branchgroups'));

        } else {

            abort(404);

        }

    }

    public function create_step2(Request $request)
    {

        $companies = getUserCompanyIds();

        $company_branch_id = $request->company_branch_id;

        //get branch data
        $companybranch = CompanyBranch::find($company_branch_id);

        //get branch groups
        $branchgroups = BranchGroup::whereIn('company_id', $companies)
                                   ->where('company_branch_id', $company_branch_id)
                                   ->get();

        //get branch members
        $branchmembers = BranchMember::whereIn('company_id', $companies)
                                    ->where('company_branch_id', $company_branch_id)
                                    ->get();

        //dd($branchgroups, $branchmembers, $companybranch);

        return view('companybranches.groupmembers.create-step2', compact('companybranch', 'branchgroups', 'branchmembers'));
        //, compact('companybranches'));

    }

    public function create_step2_store(Request $request, GroupMemberStore $groupMemberStore)
    {

        //dd($request);
        $this->validate($request, [
            'company_branch_id' => 'required',
            'branch_group_id' => 'required',
            'branch_member_id' => 'required',
        ]);

        //dd($request);

        //check if user has permissions to branch data
        $companies = getUserCompanyIds();
        $companybranch = CompanyBranch::whereIn('company_id', $companies)
                                        ->where('id', $request->company_branch_id)
                                        ->first();
        $branchgroup = BranchGroup::whereIn('company_id', $companies)
                                        ->where('id', $request->branch_group_id)
                                        ->first();
        
        //if user has access, allow
        if ($companybranch && $branchgroup){

            //add user to group
            $groupmember = $groupMemberStore->createItem($request->all());
            $groupmember = json_decode($groupmember);
            $result_message = $groupmember->message;
            //dd($result_message);

            if (!$groupmember->error) {
                $groupmember = $result_message->message;
                Session::flash('success', 'Successfully created new group member');
                return redirect()->route('groupmembers.show', $groupmember->id);
            } else {
                Session::flash('error', $result_message->message);
                return redirect()->back()->withInput()->withErrors($result_message->message);
            }

        } else {
            abort(404);
        }

    }



    public function create()
    {

        $companies = getUserCompanyIds();
        $countries = Country::all();
        $companybranches = CompanyBranch::whereIn('company_id', $companies)->get();
        $branchmembers = BranchMember::whereIn('company_id', $companies)->get();
        //dd($companybranches);

        return view('companybranches.groupmembers.create', compact('companybranches', 'countries', 'branchmembers'));

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
            'phone' => 'required|phone',
        ]);

        //create item
        $branchgroup = $branchGroupStore->createItem($request->all());
        $branchgroup = json_decode($branchgroup);
        $result_message = $branchgroup->message;
        //dd($result_message);

        if (!$branchgroup->error) {
            $branchgroup = $result_message->message;
            Session::flash('success', 'Successfully created new branch group - ' . $branchgroup->name);
            return redirect()->route('companybranches.branchgroups.show', $branchgroup->id);
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
        $groupmember = $this->model->where('id', $id)
                       ->whereIn('company_id', $companies)
                       ->first();

        if ($groupmember) {
            //get group members
            //$groupmembers = $groupmember->members()->paginate(10);
            //dd($groupmember, $groupmembers, $groupmemberscount);

            return view('companybranches.groupmembers.show', compact('groupmember'));

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
    public function update(Request $request, $id)
    {

        $user_id = auth()->user()->id;

        $this->validate($request, [
            'name' => 'required|max:255',
            'phone_number' => 'sometimes|max:13,phone_number,'.$id,
            'company_id' => 'required|max:255'
        ]);
        //dd($request);

        $phone_number = '';
        if ($request->phone_number) {
            if (!isValidPhoneNumber($request->phone_number)){
                $message = \Config::get('constants.error.invalid_phone_number');
                Session::flash('error', $message);
                return redirect()->back()->withInput();
            }
            $phone_number = formatPhoneNumber($request->phone_number);
        }

        $group = Group::findOrFail($id);
        $group->name = $request->name;
        $group->company_id = $request->company_id;
        $group->phone_number = $phone_number;
        $group->description = trim($request->description);
        $group->email = $request->email;
        $group->physical_address = trim($request->physical_address);
        $group->box = $request->box;
        $group->updated_by = $user_id;
        $group->save();

        Session::flash('success', 'Successfully updated group - ' . $group->name);
        return redirect()->route('companybranches.branchgroups.show', $group->id);

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
