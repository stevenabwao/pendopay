<?php

namespace App\Http\Controllers\Web\BranchMember;

use Illuminate\Http\Request;
use App\Entities\Group;
use App\Entities\Country;
use App\User;
use App\Entities\Company;
use App\Entities\CompanyBranch;
use App\Entities\CompanyUser;
use App\Entities\BranchMember;
use App\Entities\BranchGroup;
use App\Services\BranchMember\BranchMemberIndex;
use App\Services\BranchMember\BranchMemberStore;
use App\Services\BranchMember\BranchMemberUpdate;
;
use Session;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class BranchMemberController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, BranchMemberIndex $branchMemberIndex)
    {

        //get the data
        $data = $branchMemberIndex->getData($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }

        //dd($data);

        return view('companybranches.branchmembers.index', [
            'branchmembers' => $data
        ]);

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
        $companyusers = CompanyUser::whereIn('company_id', $companies)->get();
        //$companyusers = CompanyUser::whereIn('company_id', ['53'])->get();
        //dd($companyusers);

        return view('companybranches.branchmembers.create', compact('companybranches', 'countries', 'companyusers'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, BranchMemberStore $branchMemberStore)
    {

        //dd($request);

        $user_id = auth()->user()->id;

        $this->validate($request, [
            'company_branch_id' => 'required',
            'company_user_id' => 'required',
        ]);

        //create item
        $branchmember = $branchMemberStore->createItem($request->all());
        $branchmember = json_decode($branchmember);
        $result_message = $branchmember->message;
        //dd($result_message);

        if (!$branchmember->error) {
            $branchmember = $result_message->message;
            Session::flash('success', 'Successfully created new branch member');
            return redirect()->route('branchmembers.show', $branchmember->id);
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
        $branchmember = BranchMember::where('id', $id)
                       ->whereIn('company_id', $companies)
                       ->first();

        if ($branchmember) {
            //get group members
            //$groupmembers = $branchmember->members()->paginate(10);
            //$groupmemberscount = $branchmember->members()->count();
            //dd($branchmember, $groupmembers, $groupmemberscount);

            return view('companybranches.branchmembers.show', compact('branchmember'));

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
        $branchmember = BranchMember::where('id', $id)
                       ->whereIn('company_id', $company_ids)
                       ->first();

        if ($branchmember) {

            $countries = Country::all();
            $companybranches = CompanyBranch::whereIn('company_id', $company_ids)->get();
            //$branchgroupusers = $branchgroup->members();
            //dd($companybranches);

            return view('companybranches.branchmembers.edit', compact('companybranches', 'countries', 'branchmember'));

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
        return redirect()->route('companybranches.branchmembers.show', $group->id);

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
