<?php

namespace App\Http\Controllers\Web;

use App\Entities\Offer;
use App\Entities\Country;
use App\Http\Controllers\BaseController;
use App\Services\Offer\OfferFrontIndex;
use App\Services\Offer\OfferIndex;
use App\Services\Offer\OfferStore;
use App\Services\Offer\OfferUpdate;
use App\Services\OfferProduct\OfferProductFrontIndex;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class OfferFrontController extends BaseController
{

    /**
     *
     * @param Offer $model
     */
    public function __construct(Offer $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, OfferFrontIndex $offerFrontIndex)
    {

        //get the data
        $data = $offerFrontIndex->getData($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }

        // dd($data);

        return view('offers.index', [
            'offers' => $data
        ]);

    }

    // get a club's offers
    public function getClubOffers(Request $request, $company_link, OfferFrontIndex $offerFrontIndex)
    {
        // dd($company_link);

        // get company_id from company link
        // get offer_id from offer link
        $company_id = getIdFromPermalink($company_link);

        $request->merge([
            'company_id' => $company_id,
        ]);

        //get the data
        $data = $offerFrontIndex->getData($request);

        //are we in report mode? return get results
        if ($request->report) {
            $data = $data->get();
        }

        return view('offers.club-offers', [
            'offerproducts' => $data
        ]);

    }

    // get a club's offer record (single offer)
    public function getClubOffer(Request $request, $company_link, $offer_link, OfferProductFrontIndex $offerProductFrontIndex)
    {
        // dd($company_link);

        // get company_id from company link
        // get offer_id from offer link
        $company_id = getIdFromPermalink($company_link);
        $offer_id = getIdFromPermalink($offer_link);
        $offer = Offer::find($offer_id);

        $request->merge([
            'company_id' => $company_id,
            'offer_id' => $offer_id
        ]);

        //get the data
        $data = $offerProductFrontIndex->getData($request);
        // dd($data);

        //are we in report mode? return get results
        if ($request->report) {
            $data = $data->get();
        }

        return view('offers.club-offers', [
            'offer' => $offer,
            'offerproducts' => $data
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('offers.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, OfferStore $offerStore)
    {

        //dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'phone_country' => 'required_with:phone',
            'phone' => 'required|phone',
        ]);

        //create item
        $offer = $offerStore->createItem($request->all());
        $offer = json_decode($offer);
        $result_message = $offer->message;
        //dd($offer, $result_message);

        if (!$offer->error) {
            $offer = $result_message;
            Session::flash('success', 'Successfully created new offer - ' . $offer->name);
            return redirect()->route('offers.show', $offer->id);
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

        $offer = Offer::find($the_id);

        return view('offers.show', compact('offer'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $company = Offer::where('id', $id)->first();

        return view('offers.edit')->withOffer($company);

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

        $company = Offer::findOrFail($id);

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
        return redirect()->route('offers.show', $company->id);

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
