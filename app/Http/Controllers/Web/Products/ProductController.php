<?php

namespace App\Http\Controllers\Web\Products;

use App\Entities\Product;
use App\Entities\Status;
use App\Services\Product\ProductIndex;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;

class ProductController extends Controller
{
    
    /**
     * @var state
     */
    protected $model;

    /**
     * LoanApplicationController constructor.
     *
     */
    public function __construct(Product $model)
    {
        $this->model = $model;

    }

    /**
     *
     * @param Request $request
     * @return mixed
    */
    public function index(Request $request, ProductIndex $productIndex)
    {

        /*start cache settings*/
        $url = request()->url();
        $params = request()->query();
        $fullUrl = getFullCacheUrl($url, $params);
        $minutes = getCacheDuration('low'); 
        /*end cache settings*/

        //get the data
        $data = $productIndex->getProducts($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get(); 

        }

        //return cached data or cache if cached data not exists
        //return Cache::remember($fullUrl, $minutes, function () use ($data) {
            return view('manage.products.index', [
                'products' => $data->appends(Input::except('page'))
            ]);
        //});

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $statuses = Status::all();

        return view('manage.products.create', compact('statuses'));

    }

    /**
     * @param $id
     * @return mixed
    */
    public function show($id)
    {
        $product = $this->model->findOrFail($id);

        //Log::info('product ', $product->toArray());
        
        return view('manage.products.show', compact('product'));

    }

    /**
     * @param Request $request
     * @return mixed
    */
    public function store(Request $request)
    {

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

        //create item
        $product = $this->model->create($request->all());

        Session::flash('success', 'Successfully created new product - ' . $product->name);
        return redirect()->route('products.index');

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
