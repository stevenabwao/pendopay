<?php

namespace App\Services\CompanyProduct;

use App\Entities\CompanyProduct;
use Illuminate\Support\Facades\DB;

class CompanyProductStore
{

    public function createItem($attributes) {

        DB::beginTransaction();

        $account_type_id = "";
        $company_id = "";
        $description = "";

        if (array_key_exists('account_type_id', $attributes)) {
            $account_type_id = $attributes['account_type_id'];
        }
        if (array_key_exists('company_id', $attributes)) {
            $company_id = $attributes['company_id'];
        }
        if (array_key_exists('description', $attributes)) {
            $description = $attributes['description'];
        }

        $gl_account_cd = get_gl_account_cd($account_type_id);

        $next_gl_account_sequence = get_next_gl_account_sequence($company_id);

        //mobile branch id
        $branch_id = "01";

        $next_gl_account_number = generate_gl_account_number($company_id, $branch_id, $gl_account_cd, $next_gl_account_sequence);

        //dd($next_gl_account_number);

        //save new record
        try {

            if ($next_gl_account_number) {

                $gl_account = new CompanyProduct();

                $gl_account_attributes['gl_account_type_id'] = $account_type_id;
                $gl_account_attributes['gl_account_sequence'] = $next_gl_account_sequence;
                $gl_account_attributes['gl_account_no'] = $next_gl_account_number;
                $gl_account_attributes['description'] = $description;
                $gl_account_attributes['company_id'] = $company_id;

                //dd($gl_account_attributes);

                $response = $gl_account->create($gl_account_attributes);

                $response = show_json_success($response);

            } else {

                $message = "Gl Account could not be generated";
                return show_json_error($message);

            }

         } catch(\Exception $e) {

            DB::rollback();
            $message = $e->getMessage();
            return show_json_error($message);

        }

        DB::commit();

        return $response;

    }

}
