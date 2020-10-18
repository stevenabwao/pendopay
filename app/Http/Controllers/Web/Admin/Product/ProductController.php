<?php

namespace App\Http\Controllers\Web\Admin\Product;

use App\Entities\Product;
use App\Entities\Category;
use App\Entities\ProductCategory;
use App\Entities\Status;
use App\Http\Controllers\Controller;
use App\Services\Admin\Product\ProductIndex;
use App\Services\Admin\Product\ProductStore;
use App\Services\Admin\Product\ProductUpdate;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
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
    public function index(Request $request, ProductIndex $productIndex)
    {

        if (isUserHasPermissions("1", ['read-company'])) {

            $status_active = config('constants.status.active');

            //get the data
            $data = $productIndex->getData($request);

            //are we in report mode? return get results
            if ($request->report) {

                $data = $data->get();

            }
            //dd($data);

            $statuses = Status::where("section", "LIKE", "%product%")->get();
            $categories = ProductCategory::where("status_id", $status_active)->get();

            return view('_admin.products.index', [
                'products' => $data,
                'categories' => $categories,
                'statuses' => $statuses
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
    public function create()
    {

        $categories = ProductCategory::all();
        $statuses = Status::where('section', 'LIKE', '%product%')->get();

        return view('_admin.products.create', compact('categories', 'statuses'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProductStore $productStore)
    {

        // validate input data
        $this->validate($request, [
            'name' => 'required',
            'product_category_id' => 'required',
            'item_image' => 'image|nullable|mimes:jpeg,gif,bmp,png,jpg|nullable|max:1999'
        ]);

        $product_result = $productStore->createItem($request);
        $product_result = json_decode($product_result);
        $result_message = $product_result->message;

        if (!$product_result->error) {
            $product = $result_message->message;
            Session::flash('success', 'Successfully created product - ' . $product->name);
            return redirect()->route('_admin.products.show', $product->id);
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

        $product = Product::find($id);

        //get product images
        if(count($product->images) > 0)
        {
            $images = $product->images;
        }
        //dd($images);

        return view('_admin.products.show', compact('product', 'images'));

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
        $product = Product::find($id);

        //get company images
        if(count($product->images) > 0)
        {
            $images = $product->images;
        }
        //dd($images);

        return view('_admin.products.edit', compact('product', 'images', 'categories', 'statuses'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, ProductUpdate $productUpdate)
    {

        //dd($id, $request);

        $user_id = auth()->user()->id;

        $product = Product::findOrFail($id);

        $rules = [
            'name' => 'required|max:255|unique:products,name,'.$product->id,
            'product_category_id' => 'required',
            'item_image' => 'image|nullable|mimes:jpeg,gif,bmp,png,jpg|max:1999'
        ];

        $payload = app('request')->only('name', 'product_category_id', 'item_image');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            Session::flash('error', $validator->errors());
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $product_result = $productUpdate->updateItem($id, $request, "products");
        $product_result = json_decode($product_result);
        $result_message = $product_result->message;

        if (!$product_result->error) {
            Session::flash('success', 'Successfully updated product - ' . $product->name);
            return redirect()->route('_admin.products.show', $product->id);
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
