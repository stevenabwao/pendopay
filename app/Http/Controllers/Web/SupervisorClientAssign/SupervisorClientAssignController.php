<?php

namespace App\Http\Controllers\Web\SupervisorClientAssign;

use App\Entities\Company;
use App\Entities\Country;
use App\Entities\Status;
use App\Entities\SupervisorClientAssign;
use App\Entities\SupervisorClientAssignDetail;
use App\Entities\CompanyUser;
use App\User;
use App\Services\SupervisorClientAssign\SupervisorClientAssignDetailIndex;
use App\Services\SupervisorClientAssign\SupervisorClientAssignIndex;
use App\Services\SupervisorClientAssign\SupervisorClientAssignStore;
use App\Services\SupervisorClientAssign\SupervisorClientAssignUpdate;
use App\Services\SupervisorClientAssign\SupervisorClientAssignRemove;
use Dingo\Api\Exception\StoreResourceFailedException;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class SupervisorClientAssignController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SupervisorClientAssign $model)
    {
        $this->model = $model;

    }

    /**
     *
     * @param Request $request
     * @return mixed
    */
    public function index(Request $request, SupervisorClientAssignIndex $supervisorClientAssignIndex)
    {

        if (isUserHasPermissions("1", ['read-supervisor-client'])) {

            //get the data
            $data = $supervisorClientAssignIndex->getData($request);

            //are we in report mode? return get results
            if ($request->report) {

                $data = $data->get();

            }

            $statuses = Status::where("section", "LIKE", "%loanaccts%")->get();

            //get the data
            $companies = getAllUserCompanies($request);

            //dd($data);

            return view('supervisor-client-assign.index', [
                'supervisorclientassigns' => $data->appends(Input::except('page')),
                'statuses' => $statuses,
                'companies' => $companies
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
    public function create(Request $request)
    {

        if (isUserHasPermissions("1", ['create-supervisor-client'])) {

            $auth_user = auth()->user();

            $company_ids = getUserCompanyIds();
            //get client supervisors in company
            $role_name = 'clientsupervisor';
            $supervisors = getCompanyRoleUsers($company_ids, $role_name);

            return view('supervisor-client-assign.create', compact('supervisors'));

        } else {

            abort(503);

        }

    }

    public function create_step2(Request $request)
    {

        if (isUserHasPermissions("1", ['create-supervisor-client'])) {

            //dd($request->all());
            $this->validate($request, [
                'supervisor_id' => 'required'
            ]);

            $auth_user = auth()->user();

            //dd($request);
            $companies = getUserCompanies();
            $company_ids = getUserCompanyIds();
            $supervisoracct = "";
            //dd($companies);
            $role_name = 'clientsupervisor';
            $unAssignedUsers = getUnassignedCompanyUsers($company_ids, $request);
            if ($request->supervisor_id) {
                $supervisoracct = CompanyUser::find($request->supervisor_id);
            }
            //dd($supervisoracct);

            //get supervisor assigned users
            $assignedUsers = getSupervisorAssignedUsers($company_ids, $request->supervisor_id);

            return view('supervisor-client-assign.create-step-2', compact('companies', 'unAssignedUsers', 'supervisoracct', 'assignedUsers'));

        } else {

            abort(503);

        }

    }


    public function create_step3(Request $request, SupervisorClientAssignStore $supervisorClientAssignStore, 
                                 SupervisorClientAssignRemove $supervisorClientAssignRemove)
    {

        // dd($request->all());

        // get the action
        $action = $request->submit_btn;
        // dd($action);
        
        if ($action == "assign") {

            if (isUserHasPermissions("1", ['create-supervisor-client'])) {

                $this->validate($request, [
                    'supervisor_id' => 'required',
                    'usersSelected' => 'required'
                ]);

                $auth_user = auth()->user();

                //create item
                $supervisorClientAssign = $supervisorClientAssignStore->createItem($request->all());
                $supervisorClientAssign = json_decode($supervisorClientAssign);
                $result_message = $supervisorClientAssign->message;
                //dd($result_message);

                if (!$supervisorClientAssign->error) {
                    $supervisorClientAssign = $result_message->message;
                    Session::flash('success', 'Successfully added new clients to supervisor');
                    return redirect()->back();
                    // return redirect()->route('supervisor-client-assign.showclients', ['company_supervisor_id', $supervisorClientAssign->company_supervisor_id]);
                } else {
                    Session::flash('error', $result_message->message);
                    return redirect()->back()->withInput()->withErrors($result_message->message);
                }

            } else {

                abort(503);

            }

        }


        if ($action == "unassign") {

            // dd("unassign", $request->all());

            if (isUserHasPermissions("1", ['create-supervisor-client'])) {

                $this->validate($request, [
                    'supervisor_id' => 'required', 
                    'usersSelected' => 'required' 
                ]);
        
                $auth_user = auth()->user();
        
                // dd("unassigned here", $request->all());
        
                //create item
                $supervisorClientAssign = $supervisorClientAssignRemove->createItem($request->all());
                $supervisorClientAssign = json_decode($supervisorClientAssign);
                $result_message = $supervisorClientAssign->message;
                //dd($result_message);
        
                if (!$supervisorClientAssign->error) {
                    $message = $result_message->message;
                    Session::flash('success', $message);
                    // Session::flash('success', 'Successfully removed clients from supervisor');
                    return redirect()->back();
                    // return redirect()->route('supervisor-client-assign.showclients', ['company_supervisor_id', $supervisorClientAssign->company_supervisor_id]);
                } else {
                    Session::flash('error', $result_message->message);
                    return redirect()->back()->withInput()->withErrors($result_message->message);
                }

            } else {

                abort(503);

            }

        }

    }

    /* public function unassign(Request $request, SupervisorClientAssignRemove $supervisorClientAssignRemove)
    {
       
        $this->validate($request, [
            'supervisor_id' => 'required', 
            'usersSelected' => 'required' 
        ]);

        $auth_user = auth()->user();

        dd("unassign", $request->all());

        //create item
        $supervisorClientAssign = $supervisorClientAssignRemove->createItem($request->all());
        $supervisorClientAssign = json_decode($supervisorClientAssign);
        $result_message = $supervisorClientAssign->message;
        //dd($result_message);

        if (!$supervisorClientAssign->error) {
            $supervisorClientAssign = $result_message->message;
            Session::flash('success', 'Successfully added new clients to supervisor');
            return redirect()->route('supervisor-client-assign.showclients', ['company_supervisor_id', $supervisorClientAssign->company_supervisor_id]);
        } else {
            Session::flash('error', $result_message->message);
            return redirect()->back()->withInput()->withErrors($result_message->message);
        }

    } */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SupervisorClientAssignStore $supervisorClientAssignStore)
    {

        if (isUserHasPermissions("1", ['create-supervisor-client'])) {

            //dd($request->all());
            $this->validate($request, [
                'supervisor_id' => 'required',
                'usersSelected' => 'required'
            ]);

            dd("assign", $request->all());

            //create item
            $companybranch = $supervisorClientAssignStore->createItem($request->all());
            $companybranch = json_decode($companybranch);
            $result_message = $companybranch->message;
            //dd($result_message);

            if (!$companybranch->error) {
                $companybranch = $result_message->message;
                Session::flash('success', 'Successfully created new supervisor assignment - ' . $companybranch->name);
                return redirect()->route('supervisor-client-assign.showclients', ['company_supervisor_id', $request->supervisor_id]);
            } else {
                Session::flash('error', $result_message->message);
                return redirect()->back()->withInput()->withErrors($result_message->message);
            }

        } else {

            abort(503);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showclients(Request $request, SupervisorClientAssignDetailIndex $supervisorClientAssignDetailIndex)
    {

        if (isUserHasPermissions("1", ['read-supervisor-client'])) {

            //get the data
            $data = $supervisorClientAssignDetailIndex->getData($request);

            //are we in report mode? return get results
            if ($request->report) {

                $data = $data->get();

            }

            $company_ids = getUserCompanyIds();
            //get client supervisors in company
            $role_name = 'clientsupervisor';
            $supervisors = getCompanyRoleUsers($company_ids, $role_name);
            //dd($supervisors);

            $statuses = Status::where("section", "LIKE", "%supervisorclient%")->get();

            //get the data
            $companies = getAllUserCompanies($request);

            //dd($data);

            return view('supervisor-client-assign.show', [
                'supervisorclientassigns' => $data->appends(Input::except('page')),
                'supervisors' => $supervisors,
                'statuses' => $statuses,
                'companies' => $companies
            ]);

        } else {

            abort(503);

        }

    }

    public function show2($id)
    {
        
        $companies = getUserCompanies();
        $company_ids = getUserCompanyIds();
        //dd($company_ids);
        $supervisorclientassigns = SupervisorClientAssignDetail::where('company_supervisor_id', $id)
                       ->whereIn('company_id', $company_ids)
                       ->get();
                       //dd($supervisorclientassigns);
        
        if ($supervisorclientassigns) {

            return view('supervisor-client-assign.show', compact('supervisorclientassigns', 'companies'));

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

        if (isUserHasPermissions("1", ['update-supervisor-client'])) {

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

            $companybranch = SupervisorClientAssign::find($id);

            //print_r(DB::getQueryLog());
            //dd("here");

            return view('supervisor-client-assign.edit', compact('countries', 'companies', 'users', 'companybranch'));

        } else {

            abort(503);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, SupervisorClientAssignUpdate $supervisorClientAssignUpdate)
    {

        if (isUserHasPermissions("1", ['update-supervisor-client'])) {

            //dd($request->all());
            $this->validate($request, [
                'name' => 'required',
                'phone_country' => 'required_with:phone',
                'phone' => 'required|phone',
            ]);

            //dd($request->all());

            //update item
            $companybranchdata = SupervisorClientAssign::find($id);
            $companybranch = $supervisorClientAssignUpdate->updateItem($id, $request->all());
            $companybranch = json_decode($companybranch);
            $result_message = $companybranch->message;
            //dd($result_message);

            if (!$companybranch->error) {
                $companybranch = $result_message->message;
                Session::flash('success', 'Successfully updated supervisor assignment - ' . $companybranchdata->name);
                return redirect()->route('supervisor-client-assign.show', $companybranchdata->id);
            } else {
                Session::flash('error', $result_message->message);
                return redirect()->back()->withInput()->withErrors($result_message->message);
            }

        } else {

            abort(503);

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
