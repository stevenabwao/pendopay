<?php

namespace App\Http\Controllers\Web\MyTransaction;

use App\Entities\ShoppingCartItem;
use App\Entities\Status;
use App\Http\Controllers\Controller;
use App\Services\MyTransaction\MyTransactionIndex;
use App\Services\MyTransaction\MyTransactionStore;
use Illuminate\Http\Request;
use Session;

class MyTransactionController extends Controller
{

    /**
     */
    protected $model;

    /**
     * constructor.
     *
     * @param ShoppingCartItem $model
     */
    public function __construct(ShoppingCartItem $model)
    {
        $this->model = $model;
    }

    /**
     *
     * @param Request $request
     * @return mixed
    */
    public function index(Request $request, MyTransactionIndex $myTransactionIndex)
    {

        // get trans data
        $data = $myTransactionIndex->getData($request);

        //are we in report mode? return get results
        if ($request->report) {

            $data = $data->get();

        }

        $statuses = Status::where("section", "LIKE", "%trans%")->get();

        return view('_web.my-transactions.index', [
            'transactions' => $data,
            'statuses' => $statuses
        ]);

    }

    public function index2(Request $request)
    {

        // get trans data
        $my_transactions = "";

        return view('_web.my-transactions', [
            'my_transactions' => $my_transactions
        ]);

    }

    public function create(Request $request)
    {
        return view('_web.my-transactions.create');
    }

    public function store(Request $request, MyTransactionStore $myTransactionStore)
    {

        $this->validate($request, [
            'title' => 'required',
            'transaction_amount' => 'required',
            'transaction_date' => 'required|date|date_format:d-m-Y|after:yesterday',
            'transaction_role' => 'required',
            'terms' => 'required'
        ]);

        //create item
        try {
            $new_item = $myTransactionStore->createItem($request->all());
            $new_item = json_decode($new_item);
            $result = $new_item->message->message;
            $success_message = $result->message;
            $new_item_data = $result->data;
            // dd($new_item_data, $success_message);

            // check whether user is buyer or seller
            // display screen to ask user to enter details of buyer/ seller
            Session::flash('success', $success_message);
            return redirect(route('my-transactions.create-step2', [
                'new_item_data' => $new_item_data
            ]));

            /* return view('_web.my-transactions.create_step2', [
                'new_item_data' => $new_item_data
            ]); */

        } catch (\Exception $e) {

            $error_message = $e->getMessage();
            Session::flash('error', $error_message);
            return redirect()->back()->withInput()->withErrors($error_message);

        }

    }

    // ask user to select buyer/ seller
    public function create_step2(Request $request)
    {

        // dd($request->new_item_data);

        return view('_web.my-transactions.create_step2', ['new_item_data' => $request->new_item_data]);
    }

}
