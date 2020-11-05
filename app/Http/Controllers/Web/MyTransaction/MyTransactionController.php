<?php

namespace App\Http\Controllers\Web\MyTransaction;

use App\Entities\ShoppingCartItem;
use App\Entities\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
    public function index(Request $request)
    {

        // get trans data
        $my_transactions = "";

        return view('_web.my-transactions.index', [
            'my_transactions' => $my_transactions
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

}
