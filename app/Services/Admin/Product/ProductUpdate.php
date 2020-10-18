<?php
namespace App\Services\Admin\Product;

use App\Entities\Product;
use Carbon\Carbon;
use IntImage;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductUpdate
{

    use Helpers;

    public function updateItem($id, $request, $base_path="products") {

        $name = "";
        $description = "";
        $recommended_price = "";
        $product_category_id = "";

        if ($request->has('name')) {
            $name = $request->name;
        }
        if ($request->has('description')) {
            $description = $request->description;
        }
        if ($request->has('recommended_price')) {
            $recommended_price = $request->recommended_price;
        }
        if ($request->has('product_category_id')) {
            $product_category_id = $request->product_category_id;
        }


        DB::beginTransaction();

        //get product data
        $product_data = Product::find($id);
        
        //update product data
        if ($product_data) {
            try {
                $product = new Product();
                $company_result = $product->updatedata($id, $request->all());
                $response["message"] = $company_result;
            } catch(\Exception $e) {
                DB::rollback();
                $message = "Could not update product info";
                $response["message"] = $message;
                return show_json_error($response);
            }
        }

        //save images if any
        if ($request->hasFile('item_image')) {

            // get item images
            $current_image_data = $product_data->images()->get();
            // dd($current_image_data);

            // delete existing images
            // before uploading new ones
            deleteCurrentImages($current_image_data);

            //send request, image size and upload path
            $thumb_status = 1;
            $thumb_400_status = 1;
            $large_status = 1;

            //upload images
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
            $image_section = "productimage";

            if (count($current_image_data)) {

                // update image data to db
                updateItemImage($id, $caption, $image_section, $full_img, $thumb_img, $thumb_img_400); 

            } else {

                // save new i-mage data to db
                saveItemImage($product_data, $caption, $image_section, $full_img, $thumb_img, $thumb_img_400); 

            }

        }

        DB::commit();

        return show_json_success($response);

    }

}
