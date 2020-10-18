<?php

namespace App\Services\Admin\Product;

use App\Entities\Product;
use Illuminate\Support\Facades\DB;

class ProductStore
{

    public function createItem($request) {

        DB::beginTransaction();

            $name = "";
            $recommended_price = "";
            $description = "";

            if ($request->has('name')) {
                $name = $request->name;
                // get permalink
                $permalink = getStrSlug($name);
                $request->merge([
                    'permalink' => $permalink
                ]);
            }
            if ($request->has('description')) {
                $description = $request->description;
            }
            if ($request->has('recommended_price')) {
                $recommended_price = $request->recommended_price;
            }
            // dd($request);

            //start check if product data exists
            $product_data = Product::where('name', $name)->first();

            //if product record already exists, throw an error
            if ($product_data) {
                $message = "Product name already exists!!!";
                $response["error"] = true;
                $response["message"] = $message;
                return show_json_error($response);
                //throw new StoreResourceFailedException('Product name already exists!!!');
            }
            //end check if product data exists

            if (!$product_data) {

                //start create new local Product
                try {

                    $new_product = new Product();
                    //dump($attributes);
                    $product_result = $new_product->create($request->all());
                    //dd($product_result);

                    log_this(">>>>>>>>> SUCCESS CREATING PRODUCT :\n\n" . json_encode($product_result) . "\n\n\n");
                    $response["error"] = false;
                    $response["message"] = $product_result;

                } catch(\Exception $e) {

                    DB::rollback();
                    $message = $e->getMessage();
                    log_this(">>>>>>>>> ERROR CREATING PRODUCT :\n\n" . $message . "\n\n\n");
                    $response["error"] = true;
                    $response["message"] = $message;
                    return show_json_error($response);

                }
                //end create new local Product

            }

            //save images if any
            if ($request->hasFile('item_image')) {

                //send request, image size and upload path
                $thumb_status = 1;
                $thumb_400_status = 1;
                $large_status = 1;

                //upload images
                $base_path = "products";
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

                //save image paths to db
                $caption = $name;
                $image_section = "productimage";

                //save image(s) data
                saveItemImage($product_result, $caption, $image_section, $full_img, $thumb_img, $thumb_img_400);

            }


        DB::commit();

        return show_json_success($response);

    }

}
