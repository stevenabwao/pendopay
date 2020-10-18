<?php

namespace App\Services\Admin\CompanyProduct;

use App\Entities\CompanyProduct;
use App\Entities\Product;
use Illuminate\Support\Facades\DB;

class CompanyProductStore
{

    public function createItem($request) {

        DB::beginTransaction();

            $price = "";
            $product_id = $request->product_id;
            $company_id = $request->company_id;
            $product_category_id = $request->product_category_id;

            // get company data
            $company_data = getCompanyData($company_id);
            $company_name = $company_data->name;
            $company_id = $company_data->id;

            // get product data
            $product_data = getProductData($product_id);
            $product_name = $product_data->name;
            $product_id = $product_data->id;
            // generate product permalink
            /* $product_permalink = generatePermalink($company_id, $product_permalink);*/

            // logged user
            $logged_user = getLoggedUser();
            $logged_user_names = getLoggedUserNames();

            $request->merge([
                'created_by' => $logged_user->id,
                'created_by_name' => $logged_user_names,
                'updated_by' => $logged_user->id,
                'updated_by_name' => $logged_user_names
            ]);

            // check if product category id is same as main_category_id
            // if not, the user has probably changed the category id, so dont proceed
            if (!productCategoryIdsMatch($product_data, $product_category_id)) {
                $response["error"] = true;
                $message['message'] = "Please select product";
                return show_json_error($message);
            }
            //end check if product category id is same as main_category_id

            //start check if company product data exists
            if(isCompanyProductExists($product_id, $company_id)) {
                $response["error"] = true;
                $message['message'] = "Company product {{$product_name}} already exists in establishment {{$company_name}}";
                return show_json_error($message);
            }
            //end check if company product data exists

            //start create new company product
            try {

                $new_company_product = new CompanyProduct();
                // dd($request->all());
                $product_result = $new_company_product->create($request->all());

                log_this(">>>>>>>>> SUCCESS CREATING COMPANY PRODUCT :\n\n" . json_encode($product_result) . "\n\n\n");
                $response["error"] = false;
                $response["message_text"] = "Successfully created company product - " . $product_name;
                $response["message"] = $product_result;

            } catch(\Exception $e) {

                DB::rollback();
                $message = $e->getMessage();
                log_this(">>>>>>>>> ERROR CREATING COMPANY PRODUCT :\n\n" . $message . "\n\n\n");
                $response["error"] = true;
                $response["message"] = $message;
                return show_json_error($response);

            }
            //end create new company product


        DB::commit();

        return show_json_success($response);

    }

}
