<?php

namespace App\Http\Controllers;

use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Events\AccountAdded;
use App\Entities\Group;
use App\Http\Controllers\Controller;
use App\Services\User\UserIndex;
use App\Services\User\UserStore;
use App\Services\User\UserUpdate;
use App\Role;
use App\User;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Session;

class UserController extends Controller
{

    use RegistersUsers;

    /**
     * @var User
     */
    protected $model;

    /**
     * UsersController constructor.
     * @param User $model
     */
    /*public function __construct(User $model)
    {
        $this->model = $model;
    }*/

    public function __construct()
    {
    }


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, UserIndex $userIndex)
    {

        //get the data
        $companies = getAllUserCompanies($request);

        $data = $userIndex->getUsers($request);

        $user = auth()->user();

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }

        return view('users.index', [
            'companies' => $companies,
            'users' => $data,
            'user' => $user
        ]);

    }

    /*show user create form*/
    public function create()
    {

        $user = auth()->user();
        $userCompany = User::where('id', $user->id)
            ->with('company')
            ->first();
        //if user is superadmin, show all companies, else show a user's companies
        $companies = [];
        if ($user->hasRole('superadministrator')){
            $companies = Company::all();
        } else {
            $companies = $user->company;
        }
        //dd($companies);

        return view('users.create')
            ->withCompanies($companies)
            ->withUser($userCompany);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, UserStore $userStore)
    {

        //dd($request);
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            // 'phone_country' => 'required_with:phone',
            // 'phone' => 'required|phone:KE',
            // 'password' => 'required|min:8|confirmed',
            // 'company_id' => 'required|integer',
        ]);
        //dd($request);

        //create item
        $result = $userStore->createItem($request->all());
        $result = json_decode($result);
        $result_message = $result->message;

        if (!$result->error) {
            //success
            session()->flash("success", "User successfully created");
            return redirect()->route('users.index');
        } else {
            //error occured
            session()->flash("error", $result_message);
            return redirect()->back()->withInput();
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

        $user = CompanyUser::find($id);
        //dd($id, $user);
        return view("users.show", compact('user'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = CompanyUser::where('id', $id)
            //->with('roles')
            //->with('groups')
            //->with('company')
            ->first();

        //if user is superadmin, show all companies, else show a user's companies
        $companies = [];
        if (auth()->user()->hasRole('superadministrator')){
            $companies = Company::all();
        } else {
            $companies[] = $user->company;
        }

        $groups = [];
        if ($user->company) {
            $groups = $user->company->groups;
        }

        //get all roles
        $roles = Role::all();

        /*return view("users.edit")
            ->withUser($user)
            ->withRoles($roles)
            ->withGroups($groups)
            ->withCompanies($companies);*/

        return view("users.edit", compact('user', 'roles', 'groups', 'companies'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, UserUpdate $userUpdate)
    {

        $this->validate(request(), [
            'first_name' => 'required',
            'last_name' => 'required',
            //'email' => 'sometimes|email|unique:users,email,'.$id,
            'email' => 'sometimes|email',
            //'account_number' => 'required',
            'phone' => 'required|max:13'
                //'required|unique:users,phone_number|unique:users,company_id,id,'.$id,
        ]);

        $companyuserdata = CompanyUser::find($id);
        $companyuser = $userUpdate->updateItem($id, $request);
        $companyuser = json_decode($companyuser);
        $result_message = $companyuser->message;
        //dd($result_message);

        if (!$companyuser->error) {
            $companyuser = $result_message;
            Session::flash('success', 'Successfully updated user - ' . $companyuserdata->user->first_name);
            return redirect()->route('users.show', $id);
        } else {
            Session::flash('error', $result_message);
            return redirect()->back()->withInput()->withErrors($result_message);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('users.index');
    }


}
