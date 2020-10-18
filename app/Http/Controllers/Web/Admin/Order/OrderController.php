<?php

namespace App\Http\Controllers\Web\Admin\Order;

use App\Entities\Order;
use App\Entities\Company;
use App\Entities\Currency;
use App\Entities\Product;
use App\Entities\Status;
use App\Http\Controllers\Controller;
use App\Services\Order\OrderIndex;
use App\Services\Order\OrderStore;
use App\Services\Order\OrderShow;
use App\Services\Order\OrderItemStore;
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;

class OrderController extends Controller
{

    /**
     * @var state
     */
    protected $model;

    /**
     *
     * @param Order $model
     */
    public function __construct(Order $model)
    {
        $this->model = $model;

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, OrderIndex $orderIndex)
    {

        if (isUserHasPermissions("1", ['read-order'])) {

            //get the data
            $data = $orderIndex->getData($request);

            //are we in report mode? return get results
            if ($request->report) {

                $data = $data->get();

            }

            $statuses = Status::where("section", "LIKE", "%orders%")->get();
            $companies = getUserCompanies();
            // dd($companies);

            return view('_admin.orders.index', [
                'orders' => $data,
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

        if (isUserHasPermissions("1", ['read-order'])) {

            //get logged in user
            $user = auth()->user();
            $companies = getUserCompanies();
            $statuses = Status::where('section','LIKE', '%product%')->get();
            $currencies = Currency::where('status_id', '1')->get();

            $start = 18;
            $end = 30;
            $age_ranges = generateAgeRangeArray($start, $end);

            //if user is superadmin, show all orders, else show a user's orders
            if (isSuperAdmin()) {
                $order = $this->model->find($id);
            } else {
                $companies_array = getUserCompanies();
                $order = $this->model->where('id', $id)
                                ->whereIn('company_id', $companies_array)
                                ->first();

            }

            if ($order) {

                return view('_admin.orders.show', compact('order', 'companies', 'statuses', 'currencies', 'age_ranges'));

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

        $statuses = Status::where('section','LIKE', '%product%')->get();
        $companies = getUserCompanies();
        $currencies = Currency::where('status_id', '1')->get();

        return view('_admin.orders.create', compact('statuses', 'currencies', 'companies', 'age_ranges'));

    }


    /**
     * @param Request $request
     * @return mixed
    */
    public function store2(Request $request, OrderStore $orderStore)
    {

        $rules = [
            'name' => 'required',
            'company_id' => 'required',
            'status_id' => 'required',
            'order_type' => 'required',
            'order_frequency' => 'required',
            'order_expiry_method' => 'required',
            'start_at' => 'required',
            'end_at' => 'required'
        ];

        $payload = app('request')->only('name', 'company_id', 'status_id', 'order_type', 'order_frequency',
                                        'order_expiry_method', 'start_at', 'end_at');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //create item
        $order_result = $orderStore->createItem($request);
        $order_result = json_decode($order_result);
        $result_message = $order_result->message;

        if (!$order_result->error) {
            $order = $result_message->message;
            Session::flash('success', 'Successfully created order - ' . $order->name);
            return redirect()->route('_admin.orders.show', $order->id);
        } else {
            $message = $result_message->message;
            Session::flash('error', $message);
            return redirect()->back()->withInput()->withErrors($message);
        }

    }


    public function addItemToCart(Request $request, OrderItemStore $orderItemStore)
    {

        $rules = [
            'qty' => 'required',
            'company_product_id' => 'required',
            'offer_id' => 'required'
        ];

        $payload = app('request')->only('qty', 'company_product_id', 'offer_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //create item
        $order_item_result = $orderItemStore->createItem($request);
        $order_item_result = json_decode($order_item_result);
        $result_message = $order_item_result->message;

        if (!$order_item_result->error) {
            $order = $result_message->message;
            Session::flash('success', 'Successfully added item to order - ' . $order->id);
            return redirect()->route('_admin.orders.show', $order->id);
        } else {
            $message = $result_message->message;
            Session::flash('error', $message);
            return redirect()->back()->withInput()->withErrors($message);
        }

    }

    public function store(Request $request, OrderStore $orderStore)
    {

        $rules = [
            'qty' => 'required',
            'company_product_id' => 'required',
            'offer_id' => 'required'
        ];

        $payload = app('request')->only('qty', 'company_product_id', 'offer_id');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        //create item
        $order_result = $orderStore->createItem($request);
        $order_result = json_decode($order_result);
        $result_message = $order_result->message;

        if (!$order_result->error) {
            $order = $result_message->message;
            Session::flash('success', 'Successfully created order - ' . $order->id);
            return redirect()->route('_admin.orders.show', $order->id);
        } else {
            $message = $result_message->message;
            Session::flash('error', $message);
            return redirect()->back()->withInput()->withErrors($message);
        }

    }

    public function edit($id)
    {

        $product = Product::findOrFail($id);
        $statuses = Status::all();

        return view('manage.products.edit', compact('product', 'statuses'));

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function update(Request $request, $id)
    {

        $product = $this->model->findOrFail($id);

        $rules = [
            'product_cd' => 'required',
            'product_cat_ty' => 'required',
            'start_at' => 'required',
            'name' => 'required'
        ];

        $payload = app('request')->only('product_cd', 'product_cat_ty', 'start_at', 'name');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        // update fields
        $this->model->updatedata($id, $request->all());

        Session::flash('success', 'Successfully updated product - ' . $product->name);
        return redirect()->route('products.show', $product->id);

    }


    /**
     * @param Request $request
     * @param $id
     * @return mixed
    */
    public function destroy(Request $request, $id)
    {

        $user_id = auth()->user()->id;

        $item = $this->model->findOrFail($id);

        if ($item) {
            //update deleted by field
            $item->update(['deleted_by' => $user_id]);
            $result = $item->delete();
        }

        return redirect()->route('products.index');
    }


}
