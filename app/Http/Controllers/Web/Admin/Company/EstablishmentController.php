<?php

namespace App\Http\Controllers\Web\Admin\Company;

use App\Entities\Company;
use App\Entities\Country;
use App\Entities\County;
use App\Entities\EstCategory;
use App\Entities\Status;
use App\Http\Controllers\Controller;
use App\Services\Company\CompanyIndex;
use App\Services\Company\CompanyStore;
use App\Services\Company\CompanyUpdate;
use Session;
use Illuminate\Http\Request;

class EstablishmentController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CompanyIndex $companyIndex)
    {

        if (isUserHasPermissions("1", ['read-company'])) {

            //get the data
            $data = $companyIndex->getData($request);

            //are we in report mode? return get results
            if ($request->report) {

                $data = $data->get();

            }
            //dd($data);

            $statuses = Status::where("section", "LIKE", "%establishment%")->get();

            return view('_admin.companies.index', [
                'companies' => $data,
                'statuses' => $statuses
            ]);

        } else {
            abort(404);
        }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (isUserHasPermissions("1", ['create-company'])) {

            $site_settings = app('site_settings');
            //dd($site_settings);

            $countries = Country::all();
            $counties = County::where('status_id', '1')->orderBy('name')->get();
            $categories = EstCategory::all();
            $statuses = Status::where('section', 'LIKE', '%establishment%')->get();

            return view('_admin.companies.create', compact('countries', 'site_settings', 'counties', 'categories', 'statuses'));

        } else {

            abort(404);

        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CompanyStore $companyStore)
    {

        if (isUserHasPermissions("1", ['read-company'])) {

            //dd($request->all());
            $this->validate($request, [
                'name' => 'required',
                'county_id' => 'required',
                'category_id' => 'required',
                'item_image' => 'image|nullable|mimes:jpeg,gif,bmp,png,jpg|max:1999'
            ]);

            try {
                $company_result = $companyStore->createItem($request);
                $company_result = json_decode($company_result);
                $result_message = $company_result->message->message;
                // dd($result_message->message);

                $new_company = $result_message->data;
                $success_message = $result_message->message;
                Session::flash('success', $success_message);
                return redirect()->route('admin.establishments.show', $new_company->id);

            } catch(\Exception $e) {

                $message = $e->getMessage();
                log_this($message);
                Session::flash('error', $message);
                return redirect()->back()->withInput()->withErrors($message);

            }

            /* if (!$company_result->error) {
                $company = $result_message->message;
                Session::flash('success', 'Successfully created establishment - ' . $company->name);
                return redirect()->route('admin.establishments.show', $company->id);
            } else {
                $message = $result_message->message;
                Session::flash('error', $message);
                return redirect()->back()->withInput()->withErrors($message);
            } */

        } else {

            abort(404);

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

        if (isUserHasPermissions("1", ['read-company'])) {

            $images = [];

            $site_settings = app('site_settings');

            $company = Company::findOrFail($id);
            // dd("company", $company);

            //get company images
            if(count($company->images) > 0)
            {
                $images = $company->images;
            }
            // dd($images);

            return view('_admin.companies.show', compact('company', 'site_settings', 'images'));

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

        if (isUserHasPermissions("1", ['update-company'])) {

            $images = [];

            $site_settings = app('site_settings');
            //dd("ddsds", $site_settings);

            $counties = County::all();
            $categories = EstCategory::all();
            $statuses = Status::where('section', 'LIKE', '%establishment%')->get();
            $company = Company::find($id);

            //get company images
            if(count($company->images) > 0)
            {
                $images = $company->images;
            }
            //dd($images);

            return view('_admin.companies.edit', compact('company', 'site_settings', 'images', 'counties', 'categories', 'statuses'));

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
    public function update(Request $request, $id, CompanyUpdate $companyUpdate)
    {

        if (isUserHasPermissions("1", ['update-company'])) {

            $company = Company::findOrFail($id);

            $rules = [
                'name' => 'required|max:255|unique:companies,name,'.$company->id,
                'county_id' => 'required',
                'category_id' => 'required',
                'item_image' => 'image|nullable|mimes:jpeg,gif,bmp,png,jpg|max:1999'
            ];

            $payload = app('request')->only('name', 'county_id', 'category_id', 'item_image');

            $validator = app('validator')->make($payload, $rules);

            if ($validator->fails()) {
                Session::flash('error', $validator->errors());
                // dd($validator->errors());
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            $company_result = $companyUpdate->updateItem($id, $request);
            $company_result = json_decode($company_result);
            $result_message = $company_result->message;
            //dd($company_result, $result_message);

            if (!$company_result->error) {
                Session::flash('success', 'Successfully updated establishment - ' . $company->name);
                return redirect()->route('admin.establishments.show', $company->id);
            } else {
                $message = $result_message->message;
                Session::flash('error', $message);
                return redirect()->back()->withInput()->withErrors($message);
            }

        } else {

            abort(404);

        }

    }

}
