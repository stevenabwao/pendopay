<?php

namespace App\Http\Controllers\Web\CompanyProduct;

use App\Entities\CompanyProduct;
use App\Entities\Product;
use App\Entities\Company;
use App\Entities\Status;
use App\Services\CompanyProduct\CompanyProductIndex;
use App\Services\CompanyProduct\CompanyProductStore;
//use App\Services\CompanyProduct\CompanyProductUpdate;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;

class CompanyProductController extends Controller
{

    /**
     */
    protected $model;

    /**
     * CompanyProductController constructor.
     *
     * @param CompanyProduct $model
     */
    public function __construct(CompanyProduct $model)
    {
        $this->model = $model;

    }

    /**
     *
     * @param Request $request
     * @return mixed
    */
    public function index(Request $request, CompanyProductIndex $companyProductIndex)
    {

        if (isUserHasPermissions("1", ['read-company-product'])) {

            //get the data
            $data = $companyProductIndex->getData($request);

            //are we in report mode? return get results
            if ($request->report) {

                $data = $data->get();

            }

            return view('manage.companyproducts.index', [
                'companyproducts' => $data
            ]);

        } else {

            abort(503);

        }

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        if (isUserHasPermissions("1", ['create-company-product'])) {

            $statuses = Status::all();
            $companies = getUserCompanies($request);
            $products = Product::where('status_id', '1')->get();

            return view('manage.companyproducts.create', compact('statuses', 'products', 'companies'));

        } else {

            abort(503);

        }

    }

    /**
     * @param $id
     * @return mixed
    */
    public function show($id)
    {
        if (isUserHasPermissions("1", ['read-company-product'])) {

            $companyproduct = $this->model->findOrFail($id);

            return view('manage.companyproducts.show', compact('companyproduct'));

        } else {

            abort(503);

        }

    }

    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request, CompanyProductStore $companyProductStore)
    {

        if (isUserHasPermissions("1", ['create-company-product'])) {

            $rules = [
                'name' => 'required',
                'product_id' => 'required',
                'company_id' => 'required',
                'status_id' => 'required'
            ];

            $payload = app('request')->only('name', 'product_id', 'company_id', 'status_id');

            $validator = app('validator')->make($payload, $rules);

            if ($validator->fails()) {
                //dd($validator->errors());
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }
            //dd($request);

            //create item
            $companyproduct = $companyProductStore->createItem($request->all());
            $companyproduct = json_decode($companyproduct);
            $result_message = $companyproduct->message;
            //dd($companyproduct, $result_message->message);

            if (!$companyproduct->error) {
                $companyproduct_message = $result_message->message;
                Session::flash('success', $companyproduct_message);
                return redirect()->route('companyproducts.index');
            } else {
                Session::flash('error', $result_message->message);
                return redirect()->back()->withInput()->withErrors($result_message->message);
            }

        } else {

            abort(503);

        }

    }

    public function edit($id, Request $request)
    {

        if (isUserHasPermissions("1", ['update-company-product'])) {

            $companyproduct = $this->model->findOrFail($id);
            $statuses = Status::all();
            $companies = getAllUserCompanies($request);
            $products = Product::where('status_id', '1')->get();

            return view('manage.companyproducts.edit', compact('companyproduct', 'companies', 'statuses', 'products'));

        } else {

            abort(503);

        }

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function update(Request $request, $id)
    {

        if (isUserHasPermissions("1", ['update-company-product'])) {

            $thiscompanyproduct = $this->model->findOrFail($id);

            $rules = [
                'name' => 'required',
                'product_id' => 'required',
                'company_id' => 'required',
                'status_id' => 'required'
            ];

            $payload = app('request')->only('name', 'product_id', 'company_id', 'status_id');

            $validator = app('validator')->make($payload, $rules);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            //start check if similar product already exists for company
            $companyproduct = $this->model->where('product_id', $request->product_id)
                                          ->where('company_id', $request->company_id)
                                          ->where('id', '!=', $id)
                                          ->first();

            if ($companyproduct) {
                $company = Company::find($request->company_id);
                $product = Product::find($request->product_id);
                //throw error back
                $error_msg = "Product of type " . $product->name . " already exists for " . $company->name;
                Session::flash('error', $error_msg);
                return redirect()->back()->withInput();
            }
            //end check if product already exists for company

            // update fields
            $this->model->updatedata($id, $request->all());

            Session::flash('success', 'Successfully updated company product - ' . $thiscompanyproduct->name);
            return redirect()->route('companyproducts.show', $thiscompanyproduct->id);

        } else {

            abort(503);

        }

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function destroy(Request $request, $id)
    {


        if (isUserHasPermissions("1", ['delete-company-product'])) {

            $user_id = auth()->user()->id;

            $item = $this->model->findOrFail($id);

            if ($item) {
                //update deleted by field
                $item->update(['deleted_by' => $user_id]);
                $result = $item->delete();
            }

            return redirect()->route('companyproducts.index');

        } else {

            abort(503);

        }

    }

}
