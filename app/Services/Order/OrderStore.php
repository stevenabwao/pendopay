<?php

namespace App\Services\Order;

use App\Entities\Order;
use App\Entities\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderStore
{

    public function createItem($request) {

        //$show_error = false;

        $attributes = $request->all();

        dd($request, $attributes);

        /* $current_date = getCurrentDate(1);

        $status_autodeclined = config('constants.status.autodeclined');
        $status_pending = config('constants.status.pending'); */

        $qty = "";
        $company_product_id = "";
        $offer_id = "";

        if (array_key_exists('qty', $attributes)) {
            $qty = $attributes['qty'];
        }
        if (array_key_exists('company_product_id', $attributes)) {
            $company_product_id = $attributes['company_product_id'];
        }
        if (array_key_exists('offer_id', $attributes)) {
            $offer_id = $attributes['offer_id'];
        }

        //start get product price
        $company_product_price_data = CompanyProduct::find($company_product_id);
        $product_price = $company_product_price_data->price;
        //end get product price

        //get dates
        $start_at = handleFormDate($start_at);
        $end_at = handleFormDate($end_at);
        $attributes['start_at'] = $start_at;
        $attributes['end_at'] = $end_at;

        //calculate expiry at (11.59pm of previous day to start date)
        $start_at_obj = getGMTDate($start_at);
        $expiry_at = $start_at_obj->subMinutes(1);
        $expiry_at = $expiry_at->toDateTimeString();
        $attributes['expiry_at'] = $expiry_at;

        //check if it is an event type
        if ($offer_type == "one-time") {
            $offer_item_type = "event";
            $attributes['offer_type'] = $offer_item_type;
        }

        //get permalink
        $permalink = getStrSlug($name);
        $attributes['permalink'] = $permalink;

        //dd($attributes);


        DB::beginTransaction();


            DB::enableQueryLog();


            //start create new offer
            try {

                //dd($attributes);
                $new_offer = new Order();
                $offer_result = $new_offer->create($attributes);
                //dd($offer_result);
                //log_this(">>>>>>>>> SUCCESS CREATING COMPANY VIA API :\n\n" . json_encode($offer_result) . "\n\n\n");
                $response["error"] = false;
                $response["message"] = $offer_result;

            } catch(\Exception $e) {

                DB::rollback();
                //dd(DB::getQueryLog());
                //dd($e);
                $message = $e->getMessage();
                //log_this(">>>>>>>>> ERROR CREATING COMPANY VIA API :\n\n" . $message . "\n\n\n");
                $response["error"] = true;
                $response["message"] = $message;
                return show_json_error($response);

            }
            //end create new offer


            //save images if any
            if ($request->hasFile('item_image')) {

                //send request, image size and upload path
                $thumb_status = 1;
                $thumb_400_status = 1;
                $large_status = "";

                //upload images
                $base_path = "offers";
                $item_images = storeItemImage($request, $base_path, $thumb_status, $thumb_400_status, $large_status);
                $item_images = json_decode($item_images);
                //dd($item_images);

                $full_img = "";
                $thumb_img = "";
                $thumb_img_400 = "";

                if (isset($item_images->full_img)) {
                    $full_img = $item_images->full_img;
                }
                if (isset($item_images->thumb_img)) {
                    $thumb_img = $item_images->thumb_img;
                }
                if (isset($item_images->thumb_img_400)) {
                    $thumb_img_400 = $item_images->thumb_img_400;
                }
                //dd("below", $item_images, $current_image_data);

                //save image paths to db
                $caption = $name;
                $image_section = "offer";

                //save image(s)
                saveItemImage($offer_result, $caption, $image_section, $full_img, $thumb_img, $thumb_img_400);

            }


        DB::commit();


        return show_json_success($response);


    }

}
