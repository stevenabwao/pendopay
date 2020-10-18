<?php
namespace App\Services\Company;

use App\Entities\Company;
use Carbon\Carbon;
use IntImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CompanyUpdate
{

    public function updateItem($id, $request) {

        $name = "";
        $phone = "";
        $personal_phone = "";
        $personal_email = "";
        $email = "";

        if ($request->has('name')) {
            $name = $request->name;
        }
        if ($request->has('phone')) {
            $phone = $request->phone;
        }
        if ($request->has('personal_phone')) {
            $personal_phone = $request->personal_phone;
        }
        if ($request->has('personal_email')) {
            $personal_email = $request->personal_email;
        }
        if ($request->has('email')) {
            $email = $request->email;
        }


        DB::beginTransaction();

        //start check data errors
        if ($phone) {
            try {
                $phone = getDatabasePhoneNumber($phone);
            } catch (\Exception $e) {
                //$message = $e->getMessage();
                $message = "Invalid company phone $phone";
                $response["message"] = $message;
                return show_json_error($response);
            }
        }

        if ($personal_phone) {
            try {
                $personal_phone = getDatabasePhoneNumber($personal_phone);
            } catch (\Exception $e) {
                //$message = $e->getMessage();
                $message = "Invalid personal phone $personal_phone";
                $response["message"] = $message;
                return show_json_error($response);
            }
        }

        if ($email) {
            if (!validateEmail($email)) {
                $message = "Invalid company email";
                $response["message"] = $message;
                return show_json_error($response);
            }
        }

        if ($personal_email) {
            if (!validateEmail($personal_email)) {
                $message = "Invalid personal email";
                $response["message"] = $message;
                return show_json_error($response);
            }
        }
        //end check data errors

        //get company data
        $company_data = Company::find($id);

        //update company data
        if ($company_data) {
            try {
                $company = new Company();
                $company_result = $company->updatedata($id, $request->all());
                $response["message"] = $company_result;
            } catch(\Exception $e) {
                DB::rollback();
                $message = "Could not update company info";
                $response["message"] = $message;
                return show_json_error($response);
            }
        }

        //save images if any
        if ($request->hasFile('item_image')) {

            // get item images
            $current_image_data = $company_data->images()->get();

            // delete existing images
            // before uploading new ones
            deleteCurrentImages($current_image_data);

            //send request, image size and upload path
            $thumb_status = 1;
            $thumb_400_status = 1;
            $large_status = 1;

            //upload images
            $base_path = "companies";
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
            $image_section = "companyimage";

            if (count($current_image_data)) {

                // update image data to db
                updateItemImage($id, $caption, $image_section, $full_img, $thumb_img, $thumb_img_400);

            } else {

                // save new image data to db
                saveItemImage($company_data, $caption, $image_section, $full_img, $thumb_img, $thumb_img_400);

            }

        }

        DB::commit();

        return show_json_success($response);

    }

}
