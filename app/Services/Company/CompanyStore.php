<?php

namespace App\Services\Company;

use App\Entities\Company;
use App\Services\GlAccount\GlAccountStore;
use Illuminate\Support\Facades\DB;

class CompanyStore
{

    public function createItem($request) {

        DB::beginTransaction();

            $name = "";
            $personal_phone = "";
            $phone = "";
            $email = "";
            $personal_email = "";

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

            //check data
            if ($personal_phone) {
                try{
                    $personal_phone = getDatabasePhoneNumber($personal_phone);
                    $request['personal_phone'] = $personal_phone;
                } catch (\Exception $e) {
                    $message = "Error evaluating personal phone number - $personal_phone";
                    log_this($message);
                    throw new \Exception($message);
                }
            }

            if ($phone) {
                try{
                    $phone = getDatabasePhoneNumber($phone);
                    $request['phone'] = $phone;
                } catch (\Exception $e) {
                    $message = "Error evaluating company phone number - $phone";
                    log_this($message);
                    throw new \Exception($message);
                }
            }

            if ($email) {
                if (!validateEmail($email)) {
                    $message = "Invalid company email";
                    log_this($message);
                    throw new \Exception($message);
                }
            }

            if ($personal_email) {
                if (!validateEmail($personal_email)) {
                    $message = "Invalid personal email";
                    log_this($message);
                    throw new \Exception($message);
                }
            }

            // start check if company data exists
            try {

                $company_data = Company::where('name', $name)->first();

            } catch(\Exception $e) {

                log_this(formatErrorJson($e));
                $message = "Error locating company!!!";
                throw new \Exception($message);

            }

            // start check if company record already exists, throw an error
            if ($company_data) {
                $message = "Company name already exists!!!";
                log_this($message);
                throw new \Exception($message);
            }
            // end check if company data exists

            if (!$company_data) {

                $attributes = $request->all();

                // add permalink
                $attributes['permalink'] = getStrSlug($name);
                // dd("attributes === ", $attributes);

                //start create new local Company
                try {

                    $new_company = new Company();
                    $company_result = $new_company->create($attributes);
                    $company_id = $company_result->id;
                    $company_name = $company_result->name;

                    log_this(">>>>>>>>> SUCCESS CREATING COMPANY VIA API :\n\n" . json_encode($company_result) . "\n\n\n");
                    $response["error"] = false;
                    $response['data'] = $company_result;

                } catch(\Exception $e) {

                    DB::rollback();
                    $message = $e->getMessage();
                    log_this(">>>>>>>>> ERROR CREATING COMPANY VIA API :\n\n" . formatErrorJson($e) . "\n\n\n");
                    throw new \Exception($message);

                }
                //end create new local Company

            }

            //save images if any
            if ($request->hasFile('item_image')) {

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

                //save image(s)
                saveItemImage($company_result, $caption, $image_section, $full_img, $thumb_img, $thumb_img_400);

            }

            // start create company gl accounts
            $club_income_gl_account_type_id = getGlAccountTypeClubIncome();
            $club_refunds_gl_account_type_id = getGlAccountTypeClubRefunds();
            $club_expenses_gl_account_type_id = getGlAccountTypeClubExpenses();
            $club_withdrawals_gl_account_type_id = getGlAccountTypeClubWithdrawals();

            $company_gl_accounts_data = array();

            // Club income GL Account
            $arrayItem = array();
            $arrayItem["gl_account_type_id"] = $club_income_gl_account_type_id;
            $arrayItem["description"] = "$company_name Income GL Account";
            array_push($company_gl_accounts_data, $arrayItem);

            // Club refunds GL Account
            $arrayItem = array();
            $arrayItem["gl_account_type_id"] = $club_refunds_gl_account_type_id;
            $arrayItem["description"] = "$company_name Refunds GL Account";
            array_push($company_gl_accounts_data, $arrayItem);

            // Club expenses GL Account
            $arrayItem = array();
            $arrayItem["gl_account_type_id"] = $club_expenses_gl_account_type_id;
            $arrayItem["description"] = "$company_name Expenses GL Account";
            array_push($company_gl_accounts_data, $arrayItem);

            // Club withdrawals GL Account
            $arrayItem = array();
            $arrayItem["gl_account_type_id"] = $club_withdrawals_gl_account_type_id;
            $arrayItem["description"] = "$company_name Withdrawals GL Account";
            array_push($company_gl_accounts_data, $arrayItem);

            $array_items_result = array();
            $array_error_result = array();

            //loop thru array and create each GL Account
            foreach($company_gl_accounts_data as $company_gl_account_data) {

                $gl_account_attributes["description"] = $company_gl_account_data['description'];
                $gl_account_attributes["gl_account_type_id"] = $company_gl_account_data['gl_account_type_id'];
                // same for all GL Accounts
                $gl_account_attributes["company_id"] = $company_id;
                $gl_account_attributes["company_product_id"] = NULL;

                try {

                    //create gl account item
                    $glAccountStore = new GlAccountStore();
                    $new_gl_account = $glAccountStore->createItem($gl_account_attributes);
                    $new_gl_account = json_decode($new_gl_account);
                    $result_message = $new_gl_account->message;

                } catch(\Exception $e) {

                    DB::rollback();
                    $message = $e->getMessage();
                    log_this(">>>>>>>>> Barddy ERROR CREATING gl account :\n\n" . formatErrorJson($e) . "\n\n\n");
                    throw new \Exception($message);

                }

                $array_items_result[] = $company_gl_account_data['description'];

                if ($new_gl_account->error) {
                    $array_error_result[] = $result_message;
                }

            }

            // show result
            if(empty($array_error_result)){

                $success_message = 'Successfully created new company - ' . $company_name;
                $gl_accounts_created_data = implode(", <br>", $array_items_result);
                $success_message .= '<br>Also created the following GL Accounts:<br>' . $gl_accounts_created_data;
                $response['message'] = $success_message;

            } else {

                DB::rollback();
                $message = implode("\n", $array_error_result);
                log_this(formatErrorJson($message));
                throw new \Exception($message);

            }
            // end create company gl accounts


        DB::commit();

        return show_success_response($response);

    }

}
