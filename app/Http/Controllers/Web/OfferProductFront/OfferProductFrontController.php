<?php

namespace App\Http\Controllers\Web\OfferProductFront;

use App\Entities\CompanyProduct;
use App\Entities\Offer;
use App\Entities\Currency;
use App\Entities\OfferProduct;
use App\Entities\Status;
use App\Http\Controllers\Controller;
use App\Services\Offer\OfferStore;
use App\Services\Offer\OfferUpdate;
use App\Services\Offer\OfferShow;
use App\Services\OfferProduct\OfferProductIndex;
use App\Services\OfferProduct\OfferProductStore;
use Illuminate\Http\Request;
use Session;

class OfferProductFrontController extends Controller
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
     * Show a cart product details.
     */
    public function getCartProductDetails($id)
    {

        //get details for this item
        $offerproduct = $this->model->find($id);
        if($offerproduct) {
            // dd($offerproduct->min_quantity, $offerproduct->offer_price, $offerproduct->min_cost);
            return view('products.cart-product-details', compact('offerproduct'));
        } else {
            abort(404);
        }

    }

}
