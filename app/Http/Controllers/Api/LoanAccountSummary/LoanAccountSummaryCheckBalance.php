<?php

namespace App\Services\LoanAccountSummary;

use App\Entities\UserAccountInquiry;
use App\Entities\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanAccountSummaryCheckBalance
{

	public function getData($attributes)
	{

        //DB::enableQueryLog();

        //get params
        $phone = "";
        $the_account_no = "";

        if (array_key_exists('account_no', $attributes)) {
            $the_account_no = $attributes['account_no'];
        }
        if (array_key_exists('company_id', $attributes)) {
            $company_id = $attributes['company_id'];
        }
     
        try{
            $phone = getDatabasePhoneNumber($the_account_no);
        } catch (Exception $e) {
            $message = "Please enter correct phone number as the account no!";
            return show_json_error($message); 
        }

        //get authorised user
        $user = auth()->user();

        //start store user account inquiry history
        $userAccountHistory = new UserAccountInquiry();

		$userAccountHistoryData['user_id'] = $user->id;
        $userAccountHistoryData['first_name'] = $user->first_name;
        $userAccountHistoryData['last_name'] = $user->last_name;
        $userAccountHistoryData['phone'] = $phone;
        $userAccountHistoryData['section'] = "LoanBalanceInquiry";
		$userAccountHistoryData['company_id'] = $company_id;
        $userAccountHistoryData['created_by'] = $user->id;
        $userAccountHistoryData['updated_by'] = $user->id;

		$user_account_inquiry_entry = $userAccountHistory->create($userAccountHistoryData);
        //end store user account inquiry history

        //check if user belongs to company
        $account_data = DB::table('users')
            ->join('company_user', 'users.id', '=', 'company_user.user_id')
            ->select('*')
            ->where('company_user.company_id', $company_id)
            ->where('users.phone', $phone)
            ->first();

        //user does not exist, show error and return
        if (!$account_data) {

            $message = "Invalid user!!!";
            return show_json_error($message);

        } else {
        
     
            //get loans balancefrom yehuapi
            $loans_data = getLoansBalance($attributes);

            if ($loans_data) {
                $loans_data_decode = json_decode($loans_data);
                $loans_data_data = $loans_data_decode->data;

                //dd($loans_data_data);

                    /*{
                        "data": {
                            "bu_no": "350",
                            "bu_nm": "MIKINDURI",
                            "cust_nm": "Jane Mwonthea",
                            "acct_no": "10335011850206",
                            "acct_id": "1251110",
                            "acct_nm": "Jane Mwonthea - 31620",
                            "prod_id": "15",
                            "prod_desc": "Business Loan",
                            "crncy_cd_iso": "KES",
                            "disbursement_limit": "50000",
                            "cleared_bal": "18750.05",
                            "dr_int_accrued": "375.93",
                            "dr_accrued_to_maturity": "2770.833333333333333333333333333333333333",
                            "payoff_bal_fut_int": "21896.8133333333333333333333333333333333",
                            "payoff_bal_less_fut_int": "19125.98"
                        }
                    }
                    */

                //print_r(DB::getQueryLog());

                if (!$loans_data_data) {
                    $ledger_balance = 0;
                } else {
                    $ledger_balance = $loans_data_data->cleared_bal;
                }

                $acct_nm = $loans_data_data->acct_nm;
                $acct_no = $loans_data_data->acct_no;
                $bu_nm = $loans_data_data->bu_nm;
                $prod_desc = $loans_data_data->prod_desc;
                $disbursement_limit = $loans_data_data->disbursement_limit;

                $response["account_name"] = $acct_nm;
                $response["loans_account_number"] = $acct_no;
                $response["branch_name"] = $bu_nm;
                $response["prod_desc"] = $prod_desc;
                $response["disbursement_limit"] = $disbursement_limit;
                $response["ledger_balance"] = $ledger_balance;

                //start send sms to user
                $sms_type_id = config('constants.sms_types.company_sms');
                //get company_details
                $company = Company::find($company_id);
                $short_name = $company->name; 
                
                $message = "$short_name, \n\n";
                $message .= " Account Name: $acct_nm\n Loan Balance: $ledger_balance";
                $message .= "\n Branch Name: $bu_nm\n Product: $prod_desc";

                $result = createSmsOutbox($message, $phone, $sms_type_id, $company_id);
                //end send sms to user

                return show_json_success($response);

            } else {
                $message = "No loans data found!!!";
                return show_json_error($message);
            }

        }

	}

}