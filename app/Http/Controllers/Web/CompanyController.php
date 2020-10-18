<?php

namespace App\Http\Controllers\Web;

use App\Entities\Company;
use App\Entities\Country;
use App\Http\Controllers\BaseController;
use App\Services\Company\CompanyIndex;
use App\Services\Company\CompanyStore;
use App\Services\Company\CompanyUpdate;
use Session;
use Illuminate\Http\Request;

class CompanyController extends BaseController
{

    /**
     *
     * @param Company $model
     */
    public function __construct(Company $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CompanyIndex $companyIndex)
    {

        //get the data
        $data = $companyIndex->getData($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }

        return view('companies.index', [
            'companies' => $data
        ]);

    }

    // get a club's offer
    public function getClubOffer(Request $request)
    {
        dd("getClubOffer *** ", $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('companies.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CompanyStore $companyStore)
    {

        //dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'phone_country' => 'required_with:phone',
            'phone' => 'required|phone',
        ]);

        // $rules = [
        //     'name' => 'required',
        //     'phone_country' => 'required_with:phone',
        //     'phone' => 'required|phone',
        // ];

        // $payload = app('request')->only('name', 'phone', 'phone_country');

        // $validator = app('validator')->make($payload, $rules);

        // if ($validator->fails()) {
        //     //throw new StoreResourceFailedException($validator->errors());
        //     $message = $validator->errors();
        //     Session::flash('error', $message);
        //     return redirect()->back()->withInput()->withError($message);
        // }

        //create item
        $company = $companyStore->createItem($request->all());
        $company = json_decode($company);
        $result_message = $company->message;
        //dd($company, $result_message);

        if (!$company->error) {
            $company = $result_message;
            Session::flash('success', 'Successfully created new company - ' . $company->name);
            return redirect()->route('companies.show', $company->id);
        } else {
            $message = $result_message;
            Session::flash('error', $message);
            return redirect()->back()->withInput()->withErrors($message);
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

        // get if from submitted data
        $the_id = getIdFromPermalink($id);

        $club = Company::find($the_id);

        return view('companies.show', compact('club'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $company = Company::where('id', $id)->first();

        return view('companies.edit')->withCompany($company);

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

        $company = Company::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|max:255|unique:companies,name,'.$company->id,
            'phone_number' => 'required|max:13',
            'sms_user_name' => 'sometimes'
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

        $remove_spaces_regex = "/\s+/";
        //remove all spaces
        $sms_user_name = preg_replace($remove_spaces_regex, '', $request->sms_user_name);

        //update company record
        $company->name = $request->name;
        $company->phone_number = $phone_number;
        $company->email = $request->email;
        $company->sms_user_name = $sms_user_name;
        $company->physical_address = $request->physical_address;
        $company->box = $request->box;
        $company->company_no = $request->company_no;
        $company->updated_by = $user_id;
        $company->save();

        Session::flash('success', 'Successfully updated company - ' . $company->name);
        return redirect()->route('companies.show', $company->id);

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
