<?php

namespace App\Http\Controllers\Web\Admin\CompanyProduct;

use App\Entities\CompanyProduct;
use App\Entities\Product;
use App\Entities\ProductCategory;
use App\Entities\Status;
use App\Http\Controllers\Controller;
use App\Services\Admin\CompanyProduct\CompanyProductIndex;
use App\Services\Admin\CompanyProduct\CompanyProductStore;
use App\Services\Admin\CompanyProduct\CompanyProductUpdate;
use Session;
use Illuminate\Http\Request;

class CompanyProductController extends Controller
{

    /**
     * @var state
     */
    protected $model;

    /**
     *
     * @param CompanyProduct $model
     */
    public function __construct(CompanyProduct $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, CompanyProductIndex $companyProductIndex)
    {

        if (isUserHasPermissions("1", ['read-company-product'])) {

            $status_active = config('constants.status.active');

            //get the data
            $data = $companyProductIndex->getData($request);

            //are we in report mode? return get results
            if ($request->report) {

                $data = $data->get();

            }
            // dd($data);

            $statuses = Status::where("section", "LIKE", "%product%")->get();
            $categories = ProductCategory::where("status_id", $status_active)->get();
            $companies = getUserCompanies();

            return view('_admin.company-products.index', [
                'companyproducts' => $data,
                'categories' => $categories,
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

        // set defaults
        $mainCompany = "";
        $mainProductCategory = "";
        $mainProduct = "";
        $company_product = "";

        $products = [];
        $product_image = "";
        $categories = ProductCategory::all();
        $statuses = Status::where('section', 'LIKE', '%product%')->get();
        $companies = getUserCompanies();

        // get main or selected product category
        if ($request->has('company_id_main')) {
            $mainCompany = getCompanyData($request->company_id_main);
        }

        // get main or selected product category
        if ($request->has('product_category_id_main')) {
            $mainProductCategory = getProductCategoryData($request->product_category_id_main);

            // get products
            $product_category_id = $request->product_category_id_main;
            $products = Product::where("product_category_id", $product_category_id)->get();
        }

        // get main or selected product
        if ($request->has('product_id_main')) {
            $mainProduct = getProductData($request->product_id_main);

            // assign product image if it exists
            // check if product category id is same as main_category_id
            // if not, the user has probably changed the category id, so dont show image
            // also clear product id in the lower form
            if ($mainProduct && productCategoryIdsMatch($mainProduct, $product_category_id)) {
                if (count($mainProduct->images)) {
                    $product_image = $mainProduct->images[0]->thumb_img_400;
                }
            }
        }

        return view('_admin.company-products.create',
               compact('categories', 'statuses', 'products', 'companies', 'product_image', 'mainProductCategory', 'mainCompany', 'mainProduct'));

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CompanyProductStore $companyProductStore)
    {

        // validate input data
        $this->validate($request, [
            'price' => 'numeric|required',
            'product_category_id' => 'required',
            // 'product_id_main' => 'required',
            'product_id' => 'required',
            'company_id' => 'required',
            'status_id' => 'required'
        ]);

        // dd($request);

        $company_product_result = $companyProductStore->createItem($request);
        $company_product_result = json_decode($company_product_result);
        $result_message = $company_product_result->message;
        // $result_message_text = $company_product_result->message_text;

        if (!$company_product_result->error) {
            $company_product = $result_message->message;
            $company_product_data = getCompanyProductData($company_product->id);
            $response_message = "Successfully created company product - {" . $company_product_data->product->name . "}";
            if ($company_product_data->company) {
                $response_message .= " for establishment {" . $company_product_data->company->name . "}";
            }
            Session::flash('success', $response_message);
            // return redirect()->route('admin.companyproducts.show', $company_product->id);
            return redirect()->route('admin.companyproducts.index', ['companies' => $company_product_data->company->id]);
        } else {
            $message = $result_message->message;
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

        $images = [];
        $product = "";

        $companyproduct = CompanyProduct::find($id);

        if ($companyproduct) {

            if ($companyproduct->product) {
                $product = $companyproduct->product;
            }

            //get product images
            if(count($product->images) > 0)
            {
                $images = $product->images;
            }
            // dd($images);

        }

        return view('_admin.company-products.show', compact('companyproduct', 'product', 'images'));

    }

    // show company product
    public function showCompanyProduct(Request $request)
    {

        $this->validate($request, [
            'product_id' => 'required',
            'company_id' => 'required'
        ]);

        $images = [];
        $product = "";
        $companyproduct = "";

        if (($request->has('product_id')) && ($request->has('company_id'))) {

            $product_id = $request->product_id;
            $company_id = $request->company_id;

            $companyproduct = CompanyProduct::where('product_id', $product_id)
                                            ->where('company_id', $company_id)
                                            ->first();

            if ($companyproduct) {

                $product = $companyproduct->product;

                //get product images
                if(count($product->images) > 0)
                {
                    $images = $product->images;
                }
                //dd($images);

            }

        } else {

            abort(404, "Please supply both company id and product id to proceed");

        }


        return view('_admin.company-products.show', compact('companyproduct', 'product', 'images'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $images = [];

        $categories = ProductCategory::all();
        $statuses = Status::where('section', 'LIKE', '%product%')->get();
        $companyproduct = CompanyProduct::find($id);
        $product = $companyproduct->product;

        //get company images
        if(count($product->images) > 0)
        {
            $images = $product->images;
        }
        //dd($images);

        return view('_admin.company-products.edit', compact('companyproduct', 'product', 'images', 'categories', 'statuses'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, CompanyProductUpdate $companyProductUpdate)
    {

        //dd($id, $request);

        $user_id = auth()->user()->id;

        $companyproduct = CompanyProduct::findOrFail($id);

        $rules = [
            'status_id' => 'required'
        ];

        $payload = app('request')->only('status_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            Session::flash('error', $validator->errors());
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $product_result = $companyProductUpdate->updateItem($id, $request);
        $product_result = json_decode($product_result);
        $result_message = $product_result->message;

        if (!$product_result->error) {
            Session::flash('success', 'Successfully updated company product - ' . $companyproduct->product->name);
            return redirect()->route('admin.companyproducts.show', $companyproduct->id);
        } else {
            $message = $result_message->message;
            Session::flash('error', $message);
            return redirect()->back()->withInput()->withErrors($message);
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
