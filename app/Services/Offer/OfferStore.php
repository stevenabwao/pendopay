<?php

namespace App\Services\Offer;

use App\Entities\Offer;
use App\Entities\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OfferStore
{

    public function createItem($request) {

        // $show_error = false;

        $attributes = $request->all();
        $response = [];

        // dd("attributes === ", $attributes);

        /* $current_date = getCurrentDate(1);

        $status_autodeclined = config('constants.status.autodeclined');
        $status_pending = config('constants.status.pending'); */

        $name = "";
        $company_id = "";
        $offer_frequency = "";
        $offer_day = "";
        $offer_expiry_method = "";
        $max_sales = "";
        $start_at = "";
        $end_at = "";
        $offer_type = "";
        $logged_user_id = NULL;
        $logged_user_names = "";

        if (array_key_exists('name', $attributes)) {
            $name = $attributes['name'];
        }
        if (array_key_exists('company_id', $attributes)) {
            $company_id = $attributes['company_id'];
        }
        if (array_key_exists('offer_frequency', $attributes)) {
            $offer_frequency = $attributes['offer_frequency'];
        }
        if (array_key_exists('offer_day', $attributes)) {
            $offer_day = $attributes['offer_day'];
        }
        if (array_key_exists('offer_expiry_method', $attributes)) {
            $offer_expiry_method = $attributes['offer_expiry_method'];
        }
        if (array_key_exists('max_sales', $attributes)) {
            $max_sales = $attributes['max_sales'];
        }
        if (array_key_exists('start_at', $attributes)) {
            $start_at = $attributes['start_at'];
        }
        if (array_key_exists('end_at', $attributes)) {
            $end_at = $attributes['end_at'];
        }
        if (array_key_exists('offer_type', $attributes)) {
            $offer_type = $attributes['offer_type'];
        }

        //start error checks
        if (($offer_frequency == "weekly") &&  (!$offer_day)) {
            $message = "Please select offer day";
            throw new \Exception($message);
        }

        if (($offer_expiry_method=="by_sales") && (!$max_sales)) {
            $message = "Please enter maximum drink sales quantity";
            throw new \Exception($message);
        }

        //check if similar offer name exists for this establishment
        $offer_name_exists_data = Offer::where('company_id', $company_id)
                                       ->where('name', $name)
                                       ->first();
        if ($offer_name_exists_data) {
            $message = "Offer with name: $name already exists. Please try another name  or add the offer date at the end of the name";
            throw new \Exception($message);
        }
        //end error checks

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

        // get permalink
        $permalink = getStrSlug($name);
        $attributes['permalink'] = $permalink;

        DB::beginTransaction();

            // DB::enableQueryLog();

            // start create new offer
            try {

                // dd($attributes);
                $new_offer = new Offer();
                $offer_result = $new_offer->create($attributes);
                // dd($offer_result);
                $response["error"] = false;
                $response["message"] = 'Successfully created offer - ' . $offer_result->name;
                $response["data"] = $offer_result;

            } catch(\Exception $e) {

                DB::rollback();
                //dd(DB::getQueryLog());
                //dd($e);
                $message = $e->getMessage();
                log_this(">>>>>>>>> ERROR CREATING OFFER VIA API :\n\n" . formatErrorJson($e) . "\n\n\n");
                throw new \Exception($message);

            }
            //end create new offer


            //save images if any
            if ($request->hasFile('item_image')) {

                // dd("item_image");

                //send request, image size and upload path
                $thumb_status = 1;
                $thumb_400_status = 1;
                $large_status = "";

                //upload images
                $base_path = "offers";
                try {
                    $item_images = storeItemImage($request, $base_path, $thumb_status, $thumb_400_status, $large_status);
                } catch(\Exception $e) {
                    $message = $e->getMessage();
                    log_this(">>>>>>>>> ERROR at storeItemImage in create OFFER :\n\n" . formatErrorJson($e) . "\n\n\n");
                    throw new \Exception($message);
                }
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
                try {
                    saveItemImage($offer_result, $caption, $image_section, $full_img, $thumb_img, $thumb_img_400);
                } catch(\Exception $e) {
                    $message = $e->getMessage();
                    log_this(">>>>>>>>> ERROR at saveItemImage in create OFFER :\n\n" . formatErrorJson($e) . "\n\n\n");
                    throw new \Exception($message);
                }

            }


        DB::commit();


        return show_success_response($response);


    }

}
