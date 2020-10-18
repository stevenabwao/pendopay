<?php

namespace App\Services\GlAccount;

use App\Entities\GlAccount;
use App\Entities\CompanyProduct;
use App\Entities\GlAccountType;
use App\Entities\Company;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GlAccountUpdate
{

    use Helpers;

    public function updateItem($id, $attributes) {


        //dd($attributes);

        DB::beginTransaction();

        $gl_account_type_id = "";
        $company_product_id = "";
        $company_id = "";
        $status_id = "";
        $description = "";

        if (array_key_exists('gl_account_type_id', $attributes)) {
            $gl_account_type_id = $attributes['gl_account_type_id'];
        }
        if (array_key_exists('company_product_id', $attributes)) {
            $company_product_id = $attributes['company_product_id'];
        }
        if (array_key_exists('company_id', $attributes)) {
            $company_id = $attributes['company_id'];
        }
        if (array_key_exists('status_id', $attributes)) {
            $status_id = $attributes['status_id'];
        }
        if (array_key_exists('description', $attributes)) {
            $description = $attributes['description'];
        }

        //check if gl account already exists
        $gl_account_data = GlAccount::where('company_id', $company_id)
                                    ->where('gl_account_type_id', $gl_account_type_id)
                                    ->where('id', '!=', $id)
                                    ->first();
        
        if ($gl_account_data){
            $gl_account_type_data = GlAccountType::find($gl_account_type_id);
            $gl_account_type_description = $gl_account_type_data->description;
            $message = "$gl_account_type_description Gl Account already exists for company";
            return show_json_error($message);
        }
        //dd($gl_account_data);

        if ($company_product_id) {
            //get product id
            $company_product_data = CompanyProduct::find($company_product_id);
            $product_id = $company_product_data->product_id;
            $company_product_name = $company_product_data->name;

            //check if Gl Account type requires company_product_id 
            //i.e.loan_principal, loan_interest, interest_income, loan_charges, loan_penalty Gl Accts
            if (isValidCompanyGlAccountType($gl_account_type_id)) {

                //check if company product belongs to selected company
                if ($company_product_data->company_id == $company_id) {
                    $attributes['company_product_id'] = $company_product_id;
                    $attributes['product_id'] = $product_id;
                } else {
                    DB::rollback();
                    $company_data = Company::find($company_id);
                    $company_name = $company_data->name;
                    $message = "Company product ($company_product_name) must belong to company ($company_name)";
                    return show_json_error($message);
                }

            }else {

                $attributes['company_product_id'] = NULL;
                $attributes['product_id'] = NULL;
    
            }

        } else {

            $attributes['company_product_id'] = NULL;
            $attributes['product_id'] = NULL;

        }

        //save new record
        try {

            //dd($attributes);
            $existing_gl_account = new GlAccount();
            $result = $existing_gl_account->updatedata($id, $attributes);
            //dd($result);

            log_this(">>>>>>>>> SNB SUCCESS UPDATING GL ACCOUNT :\n\n" . json_encode($result) . "\n\n\n");
            $response["message"] = $result;

            $response = show_json_success($response);

         } catch(\Exception $e) { 

            //dd($e);
            DB::rollback();
            $message = $e->getMessage();
            return show_json_error($message);

        }

        DB::commit();

        return $response;

    }

}
