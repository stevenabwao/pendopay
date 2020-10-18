<?php

namespace App\Http\Controllers\Web\ShoppingCart;

use App\Entities\ShoppingCart;
use App\Entities\Product;
use App\Entities\Company;
use App\Entities\Status;
use App\Services\ShoppingCart\ShoppingCartIndex;
use App\Services\ShoppingCart\ShoppingCartStore;
use App\Http\Controllers\Controller;
use App\Services\Payment\PaymentRequestStore;
use App\Services\Payment\PaymentStore;
use App\Services\ShoppingCartItem\ShoppingCartItemUpdate;
use Illuminate\Http\Request;
use Session;

class ShoppingCartController extends Controller
{

    /**
     */
    protected $model;

    /**
     * ShoppingCartController constructor.
     *
     * @param ShoppingCart $model
     */
    public function __construct(ShoppingCart $model)
    {
        $this->model = $model;

    }

    /**
     *
     * @param Request $request
     * @return mixed
    */
    public function index(Request $request)
    {

        // get shopping cart data
        $my_shopping_cart = getActiveUserShoppingCart();
        $my_shopping_cart_id = $my_shopping_cart->id;

        // get shopping cart items data
        $my_shopping_cart_items = getShoppingCartItems($my_shopping_cart_id);

        return view('my-shopping-cart.index', [
            'my_shopping_cart' => $my_shopping_cart,
            'my_shopping_cart_items' => $my_shopping_cart_items
        ]);

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
    public function store(Request $request, ShoppingCartStore $shoppingCartStore)
    {

        $this->validate($request, [
            'offer_product_id' => 'required',
            'offer_id' => 'required',
            'product_quantity_form' => 'required',
            'product_total_cost_form' => 'required'
        ]);

        //create item
        $shopping_cart = $shoppingCartStore->createItem($request->all());
        $shopping_cart = json_decode($shopping_cart);
        $result_message = $shopping_cart->message;
        // dd($shopping_cart, $result_message->message);

        if (!$shopping_cart->error) {
            $shopping_cart_message = $result_message->message;
            Session::flash('success', $shopping_cart_message);
            return redirect()->back()->with('add_cart', '1');
        } else {
            Session::flash('error', $result_message->message);
            return redirect()->back()->withInput()->withErrors($result_message->message);
        }

    }

    // review order
    public function reviewOrder(Request $request, ShoppingCartStore $shoppingCartStore)
    {

        // get shopping cart data
        $my_shopping_cart = getActiveUserShoppingCart();

        if ($my_shopping_cart) {

            $my_shopping_cart_id = $my_shopping_cart->id;

            // get shopping cart items data
            $my_shopping_cart_items = getShoppingCartItems($my_shopping_cart_id);

            return view('my-shopping-cart.review-order', [
                'my_shopping_cart' => $my_shopping_cart,
                'my_shopping_cart_items' => $my_shopping_cart_items
            ]);

        } else {

            // show error
            $message = "Invalid shopping cart found";
            Session::flash('error', $message);
            return redirect()->route('clubs');

        }

    }

    // make payment
    public function makePayment(Request $request, $id)
    {

        // get shopping cart data
        $logged_user= getLoggedUser();
        $logged_user_id = $logged_user->id;

        $statuses_array = array();
        $statuses_array[] = getStatusOrderPlaced();
        $statuses_array[] = getStatusActive();
        $my_shopping_cart = getShoppingCart("", "", $id, $statuses_array);

        if (!$my_shopping_cart) {
            // log error
            $message = "Invalid shopping cart. Userid - $logged_user_id. Accessed order id - $id";
            log_this($message);
            abort(404);
        }

        // get shopping cart items data
        $my_shopping_cart_items = getShoppingCartItems($id);

        // get paybill
        $site_settings = getSiteSettings();
        // barddy paybill
        $barddy_paybill_number = $site_settings['barddy_paybill_number'];

        return view('my-shopping-cart.make-payment', [
            'my_shopping_cart' => $my_shopping_cart,
            'my_shopping_cart_items' => $my_shopping_cart_items,
            'barddy_paybill' => $barddy_paybill_number
        ]);

    }

    public function makePaymentRequestStore(Request $request, PaymentRequestStore $paymentRequestStore)
    {

        $this->validate($request, [
            'phone_number' => 'required',
            'user_id' => 'required',
            'order_id' => 'required',
            'amount' => 'required',
        ]);
        // dd("request == ", $request);

        //create item
        $payment_result = $paymentRequestStore->createItem($request->all());
        $payment_result = json_decode($payment_result);
        $result_message = $payment_result->message;
        // dd($result_message->message, $payment_result->error);

        if (!$payment_result->error) {
            $payment_result_message = $result_message->message;
            Session::flash('success', $payment_result_message);
            return redirect()->route('payment-status', $request->order_id);
        } else {
            Session::flash('error', $result_message->message);
            return redirect()->back()->withInput()->withErrors($result_message->message);
        }

    }

    // make payment result
    public function makePaymentResult(Request $request, $id)
    {

        // get shopping cart data
        $logged_user= getLoggedUser();
        $logged_user_id = $logged_user->id;

        $statuses_array = array();
        $statuses_array[] = getStatusOrderPlaced();
        $statuses_array[] = getStatusActive();
        $my_shopping_cart = getShoppingCart("", "", $id, $statuses_array);
        // dd($my_shopping_cart);

        if (!$my_shopping_cart) {
            // log error
            $message = "Invalid shopping cart. Userid - $logged_user_id. Accessed order id - $id";
            log_this($message);
        }

        // get shopping cart items data
        $my_shopping_cart_items = getShoppingCartItems($id);

        return view('my-shopping-cart.payment-status', [
            'my_shopping_cart' => $my_shopping_cart,
            'my_shopping_cart_items' => $my_shopping_cart_items
        ]);

    }

    /**
     * @param Request $request
     * @return mixed
    */
    public function updateCartItems(Request $request, ShoppingCartItemUpdate $shoppingCartItemUpdate)
    {

        // dd($request);

        $this->validate($request, [
            'order_id_form' => 'required',
            'order_item_id_form' => 'required',
            'quantity_form' => 'required',
        ]);

        //create item
        $shopping_cart = $shoppingCartItemUpdate->updateItem($request->all());
        $shopping_cart = json_decode($shopping_cart);
        $result_message = $shopping_cart->message;
        // dd($shopping_cart, $result_message->message);

        if (!$shopping_cart->error) {
            $shopping_cart_message = $result_message->message;
            Session::flash('success', $shopping_cart_message);
            // return redirect()->back()->with('add_cart', '1');
            return redirect()->back();
        } else {
            Session::flash('error', $result_message->message);
            return redirect()->back()->withInput()->withErrors($result_message->message);
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
