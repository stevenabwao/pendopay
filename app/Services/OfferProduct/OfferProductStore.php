<?php

namespace App\Services\OfferProduct;

use App\Entities\Offer;
use App\Entities\Company;
use App\Entities\OfferProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OfferProductStore
{

    public function createItem($request) {

        $attributes = $request->all();

        $offer_price = "";
        $company_product_id = "";
        $offer_id = "";
        $status_id = "";

        if (array_key_exists('offer_price', $attributes)) {
            $offer_price = $attributes['offer_price'];
            $offer_price_display = format_num($offer_price);
        }
        if (array_key_exists('company_product_id', $attributes)) {
            $company_product_id = $attributes['company_product_id'];
        }
        if (array_key_exists('offer_id', $attributes)) {
            $offer_id = $attributes['offer_id'];
        }
        if (array_key_exists('status_id', $attributes)) {
            $status_id = $attributes['status_id'];
        }

        // get company product data
        $company_product_data = getCompanyProductData($company_product_id);
        $company_product_name = $company_product_data->product->name;
        $product_id = $company_product_data->product->id;
        $normal_price = $company_product_data->price;
        $normal_price_display = format_num($normal_price);

        // get offer data
        $offer_data = getOfferData($offer_id);
        $offer_name = $offer_data->name;
        $company_id = $offer_data->company->id;

        //start error checks
        // check if offer price is more than normal price
        if ($offer_price > $normal_price) {
            $response["error"] = true;
            $message['message'] = "Offer Price {{$offer_price_display}} cannot be more than products normal price {{$normal_price_display}}";
            return show_json_error($message);
        }

        // check if offer is still active
        if (!isOfferActive($offer_id)) {
            $response["error"] = true;
            $message['message'] = "Offer {{$offer_name}} is currently not active";
            return show_json_error($message);
        }

        //check if similar product exists for this offer
        if (isOfferProductExistsInOffer($offer_id, $company_product_id)) {
            $response["error"] = true;
            $message["message"] = "Product {{$company_product_name}} already exists in offer {{$offer_name}}. Please try another product";
            return show_json_error($message);
        }
        //end error checks

        DB::beginTransaction();

            //DB::enableQueryLog();

            // get discount percent
            $discount_percent = getOfferDiscountPercent($normal_price, $offer_price);

            // logged user
            $logged_user = getLoggedUser();
            $logged_user_names = getLoggedUserNames();

            // get attributes
            $attributes['offer_id'] = $offer_id;
            $attributes['company_product_id'] = $company_product_id;
            $attributes['product_id'] = $product_id;
            $attributes['company_id'] = $company_id;
            $attributes['normal_price'] = $normal_price;
            $attributes['offer_price'] = $offer_price;
            $attributes['status_id'] = $status_id;
            $attributes['discount_percent'] = $discount_percent;
            $attributes['created_by'] = $logged_user->id;
            $attributes['created_by_name'] = $logged_user_names;
            $attributes['updated_by'] = $logged_user->id;
            $attributes['updated_by_name'] = $logged_user_names;
            // dd($attributes);

            //start create new offer product
            try {

                $new_offer = new OfferProduct();
                $offer_result = $new_offer->create($attributes);

                // increment the number of offer products
                adjustNumOfferProducts($offer_id);

                // dd($offer_result);
                log_this(">>>>>>>>> SUCCESS CREATING OFFER PRODUCT :\n\n" . json_encode($offer_result) . "\n\n\n");
                $response["error"] = false;
                $response["message"] = $offer_result;

            } catch(\Exception $e) {

                DB::rollback();
                //dd($e);
                $message = $e->getMessage();
                log_this(">>>>>>>>> ERROR CREATING OFFER PRODUCT :\n\n" . $message . "\n\n\n");
                $response["error"] = true;
                $response["message"] = $message;
                return show_json_error($response);

            }
            //end create new offer

        DB::commit();


        return show_json_success($response);


    }

}
