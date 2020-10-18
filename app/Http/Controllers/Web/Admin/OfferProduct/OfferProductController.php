<?php

namespace App\Http\Controllers\Web\Admin\OfferProduct;

use App\Entities\CompanyProduct;
use App\Entities\Offer;
use App\Entities\Currency;
use App\Entities\OfferProduct;
use App\Entities\Status;
use App\Http\Controllers\Controller;
use App\Services\Admin\CompanyProduct\CompanyProductIndex;
use App\Services\Offer\OfferStore;
use App\Services\Offer\OfferUpdate;
use App\Services\Offer\OfferShow;
use App\Services\OfferProduct\OfferProductIndex;
use App\Services\OfferProduct\OfferProductStore;
use Illuminate\Http\Request;
use Session;

class OfferProductController extends Controller
{

    /**
     * @var state
     */
    protected $model;

    /**
     *
     * @param OfferProduct $model
     */
    public function __construct(OfferProduct $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, OfferProductIndex $offerProductIndex)
    {

        if (isUserHasPermissions("1", ['read-offer'])) {

            //get the data
            $data = $offerProductIndex->getData($request);

            //are we in report mode? return get results
            if ($request->report) {

                $data = $data->get();

            }

            $statuses = Status::where("section", "LIKE", "%offerproducts%")->get();
            $companies = getUserCompanies();

            return view('_admin.offer-products.index', [
                'offerproducts' => $data,
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

            $offerproduct = "";

            //get logged in user
            $user = auth()->user();
            $companies = getUserCompanies();
            $statuses = Status::where('section','LIKE', '%product%')->get();
            $currencies = Currency::where('status_id', '1')->get();

            $start = 18;
            $end = 30;
            $age_ranges = generateAgeRangeArray($start, $end);

            //if user is superadmin, show all companies, else show a user's companies
            if (isSuperAdmin()) {
                //get details for this item
                $offerproduct = $this->model->find($id);
            } else {
                //get details for this item
                $companies_array = getUserCompanies();
                $offerproduct = $this->model->where('id', $id)
                                ->whereIn('company_id', $companies_array)
                                ->first();

            }

            if ($offerproduct) {

                return view('_admin.offer-products.show', compact('offerproduct', 'companies', 'statuses'));

            } else {

                abort(404);

            }

        }

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        // set defaults
        $mainCompany = "";
        $mainCompanyProduct = "";
        $mainOffer = "";
        $company_product = "";
        $companyproducts = [];
        $offers = [];
        $product_image = "";
        $statuses = Status::where('section', 'LIKE', '%product%')->get();
        $companies = getUserCompanies();

        // get main or selected product category
        if ($request->has('company_id_main')) {
            $mainCompany = getCompanyData($request->company_id_main);

            // get company products
            $companyproducts = $mainCompany->activecompanyproducts()->get();
            // dd($companyproducts);

            // get company offers
            $offers = getOffers("", "", "", "", "", $mainCompany->id);
            // dd("offers === ", $offers);
        }

        // get main or selected offer
        if ($request->has('offer_id_main')) {
            $mainOffer = getOfferData($request->offer_id_main);
        }

        // get main or selected product category
        if ($request->has('company_product_id_main')) {
            $mainCompanyProduct = getCompanyProductData($request->company_product_id_main);

            // get product image
            if ($mainCompanyProduct) {
                if (count($mainCompanyProduct->product->images)) {
                    $product_image = $mainCompanyProduct->product->images[0]->thumb_img_400;
                }
            }
        }

        return view('_admin.offer-products.create',
               compact('categories', 'statuses', 'products', 'companies',
                       'product_image', 'companyproducts', 'mainOffer', 'offers',
                       'mainCompanyProduct', 'mainCompany'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function createOfferProducts(Request $request, $offer_id)
    {

        // get main product submit
        $mainCompanyProduct = "";

        //get main or selected product
        if ($request->has('company_product_id_main')) {
            $mainCompanyProduct = getCompanyProductData($request->company_product_id_main);
        }

        $status_active = config("constants.status.active");
        $offer = getOfferData($offer_id);
        $company = $offer->company;
        // $company_id = $company->id;

        $companyproducts = $company->activecompanyproducts()->get();
        // dd($companyproducts);

        $statuses = Status::where('section','LIKE', '%offerproduct%')->get();
        $companies = getUserCompanies();
        $currencies = Currency::where('status_id', $status_active)->get();

        return view('_admin.offer-products.add-to-offer', [
            'offer' => $offer,
            'companyproducts' => $companyproducts,
            'statuses' => $statuses,
            'currencies' => $currencies,
            'companies' => $companies,
            'mainCompanyProduct' => $mainCompanyProduct
        ]);

    }

    /**
     * Show the form for saving a new resource.
     */
    public function storeOfferProducts(Request $request, $offer_id, OfferProductStore $offerProductStore)
    {

        $rules = [
            'offer_price' => 'required',
            'company_product_id' => 'required'
        ];

        $payload = app('request')->only('offer_price', 'company_product_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $request->merge([
            'offer_id' => $offer_id
        ]);

        //create item
        $offer_result = $offerProductStore->createItem($request);
        $offer_result = json_decode($offer_result);
        $result_message = $offer_result->message;

        if (!$offer_result->error) {
            $offer_product = $result_message->message;
            Session::flash('success', 'Successfully added product to offer');
            return redirect()->route('admin.offerproducts.index', ['offer_id' => $offer_product->offer_id]);
        } else {
            $message = $result_message->message;
            Session::flash('error', $message);
            return redirect()->back()->withInput()->withErrors($message);
        }

    }


    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request, OfferStore $offerStore)
    {

        $rules = [
            'name' => 'required',
            'company_id' => 'required',
            'status_id' => 'required',
            'offer_type' => 'required',
            'offer_frequency' => 'required',
            'offer_expiry_method' => 'required',
            'start_at' => 'required',
            'end_at' => 'required'
        ];

        $payload = app('request')->only('name', 'company_id', 'status_id', 'offer_type', 'offer_frequency',
                                        'offer_expiry_method', 'start_at', 'end_at');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //create item
        $offer_result = $offerStore->createItem($request);
        $offer_result = json_decode($offer_result);
        $result_message = $offer_result->message;

        if (!$offer_result->error) {
            $offer = $result_message->message;
            Session::flash('success', 'Successfully created offer - ' . $offer->name);
            return redirect()->route('_admin.offers.show', $offer->id);
        } else {
            $message = $result_message->message;
            Session::flash('error', $message);
            return redirect()->back()->withInput()->withErrors($message);
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
