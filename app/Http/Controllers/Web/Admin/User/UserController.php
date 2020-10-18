<?php

namespace App\Http\Controllers\Web\Admin\User;

use App\Entities\Company;
use App\Events\AccountAdded;
use App\Entities\Group;
use App\Http\Controllers\Controller;
use App\Services\User\UserStore; 
use App\Role;
use App\Services\User\UserIndex;
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
    public function __construct(User $model)
    {
        $this->model = $model;
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
        
        /* $user = auth()->user();

        //if user is superadmin, show all companies, else show a user's companies
        $companies = [];
        if ($user->hasRole('superadministrator')){
            $companies = Company::all()->pluck('id');
        } else if ($user->hasRole('administrator')) {
            if ($user->company) {
                $companies[] = $user->company->id;
            }
        }

        //get company users
        $users = [];

        if ($companies) { 

            $users = User::whereIn('company_id', $companies)
                    ->orderBy('id', 'desc')
                    ->with('company')
                    ->with('roles')
                    ->paginate(10);

        } */

        //dd($companies);

        //get the data
        $companies = getAllUserCompanies($request);

        $users = $userIndex->getUsers($request);

        $user = auth()->user();

        //are we in report mode? return get results
        if ($request->report) {
            $users = $users->get();
        }

        return view('admin.users.index', compact('user', 'users', 'companies'));

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
            //'phone_country' => 'required_with:phone',
            //'phone' => 'required|phone:KE',
            //'password' => 'required|min:8|confirmed',
            'company_id' => 'required|integer',
        ]);
        //dd($request);

        //create item
        //$user = $this->model->create($request->all());

        try {

            $user = new User();

                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->phone_country = $request->phone_country;
                $user->phone = $request->phone;
                $user->email = $request->email;
                $user->company_id = $request->company_id;
                $user->company_id = $request->company_id;

                if (auth()->user()) {
                    $user_id = auth()->user()->id;

                    $user->created_by = $user_id;
                    $user->updated_by = $user_id;
                } 

            $user->save();
            //end create user 
            

        } catch(\Exception $e) {

            DB::rollback();
            $error_message = json_encode($e->getMessage());
            log_this('Error creating user === ' . $error_message);
            //error occured
            session()->flash("error", "An error occured\n" . $error_message);
            return redirect()->back()->withInput()->withErrors($e);

        }

        //success
        session()->flash("success", "User successfully created");
        return redirect()->route('users.index');

    }


    public function store2(Request $request)
    {

        //dd($request);

        $this->validate(request(), [
            'first_name' => 'required',
            'last_name' => 'required',
            //'account_number' => 'required',
            'email' => 'email|unique:users',
            'sms_user_name' => 'unique:users',
            'phone_number' => 'required|max:13'
        ]);

        $phone_number = '';
        if ($request->phone_number) {
            if (!isValidPhoneNumber($request->phone_number)){
                $message = \Config::get('constants.error.invalid_phone_number');
                Session::flash('error', $message);
                return redirect()->back()->withInput();
            }
            $phone_number = formatPhoneNumber($request->phone_number);
        }

        //generate random password
        $password = generateCode(6);

        // create user
        $userData = [
            'first_name' => request()->first_name,
            'last_name' => request()->last_name,
            'sms_user_name' => request()->sms_user_name,
            'email' => request()->email,
            'company_id' => request()->company_id,
            'account_number' => request()->account_number,
            'gender' => request()->gender,
            'phone_number' => $phone_number,
            'password' => bcrypt($password),
            'api_token' => str_random(60),
            'created_by' => request()->user()->id,
            'updated_by' => request()->user()->id
        ];

        $user = User::create($userData);
        
        //add generated password to returned data
        //$user['password'] = $password;

        //event(new Registered($user));

        session()->flash("success", "User successfully created");
        return $this->registered(request(), $user)
                        ?: redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*$bulk_sms_data = getBulkSMSData($id);
        dd($bulk_sms_data);*/

        $user = User::where('id', $id)->with('roles')->first();
        return view("users.show")->withUser($user);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) 
    {

        $user = User::where('id', $id)
            ->with('roles')
            ->with('groups')
            ->with('company')
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
    public function update(Request $request, $id)
    {
        
        $this->validate(request(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'sometimes|email|unique:users,email,'.$id,
            //'account_number' => 'required',
            'phone' => 'required|max:13'
                //'required|unique:users,phone_number|unique:users,company_id,id,'.$id,
        ]);

        $phone = '';
        if ($request->phone) {
            if (!isValidPhoneNumber($request->phone)){
                $message = \Config::get('constants.error.invalid_phone_number');
                Session::flash('error', $message);
                return redirect()->back()->withInput();
            }
            $phone = formatPhoneNumber($request->phone);
        }

        $user = User::findOrFail($id);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->company_id = $request->company_id;
        $user->phone = $phone;
        //$user->account_number = $request->account_number;
        $user->gender = $request->gender;

        if ($request->password_option == 'auto'){
            /*auto generate new password*/
            $password = generateCode(6);
            $user->password = bcrypt($password);
            //send the user a link to change password

        } else if ($request->password_option == 'manual'){
            /*set to entered password*/
            $user->password = bcrypt($request->password);
        }

        if ($user->save()) {

            if ($request->rolesSelected) {
                //sync roles
                $user->syncRoles(explode(',', $request->rolesSelected));
            }
            if ($request->groupsSelected) {
                //sync groups
                $groups = explode(',', $request->groupsSelected);
                $user->groups()->sync($groups);
            }
            
            //dd($user);

            Session::flash('success', 'User was edited successfully');
            return redirect()->route('users.show', $id);

        } else {

            Session::flash('error', 'There ws an error saving the update');
            return redirect()->route('users.edit', $id);

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
