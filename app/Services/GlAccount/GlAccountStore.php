<?php

namespace App\Services\GlAccount;

use App\Entities\GlAccount;
use Illuminate\Support\Facades\DB;

class GlAccountStore
{

    public function createItem($attributes) {

        $response = [];

        DB::beginTransaction();

        $gl_account_type_id = "";
        $company_id = "";
        $description = "";

        if (array_key_exists('gl_account_type_id', $attributes)) {
            $gl_account_type_id = $attributes['gl_account_type_id'];
        }
        if (array_key_exists('company_id', $attributes)) {
            $company_id = $attributes['company_id'];
        }
        if (array_key_exists('description', $attributes)) {
            $description = $attributes['description'];
        }

        //check if gl account already exists
        try {
            $gl_account_data = GlAccount::where('company_id', $company_id)
                                    ->where('gl_account_type_id', $gl_account_type_id)
                                    ->first();
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        if ($gl_account_data){
            //error here
            $message = "Gl Account type already exists for company";
            // return show_json_error($message);
            throw new \Exception($message);
        }

        try {
            $gl_account_cd = get_gl_account_cd($gl_account_type_id);

            $next_gl_account_sequence = get_next_gl_account_sequence();
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        //mobile branch id
        try {
            $branch_id = "01";

            $next_gl_account_number = generate_gl_account_number($company_id, $branch_id, $gl_account_cd, $next_gl_account_sequence);
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        //dd($next_gl_account_number);

        //save new record
        try {

            if ($next_gl_account_number) {

                $gl_account = new GlAccount();

                $gl_account_attributes['gl_account_type_id'] = $gl_account_type_id;
                $gl_account_attributes['gl_account_sequence'] = $next_gl_account_sequence;
                $gl_account_attributes['gl_account_no'] = $next_gl_account_number;
                $gl_account_attributes['description'] = $description;
                $gl_account_attributes['company_id'] = $company_id;

                //dd($gl_account_attributes);

                $response['data'] = $gl_account->create($gl_account_attributes);

                $success_message = "Successfully created new GlAccount";
                $response['message'] = $success_message;

            } else {

                $message = "Gl Account could not be generated";
                // return show_json_error($message);
                throw new \Exception($message);

            }

         } catch(\Exception $e) {

            // dd($e);
            DB::rollback();
            $message = $e->getMessage();
            throw new \Exception($message);

        }

        DB::commit();

        return show_success_response($response);

    }

}
