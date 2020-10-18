<?php

namespace App\Services\Setting\LoanSetting;

use App\Entities\LoanProductSetting;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoanSettingUpdate
{

    use Helpers;

    public function updateItem($id, $attributes) {

        //dd($attributes);

        DB::beginTransaction();

        //save new record
        try {

            //start get sent params
            $minimum_contributions = "";
            $minimum_contributions_condition_id = "";
            $company_id = "";
            $company_product_id = "";
            $initial_exposure_limit = "";
            $increase_exposure_limit = "";
            $decrease_exposure_limit = "";
            $interest_method = "";
            $interest_type = "";
            $interest_amount = "";
            $loan_product_status = "";
            $loans_exceeding_limit = "";
            $loan_approval_method = "";
            $max_loan_limit = "";
            $loan_instalment_period = "";
            $loan_instalment_cycle = "";
            $loan_limit_calculation_id = "";
            $borrow_criteria = "";
            $max_loan_applications_per_day = "";
            $min_loan_limit = "";
            $initial_loan_limit = "";
            $one_month_limit = "";
            $one_to_three_month_limit = "";
            $three_to_six_month_limit = "";
            $above_six_month_limit = "";

            if (array_key_exists('minimum_contributions', $attributes)) {
                $minimum_contributions = $attributes['minimum_contributions'];
            }
            if (array_key_exists('minimum_contributions_condition_id', $attributes)) {
                $minimum_contributions_condition_id = $attributes['minimum_contributions_condition_id'];
            }
            if (array_key_exists('company_id', $attributes)) {
                $company_id = $attributes['company_id'];
            }
            if (array_key_exists('company_product_id', $attributes)) {
                $company_product_id = $attributes['company_product_id'];
            }
            if (array_key_exists('initial_exposure_limit', $attributes)) {
                $initial_exposure_limit = $attributes['initial_exposure_limit'];
            }
            if (array_key_exists('increase_exposure_limit', $attributes)) {
                $increase_exposure_limit = $attributes['increase_exposure_limit'];
            }
            if (array_key_exists('decrease_exposure_limit', $attributes)) {
                $decrease_exposure_limit = $attributes['decrease_exposure_limit'];
            }
            if (array_key_exists('interest_method', $attributes)) {
                $interest_method = $attributes['interest_method'];
            }
            if (array_key_exists('interest_type', $attributes)) {
                $interest_type = $attributes['interest_type'];
            }
            if (array_key_exists('interest_amount', $attributes)) {
                $interest_amount = $attributes['interest_amount'];
            }
            if (array_key_exists('loan_product_status', $attributes)) {
                $loan_product_status = $attributes['loan_product_status'];
            }
            if (array_key_exists('loans_exceeding_limit', $attributes)) {
                $loans_exceeding_limit = $attributes['loans_exceeding_limit'];
            }
            if (array_key_exists('loan_approval_method', $attributes)) {
                $loan_approval_method = $attributes['loan_approval_method'];
            }
            if (array_key_exists('max_loan_limit', $attributes)) {
                $max_loan_limit = $attributes['max_loan_limit'];
            }
            if (array_key_exists('loan_instalment_period', $attributes)) {
                $loan_instalment_period = $attributes['loan_instalment_period'];
            }
            if (array_key_exists('loan_instalment_cycle', $attributes)) {
                $loan_instalment_cycle = $attributes['loan_instalment_cycle'];
            }
            if (array_key_exists('loan_limit_calculation_id', $attributes)) {
                $loan_limit_calculation_id = $attributes['loan_limit_calculation_id'];
            }
            if (array_key_exists('borrow_criteria', $attributes)) {
                $borrow_criteria = $attributes['borrow_criteria'];
            }
            if (array_key_exists('max_loan_applications_per_day', $attributes)) {
                $max_loan_applications_per_day = $attributes['max_loan_applications_per_day'];
            }
            if (array_key_exists('min_loan_limit', $attributes)) {
                $min_loan_limit = $attributes['min_loan_limit'];
            }
            if (array_key_exists('initial_loan_limit', $attributes)) {
                $initial_loan_limit = $attributes['initial_loan_limit'];
            }
            if (array_key_exists('one_month_limit', $attributes)) {
                $one_month_limit = $attributes['one_month_limit'];
            }
            if (array_key_exists('one_to_three_month_limit', $attributes)) {
                $one_to_three_month_limit = $attributes['one_to_three_month_limit'];
            }
            if (array_key_exists('three_to_six_month_limit', $attributes)) {
                $three_to_six_month_limit = $attributes['three_to_six_month_limit'];
            }
            if (array_key_exists('above_six_month_limit', $attributes)) {
                $above_six_month_limit = $attributes['above_six_month_limit'];
            }
            //end get sent params

            $product_setting = LoanProductSetting::find($id);

            if ($product_setting) {

                $product_setting_name = $product_setting->companyproduct->product->name;

                //check
                if ($minimum_contributions && $minimum_contributions_condition_id) {
                    $min_contributions  = $minimum_contributions;
                    $min_contributions_condition_id  = $minimum_contributions_condition_id;
                }else {
                    $min_contributions  = NULL;
                    $min_contributions_condition_id  = NULL;
                }

                if ($borrow_criteria == "contributions") {
                    $min_contributions  = $minimum_contributions;
                    $min_contributions_condition_id  = $minimum_contributions_condition_id;
                }else {
                    $min_contributions  = NULL;
                    $min_contributions_condition_id  = NULL;
                }

                $result = $product_setting->update([
                                'company_id' => $company_id,
                                'company_product_id' => $company_product_id,
                                'initial_exposure_limit' => $initial_exposure_limit,
                                'increase_exposure_limit' => $increase_exposure_limit,
                                'decrease_exposure_limit' => $decrease_exposure_limit,
                                'interest_method' => $interest_method,
                                'interest_type' => $interest_type,
                                'interest_amount' => $interest_amount,
                                'loan_product_status' => $loan_product_status,
                                'loans_exceeding_limit' => $loans_exceeding_limit,
                                'loan_approval_method' => $loan_approval_method,
                                'max_loan_limit' => $max_loan_limit,
                                'loan_instalment_period' => $loan_instalment_period,
                                'loan_instalment_cycle' => $loan_instalment_cycle,
                                'loan_limit_calculation_id' => $loan_limit_calculation_id,
                                'borrow_criteria' => $borrow_criteria,
                                'minimum_contributions' => $min_contributions,
                                'minimum_contributions_condition_id' => $min_contributions_condition_id,
                                'max_loan_applications_per_day' => $max_loan_applications_per_day,
                                'min_loan_limit' => $min_loan_limit,
                                'initial_loan_limit' => $initial_loan_limit,
                                'one_month_limit' => $one_month_limit,
                                'one_to_three_month_limit' => $one_to_three_month_limit,
                                'three_to_six_month_limit' => $three_to_six_month_limit,
                                'above_six_month_limit' => $above_six_month_limit
                            ]);
                            //dd($result, $attributes);

                $response = "Successfully updated setting - " . $product_setting_name;

                $response = show_json_success($response);
            }

         } catch(\Exception $e) {

            DB::rollback();
            dd($e);
            $message = $e->getMessage();
            return show_json_error($message);

        }

        DB::commit();

        return $response;

    }

}
