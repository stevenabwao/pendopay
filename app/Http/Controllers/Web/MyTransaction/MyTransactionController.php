<?php

namespace App\Http\Controllers\Web\MyTransaction;

use App\Entities\ShoppingCart;
use App\Entities\Product;
use App\Entities\Company;
use App\Entities\ShoppingCartItem;
use App\Entities\Status;
use App\Services\ShoppingCart\ShoppingCartIndex;
use App\Services\ShoppingCart\ShoppingCartStore;
use App\Http\Controllers\Controller;
use App\Services\Payment\PaymentRequestStore;
use App\Services\Payment\PaymentStore;
use App\Services\ShoppingCartItem\ShoppingCartItemUpdate;
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
    public function index(Request $request)
    {

        // get trans data
        $my_transactions = "";

        return view('_web.my-transactions.index', [
            'my_transactions' => $my_transactions
        ]);

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
        $shopping_cart_id = $item->shopping_cart_id;
        // dd($shopping_cart_id);

        if ($item) {
            // update deleted by field
            // $item->update(['deleted_by' => $user_id]);
            $result = $item->delete();
        }

        // update shopping cart totals
        synchronizeSumTotalInCart($shopping_cart_id);

        return redirect()->back();

    }

}
