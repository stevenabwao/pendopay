<?php

namespace App\Http\Controllers\Web\Admin\Offer;

use App\Entities\Offer;
use App\Entities\Currency;
use App\Entities\Status;
use App\Http\Controllers\Controller;
use App\Services\Offer\OfferIndex;
use App\Services\Offer\OfferStore;
use App\Services\Offer\OfferUpdate;
use Illuminate\Http\Request;
use Session;

class OfferController extends Controller
{

    /**
     * @var state
     */
    protected $model;

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
    public function index(Request $request, OfferIndex $offerIndex)
    {

        if (isUserHasPermissions("1", ['read-offer'])) {

            //get the data
            $data = $offerIndex->getData($request);

            //are we in report mode? return get results
            if ($request->report) {

                $data = $data->get();

            }

            $statuses = Status::where("section", "LIKE", "%offers%")->get();
            $companies = getUserCompanies();

            return view('_admin.offers.index', [
                'offers' => $data,
                'companies' => $companies,
                'statuses' => $statuses
            ]);

        } else {

            abort(503);

        }

    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        if (isUserHasPermissions("1", ['read-offer'])) {

            //get logged in user
            $user = auth()->user();
            $companies = getUserCompanies();
            $statuses = Status::where('section','LIKE', '%product%')->get();
            $currencies = Currency::where('status_id', '1')->get();

            $start = 18;
            $end = 30;
            $age_ranges = generateAgeRangeArray($start, $end);

            //if user is superadmin, show all companies, else show a user's companies
            if ($user->hasRole('superadministrator')) {
                //get details for this item
                $offer = $this->model->find($id);
            } else {
                //get details for this item
                $companies_array = getUserCompanies();
                $offer = $this->model->where('id', $id)
                                ->whereIn('company_id', $companies_array)
                                ->first();

            }
            // dd($offer);

            if ($offer) {

                return view('_admin.offers.show', compact('offer', 'companies', 'statuses', 'currencies', 'age_ranges'));

            } else {

                abort(404);

            }

        }

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $statuses = Status::where('section','LIKE', '%offer%')->get();
        $companies = getUserCompanies();
        $currencies = Currency::where('status_id', '1')->get();

        $start = 18;
        $end = 30;
        $age_ranges = generateAgeRangeArray($start, $end);
        //dd($age_ranges);

        return view('_admin.offers.create', compact('statuses', 'currencies', 'companies', 'age_ranges'));

    }


    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request, OfferStore $offerStore)
    {

        if (isUserHasPermissions("1", ['create-offer'])) {

            $this->validate($request, [
                'name' => 'required',
                'company_id' => 'required',
                'status_id' => 'required',
                'offer_type' => 'required',
                'offer_frequency' => 'required',
                'offer_expiry_method' => 'required',
                'start_at' => 'required',
                'end_at' => 'required|date|date_format:d-m-Y|after:start_at'
            ]);
            // dd($request->all());

            try {
                $item_result = $offerStore->createItem($request);
                $item_result = json_decode($item_result);
                $result_message = $item_result->message->message;
                // dd($result_message->message);

                $new_item = $result_message->data;
                $success_message = $result_message->message;
                Session::flash('success', $success_message);
                return redirect()->route('admin.offers.show', $new_item->id);
            } catch (\Exception $e) {
                $message = $e->getMessage();
                log_this($message);
                Session::flash('error', $message);
                return redirect()->back()->withInput()->withErrors($message);
            }

        } else {

            abort(404);

        }

    }

    public function edit($id)
    {

        $offer = Offer::findOrFail($id);
        //dd($offer);
        $statuses = Status::where('section','LIKE', '%offer%')->get();
        $companies = getUserCompanies();
        $currencies = Currency::where('status_id', '1')->get();

        $start = 18;
        $end = 30;
        $age_ranges = generateAgeRangeArray($start, $end);

        return view('_admin.offers.edit', compact('offer', 'statuses', 'currencies', 'companies', 'age_ranges'));

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function update(Request $request, $id, OfferUpdate $offerUpdate)
    {

        $offer = $this->model->findOrFail($id);
        //dd($request, $offer);

        $rules = [
            'name' => 'required',
            'company_id' => 'required',
            'status_id' => 'required',
            'offer_type' => 'required',
            'offer_frequency' => 'required',
            'offer_expiry_method' => 'required',
            'start_at' => 'required|date_format:d/m/Y H:i',
            'end_at' => 'required|date_format:d/m/Y H:i'
        ];

        $payload = app('request')->only('name', 'company_id', 'status_id', 'offer_type', 'offer_frequency',
                                        'offer_expiry_method', 'start_at', 'end_at');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            //dd($validator->errors());
            Session::flash('error', $validator->errors());
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //update item
        $offer_result = $offerUpdate->updateItem($id, $request);
        $offer_result = json_decode($offer_result);
        $result_message = $offer_result->message;

        if (!$offer_result->error) {
            $updated_offer = Offer::find($id);
            Session::flash('success', 'Successfully updated offer - ' . $updated_offer->name);
            return redirect()->route('admin.offers.show', $updated_offer->id);
        } else {
            $message = $result_message->message;
            Session::flash('error', $message);
            return redirect()->back()->withInput()->withErrors($message);
        }

    }

}
