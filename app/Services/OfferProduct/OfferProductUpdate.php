<?php
namespace App\Services\OfferProduct;

use App\Entities\Offer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;

class OfferProductUpdate
{

    public function updateItem($id, $request) {

        $attributes = $request->all();

        $name = "";
        $company_id = "";
        $offer_frequency = "";
        $offer_day = "";
        $offer_expiry_method = "";
        $max_sales = "";
        $start_at = "";
        $end_at = "";
        $offer_type = "";

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

        //dd($id, $request);
        
        //start error checks
        if (($offer_frequency == "weekly") &&  (!$offer_day)) {
            $message['message'] = "Please select offer day";
            return show_json_error($message);
        }

        if (($offer_expiry_method=="by_sales") && (!$max_sales)) {
            $message["message"] = "Please enter maximum drink sales quantity";
            return show_json_error($message);
        }

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

        //dd($attributes);

        DB::beginTransaction();


        //get offer data
        $offer_data = Offer::find($id);
        
        //update offer data
        if ($offer_data) {
            try {
                $offer = new Offer();
                $offer_result = $offer->updatedata($id, $attributes);
                $response["message"] = $offer_result;
            } catch(\Exception $e) {
                DB::rollback();
                $message = "Could not update offer info";
                //dd($e);
                $response["message"] = $message;
                return show_json_error($response);
            }
        }        

        //save images if any
        if ($request->hasFile('item_image')) {

            // get item images
            $current_image_data = $offer_data->images()->get();

            // delete existing images
            // before uploading new ones
            deleteCurrentImages($current_image_data);

            //send request, image size and upload path
            $thumb_status = 1;
            $thumb_400_status = 1;
            $large_status = 1;

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

            if (count($current_image_data)) {

                // update image data to db
                updateItemImage($id, $caption, $image_section, $full_img, $thumb_img, $thumb_img_400); 

            } else {

                // save new image data to db
                saveItemImage($offer_data, $caption, $image_section, $full_img, $thumb_img, $thumb_img_400); 

            }

        } 

        DB::commit();

        return show_json_success($response);

    }

}
