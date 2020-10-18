<?php

namespace App\Http\Controllers;

use App\Entities\Company;
use App\Services\User\UserImport;
use App\Entities\TempTable;
use App\User;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class UserImportController extends Controller
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
    public function index()
    {
        return view('bulk-users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = auth()->user();

        //if user is superadmin, show all companies, else show a user's companies
        $companies = [];
        if ($user->hasRole('superadministrator')){
            $companies = Company::all();
        } else if ($user->hasRole('administrator')) {
            if ($user->company) {
                $companies[] = $user->company;
            }
        }

        //get user data
        $userData = User::where('id', $user->id)
                    ->with('company')
                    ->first();

        //dd($companies);
        return view('bulk-users.create')
            ->withCompanies($companies)
            ->withUser($userData);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UserImport $userImport)
    {

        $user_id = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'import_file' => 'required',
            'company_id' => 'required',
            
        ]);

        if ($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('import_file')) {
            
            $company_id = $request->company_id;
            $path = $request->file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();

            if (!empty($data) && $data->count()) {
                
                $errors = [];

                //toarray
                $arrdata = $data->toArray();

                //dd($res);

                if (!$userImport->checkImportData($arrdata, $company_id))
                {
                    Session::flash('error_row_id', $userImport->getErrorRowId());
                    Session::flash('valid_row_id', $userImport->getValidRowId());
                    return redirect()->back()->withInput();
                }

                //dump(count($data));
                $count = count($data);

                //if all is ok, create users
                $userImport->createUsers($data, $company_id);
                
            }
            //Session::flash('success', 'Successfully inserted users');
            Session::flash('success', 'Successfully inserted ' . $count . ' users');
            return redirect()->back();
            //return redirect()->route('users.index');
        }

    }

    //get import data
    public function getImportData($id)
    {
        $data = TempTable::where('uuid', $id)->first();

        if (!$data) {
            abort(400, "Cannot find import data");
        }

        if ($data->user_id != auth()->user()->id) {
            abort(403, "Access Denied");
        }

        $data = unserialize($data->data);
        $header = [];

        foreach ($data[0] as $key => $value) {
            $header[] = $key;
        }

        if (!file_exists(public_path('download'))) {
            mkdir(public_path('download'), 0755, true);
        }

        $filename = time() . ".csv";
        $handle = fopen(public_path('download/' . $filename), 'w+');
        fputcsv($handle, $header);

        foreach ($data as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv',
        ];

        return response()->download(public_path('download/' . $filename), $filename, $headers);

    }

    //get incomplete data
    public function getIncompleteData($id, UserImport $userImport)
    {
        
        //get logged in user's company id
        $company_id = null;
        if (auth()->user()->company) {
            $company_id = auth()->user()->company->id;
        }

        $data = TempTable::where('uuid', $id)->first();

        if (!$data) {
            abort(400, "Cannot find import data");
        }

        if ($data->user_id != auth()->user()->id) {
            abort(403, "Access Denied");
        }

        $data = unserialize($data->data);
        $header = [];

        $count = count($data);

        //dd($data);

        foreach ($data[0] as $key => $value) {
            $header[] = $key;
        }

        $userImport->createUsers($data, $company_id);

        Session::flash('success', 'Successfully inserted ' . $count . ' users');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        //$company = Company::where('id', $id)->first();

        return view('bulk-users.show');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        //$company = Company::where('id', $id)->first();
        return view('bulk-users.edit');

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
