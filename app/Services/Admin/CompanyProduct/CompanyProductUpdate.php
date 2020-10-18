<?php
namespace App\Services\Admin\CompanyProduct;

use App\Entities\CompanyProduct;
use Illuminate\Support\Facades\DB;

class CompanyProductUpdate
{

    public function updateItem($id, $request) {

        $price = "";
        $status_id = "";

        if ($request->has('price')) {
            $price = $request->price;
        }
        if ($request->has('status_id')) {
            $status_id = $request->status_id;
        }

        DB::beginTransaction();

        //get product data
        $product_data = CompanyProduct::find($id);
        $response = [];

        //update product data
        if ($product_data) {

            try {

                $company_product = new CompanyProduct();
                $company_product_result = $company_product->updatedata($id, $request->all());
                $response["message"] = $company_product_result;

            } catch(\Exception $e) {

                DB::rollback();
                $message = "Could not update company product info";
                $response["message"] = $message;
                return show_json_error($response);

            }

        }

        DB::commit();

        return show_json_success($response);

    }

}
