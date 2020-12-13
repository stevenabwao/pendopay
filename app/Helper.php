<?php

use App\Entities\Account;
use App\Entities\DepositAccount;
use App\Entities\TransactionAccount;
use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\Offer;
use App\Entities\OfferProduct;
use App\Entities\MpesaPaybill;
use App\Entities\Product;
use App\Entities\ProductCategory;
use App\Entities\SmsOutbox;
use App\Entities\ConfirmCode;
use App\Entities\UserAccessToken;
use App\Entities\LoanProductSetting;
use App\Entities\LoanAccount;
use App\Entities\DepositAccountSummary;
use App\Entities\TransactionAccountSummary;
use App\Entities\LoanExposureLimit;
use App\Entities\UserAccountInquiry;
use App\Entities\LoanRepaymentSchedule;
use App\Entities\LoanApplication;
use App\Entities\CompanyProduct;
use App\Entities\County;
use App\Entities\ReminderMessage;
use App\Entities\ReminderMessageDetail;
use App\Entities\SharesAccountSummary;
use App\Entities\MpesaB2CTopupLevel;
use App\Entities\SiteContent;
use App\Entities\ShoppingCart;
use App\Entities\ShoppingCartItem;
use App\Entities\StkpushRequest;
use App\Entities\Image;
use App\Entities\Till;
use App\Entities\Order;
use App\Entities\OrderItem;
use App\Entities\Invoice;
use App\Entities\MediaTemplate;
use App\Entities\PasswordReset;
use App\Entities\Payment;
use App\Entities\CommissionScale;
use App\Entities\Transaction;
use App\Entities\TransactionRequest;
use App\Entities\UserNotification;
use App\Entities\PaymentMethod;
use App\Events\LoanApplicationUpdated;
use App\Services\EmailQueue\EmailQueueStore;
use App\Mail\ReminderMessageEmail;
use App\Services\Deposit\DepositStore;
use App\Services\Payment\PaymentGlAccountsStore;
use App\Services\Offer\OfferIndex;
use App\Services\Offer\OfferFrontIndex;
use App\Services\OfferProduct\OfferProductIndex;
use App\Services\OfferProduct\OfferProductFrontIndex;
use App\Services\Company\CompanyIndex;
use App\User;
use Carbon\Carbon;
// use IntImage;
// use IntImage\IntImage;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Maatwebsite\Excel\Facades\Excel;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Validator;

// get site settings
function getSiteSettings() {
 return app()->site_settings;
}

//current date and time
function getCurrentDate($datetime=false) {

	$date = Carbon::now();
	$thedate = getLocalDate($date);
	// $thedate = getGMTDate($date);

	if ($datetime){
		$date = $thedate->toDateTimeString();
	} else {
		$date = $thedate->toDateString();
	}

	return $date;

}

// created date and time
function getCreatedDate() {

    // for record updates
    return getCurrentDate(1);

}

// updated date and time
function getUpdatedDate() {

    return getCurrentDateObj();

}

//handle form date and time
function handleFormDate($date) {

	$date_obj = getGMTDate($date);
	$date_result = $date_obj->toDateTimeString();

	return $date_result;

}

//current date and time
function getCurrentLocalDate($datetime=false) {

    $thedate = Carbon::now();
    //$thedate = getGMTDate($date);

    if ($datetime){
        $date = $thedate->toDateTimeString();
    } else {
        $date = $thedate->toDateString();
    }

    return $date;

}

//current date and time object
function getCurrentDateObj() {

	$date = Carbon::now();
	$thedate = getGMTDate($date);

	return $thedate;

}

// get date difference between two dates
function getDateDiff($start_date, $end_date="", $interval="year", $date_format="d-m-Y") {

    $return_value = "";

    $end_date = $end_date ? $end_date : "";
    $interval = $interval ? $interval : "year";
    $date_format = $date_format ? $date_format : "d-m-Y";

    // start date
    $start_date = createCarbonDate($start_date, $date_format);
    // dd($start_date);

    // get end date
    if ($end_date) {
        $end_date = createCarbonDate($end_date, $date_format);
        $end_date = getLocalDate($end_date);
    } else {
        $end_date = getLocalDate(getCurrentUTCDate());
    }
    // dd($end_date);

    // get the date difference
    if ($interval == "year") {
        $return_value = $end_date->diffInYears($start_date);
    } else if ($interval == "month") {
        $return_value = $end_date->diffInMonths($start_date);
    } else if ($interval == "week") {
        $return_value = $end_date->diffInWeeks($start_date);
    } else if ($interval == "day") {
        $return_value = $end_date->diffInDays($start_date);
    } else if ($interval == "hour") {
        $return_value = $end_date->diffInHours($start_date);
    } else if ($interval == "minute") {
        $return_value = $end_date->diffInMinutes($start_date);
    } else if ($interval == "second") {
        $return_value = $end_date->diffInSeconds($start_date);
    } else {
        $return_value = $end_date->diffInYears($start_date);
    }

    return $return_value;

}

//split on 1+ whitespace & ignore empty (eg. trailing space)
function getSplitTerms($term) {

	$split_terms = preg_split('/\s+/', $term, -1, PREG_SPLIT_NO_EMPTY);

	return $split_terms;

}

//get email domain name
function getEmailDomainName($email) {

	$domain_name = substr(strrchr($email, "@"), 1);

	//remove domain extension
	$result = preg_split('/(?=\.[^.]+$)/', $domain_name);

	return $result[0];

}

function isAdmin() {
    if (isLoggedIn()) {
        if (getLoggedUser()->hasRole('administrator')) {
            return true;
		}
        return false;
    } else {
        return false;
    }
}

function isSuperadmin() {
    if (isLoggedIn()) {
        if (getLoggedUser()->hasRole('superadministrator')) {
            return true;
        }
        return false;
    } else {
        return false;
    }
}

function isAdminPanelAvailable() {
    if (isLoggedIn()) {
        if ((getLoggedUser()->is_super_admin==1) || (getLoggedUser()->is_company_user==1)) {
            return true;
        }
        return false;
    } else {
        return false;
    }
}

function isLoggedIn() {
	if (getLoggedUser()) {
		return true;
	}
	return false;
}

function getLoggedUser() {
    return auth()->user();
}

function getLoggedUserNames() {
    $user = getLoggedUser();
    return $user->first_name . " " . $user->last_name;
}

//start b2c trans to send amount to user
function startB2CTransaction($company_id, $company_user_id, $user_id, $new_loan_application) {

	//get user's loan details
	$user_loan_data = LoanAccount::find($loan_account_id);

	$loan_acct_name = $user_loan_data->account_name;
	$loan_amount = $user_loan_data->repayment_amt;
	$loan_bal = $user_loan_data->loan_bal;

	//get repayment schedules
    $loan_repayment_schedules = LoanRepaymentSchedule::where('loan_account_id', $loan_account_id)
		->get();

	$return_table_data = generateTableLoanRepaymentData($loan_acct_name, $loan_amount, $loan_bal, $loan_repayment_schedules);

	return $return_table_data;

}
//end b2c trans to send amount to user


// checkAlmostExpiringNonPaidOrders
function checkAlmostExpiringNonPaidOrders() {

}

//check expired offers. Expire due offers and renew scheduled periodic offers
function processExpiredOffers() {

    DB::beginTransaction();

    $response = array();
    $result = array();
    $expired_offers = array();

    // set variables
    $status_active = getStatusActive();
    $status_expired = getStatusExpired();

    // offer frequency settings
    $offer_frequency_daily = getOfferFrequencyDaily();
    $offer_frequency_weekly = getOfferFrequencyWeekly();
    $offer_frequency_monthly = getOfferFrequencyMonthly();
    $offer_frequency_yearly = getOfferFrequencyYearly();

    $current_date = getCurrentDate(1);
    $current_date_obj = getCurrentDateObj();

    // current date week no
    $currentDateWeekNo = $current_date_obj->weekOfYear;

    // get all expired offers
    $expired_offers = Offer::where('status_id', '!=', $status_expired)
                            ->where('expiry_at', '<', $current_date)
                            ->orderBy('id')
                            ->get();
    // dd($expired_offers);

    // loop and process each offer
    foreach ($expired_offers as $expired_offer) {

        $tmp = array();

        //offer renewed flag
        $offer_renewed = false;

        //****************************** START RENEW PERIODIC OFFER ****************************************//
        //get offer data
        $orig_offer_name = $expired_offer->name;
        $offer_frequency = $expired_offer->offer_frequency;
        $offer_day = $expired_offer->offer_day;
        $offer_description = $expired_offer->description;
        $offer_day = $expired_offer->offer_day;
        $num_products = $expired_offer->num_products;
        $offer_type = $expired_offer->offer_type_raw;
        $num_sales = $expired_offer->num_sales;
        $max_sales = $expired_offer->max_sales;
        $offer_expiry_method = $expired_offer->offer_expiry_method;
        $company_id = $expired_offer->company_id;
        $offer_type = $expired_offer->offer_type;
        $min_age = $expired_offer->min_age;
        $max_age = $expired_offer->max_age;

        // $offer_image = $expired_offer->main_image;

        // get offer products
        $offer_products = $expired_offer->offerproducts()->get();

        if (($offer_frequency==$offer_frequency_daily) || ($offer_frequency==$offer_frequency_weekly) ||
            ($offer_frequency==$offer_frequency_monthly) || ($offer_frequency==$offer_frequency_yearly)) {

            if ($offer_frequency==$offer_frequency_weekly) {

                // Modify the date to next weekday
                $current_date_obj->copy()->modify("next $offer_day");
                $newEndDate = $current_date_obj;

                // get the date's week no
                $newEndDateWeekNo = $newEndDate->weekOfYear;

                //if current week is same as previous offer end date week, add 1 week to date
                if ($newEndDateWeekNo == $currentDateWeekNo) {
                    $newEndDate = $newEndDate->modify('+1 week');
                }

            } else if ($offer_frequency==$offer_frequency_monthly) {

                // Modify the date add 1 month
                $current_date_obj->copy()->modify("+1 month");
                $newEndDate = $current_date_obj;

            } else if ($offer_frequency==$offer_frequency_yearly) {

                // Modify the date add 1 year
                $current_date_obj->copy()->modify("+1 year");
                $newEndDate = $current_date_obj;

            } else if ($offer_frequency==$offer_frequency_daily) {

                // Modify the date add 1 year
                $current_date_obj->copy()->modify("+1 day");
                $newEndDate = $current_date_obj;

            }

            $endDate = clone $newEndDate;
            $expireDate = clone $newEndDate;

            // get start of day
            $start_date = $newEndDate->startOfDay();
            $startDateShort = formatDatePickerDate($start_date, "Y-m-d");

            // end date add 1 day
            $end_date = $endDate->modify("+1 day");
            $end_date = $endDate->endOfDay();

            // expire date add 1 day
            $expire_date = $expireDate->modify("+1 day");
            $expire_date = $expireDate->endOfDay();

            // create new offer
            // get offer name, strip any dates at the end, after - character
            $offer_name_data = explode("-", $orig_offer_name);
            $new_offer_name = trim($offer_name_data[0]) . " - " . $startDateShort;

            if ($offer_type=="event") { $offer_item_type="event"; } else { $offer_item_type="regular"; }

            //start create new offer
            $new_offer = new Offer();

            // attributes
            $new_offer_attributes = [];
            $new_offer_attributes['name'] = $new_offer_name;
            $new_offer_attributes['status_id'] = $status_active;
            $new_offer_attributes['company_id'] = $company_id;
            $new_offer_attributes['offer_day'] = $offer_day;
            $new_offer_attributes['offer_type'] = $offer_item_type;
            $new_offer_attributes['offer_frequency'] = $offer_frequency;
            $new_offer_attributes['offer_expiry_method'] = $offer_expiry_method;
            $new_offer_attributes['max_sales'] = $max_sales;
            $new_offer_attributes['num_sales'] = $num_sales;
            $new_offer_attributes['num_products'] = $num_products;
            $new_offer_attributes['min_age'] = $min_age;
            $new_offer_attributes['max_age'] = $max_age;
            $new_offer_attributes['description'] = $offer_description;
            $new_offer_attributes['created_by'] = getSystemUserId();
            $new_offer_attributes['created_by_name'] = getSystemUserName();
            $new_offer_attributes['updated_by'] = getSystemUserId();
            $new_offer_attributes['updated_by_name'] = getSystemUserName();
            $new_offer_attributes['start_at'] = $start_date;
            $new_offer_attributes['end_at'] = $end_date;
            $new_offer_attributes['expiry_at'] = $expire_date;

            try {
                $offer_result = $new_offer->create($new_offer_attributes);

                $new_offer_id = $offer_result->id;
                log_this(json_encode($offer_result));
            } catch (\Exception $e) {
                DB::rollback();
                // dd("err here::", $e);
                log_this($e->getMessage());
                throw new \Exception($e->getMessage());
            }

            // if offer has use same image for renewed future offers setting
            // duplicate offer image
            // $offer_image = $offer_image;
            // offer was created successfully, copy offer products
            // copy images from previous offer (create offer product entries like previous)
            // get offer products
            if (count($offer_products)){

                // loop over offer products and duplicate
                foreach($offer_products as $offer_product) {

                    // unset id - primary key
                    unset($offer_product['id']);

                    // replace values
                    $offer_product['offer_id'] = $new_offer_id;
                    $offer_product['created_by'] = getSystemUserId();
                    $offer_product['created_by_name'] = getSystemUserName();
                    $offer_product['updated_by'] = getSystemUserId();
                    $offer_product['updated_by_name'] = getSystemUserName();

                    // create offer product
                    $new_offer_product = new OfferProduct();

                    $offer_product_array = $offer_product->toArray();

                    try {
                        $offer_product_result = $new_offer_product->create($offer_product_array);
                        // dump($offer_product_result);

                        // $new_offer_product_id = $offer_product_result->id;
                        log_this(json_encode($offer_product_result));
                    } catch (\Exception $e) {
                        DB::rollback();
                        // dd("err here::", $e);
                        log_this($e->getMessage());
                        throw new \Exception($e->getMessage());
                    }

                }

            }

            $offer_renewed = true;

        }
        //****************************** END RENEW PERIODIC OFFER ****************************************//



        //****************************** START EXPIRE OFFER ****************************************//
        try {

            $expired_offer->update([
                                        'status_id' => getStatusExpired(),
                                        'updated_by' => getSystemUserId(),
                                        'updated_by_name' => getSystemUserName()
                                    ]);

        } catch(\Exception $e) {

            DB::rollback();
            // dd($e);
            log_this($e->getMessage());
            throw new \Exception($e->getMessage());

        }
        //****************************** END EXPIRE OFFER ****************************************//



        //****************************** START SEND MESSAGE ****************************************//

        /* $created_at = date("d-M-Y", $this->php_date($created_at));
        $expired_at = date("d-M-Y H:i:s", $this->php_date($expiry_date));


        //set data
        $fb_page = urlencode(FB_PAGE_URL);
        $tw_page = urlencode(TWITTER_PAGE_URL);
        $ig_page = urlencode(INSTAGRAM_PAGE_URL);
        $google_page = urlencode(GOOGLE_PAGE_URL);
        $email = urlencode(CONTACT_EMAIL_PLAIN);
        $phone = urlencode(CONTACT_PHONE);
        $company_name = urlencode(COMPANY_NAME);


        //get est details
        $est_data = $this->getEstablishments("", $est_id);
        //print_r($est_data);

        $recipient_names = $est_data["rows"][0]["contact_person"];
        $est_phone = $est_data["rows"][0]["phone1"];
        $personal_email = $est_data["rows"][0]["personal_email"];
        $est_email = $est_data["rows"][0]["email"];

        $salutation = "Hello $recipient_names";
        $salutation = urlencode($salutation);

        //email data
        $to_email = $est_email;
        $cc_email = $personal_email;
        $to_names = $recipient_names;
        $from_names = $company_name;
        $from_email = NO_REPLY_EMAIL; */


        //formulate expired message  ////////////////////////////////////////////////////

        /* $subject_expired = "Your offer '$orig_offer_name' just expired";
        $message_text_expired = "Your offer <strong>\"$orig_offer_name\"</strong> placed on <strong>".$company_name."</strong> website created on $created_at just expired.<br><br>";
        $message_text_expired .= "You can login to ".$company_website." to check your offer orders, income and redeem your revenue.<br><br>";
        $message_text_expired .= "Completed orders for this offer are attached in the pdf file for your perusal.<br><br>";
        $message_text_expired .= "To get started, click on the link below or copy the link to your browser URL: <br><br>";
        $message_text_expired .= "<a href='". $company_website ."'>". $company_website ."</a>";

        //generate message text
        $message_text_expired = urlencode($message_text_expired);
        $template_url_expired = SITEPATH . "includes/email_template.php?salutation=$salutation&message=$message_text_expired&fb_page=$fb_page&tw_page=$tw_page&ig_page=$ig_page&google_page=$google_page&email=$email&phone=$phone";
        $message_expired = $this->getWebpage($template_url_expired); */

        //END formulate expired message  ////////////////////////////////////////////////////



        //formulate offer renewal message  ////////////////////////////////////////////////////

        /* $subject = "Your offer '$orig_offer_name' has just been renewed";
        $message_text = "Your offer <strong>\"$orig_offer_name\"</strong> placed on <strong>".$company_name."</strong> website created on $created_at has just been renewed.<br><br>";
        $message_text .= "The offer has been renewed under the new name <strong>\"". $new_offer_name . "\"</strong>";
        $message_text .= ". <br>You can view the new offer here: <a href='". $new_offer_url ."'>". $new_offer_url ."</a><br>Please login to add offer poster/ image.<br><br>";
        $message_text .= "To get started, click on the link below or copy the link to your browser URL: <br><br>";
        $message_text .= "<a href='". $company_website ."'>". $company_website ."</a>";

        $client_subject = $subject;

        //generate message text
        $message_text = urlencode($message_text);
        $template_url = SITEPATH . "includes/email_template.php?salutation=$salutation&message=$message_text&fb_page=$fb_page&tw_page=$tw_page&ig_page=$ig_page&google_page=$google_page&email=$email&phone=$phone";
        $message = $this->getWebpage($template_url); */

        //end offer renewal message ////////////////////////////////////////////////////


        //************************************ CREATE ORDERS PDF for expired offer*************************************//

        /* require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "libs/mpdf/mpdf.php"; // Include mdpf
        $stylesheet = file_get_contents('../../css/app/pdf.css'); // Get css content

        //get basic data
        $est_id = $est_id;
        $offer_id = $offer_id;

        //get est data
        $est_data = $this->getEstablishments("", $est_id);
        $est_data_item = $est_data["rows"][0];
        $est_name = $est_data_item["name_desc"];

        //formulate pdf file
        $top_title = "Redeem Orders List (" . $est_name . ")";

        $pdf_filename = "redeem_orders" . " " . $est_name;

        if ($orig_offer_name) {

            $pdf_filename .=  " " . $orig_offer_name;

        }

        $pdf_filename = $this->generate_seo_link($pdf_filename, $replace = '_', "", "");

        $pdf_filename .= ".pdf";

        //pdf configs
        $header_string = $est_name;

        // create HTML content
        $file_path = SITEPATH . "admin/reports/redeem_items_pdf.php?est_id=" . $est_id . "&offer_id=" . $offer_id;

        $html = $this->getWebpage($file_path);

        // Setup PDF
        $tDate = date("F j, Y, g:i a");
        $mpdf = new mPDF('utf-8', 'A4-L'); // New PDF object with encoding & page size
        $mpdf->setAutoTopMargin = 'stretch'; // Set pdf top margin to stretch to avoid content overlapping
        $mpdf->setAutoBottomMargin = 'stretch'; // Set pdf bottom margin to stretch to avoid content overlapping
        // PDF header content
        $mpdf->SetHTMLHeader('<div class="pdf-header">
                                    <h3>' . $top_title . '</h3>
                                </div><hr>');
        // PDF footer content
        $mpdf->SetHTMLFooter('<hr>
                                <div class="pdf-footer">
                                <i>Printed on: ' . $tDate . ' &nbsp; - ' . COMPANY_NAME . '&nbsp;&nbsp;&nbsp; (<a href="' . CONTACT_WEBSITE . '">' . CONTACT_WEBSITE . '</a>)
                                    &nbsp;&nbsp;<span class="right">Page: {PAGENO}</span>
                                </i>
                                </div>');

        $mpdf->WriteHTML($stylesheet,1); // Writing style to pdf
        $mpdf->WriteHTML($html); // Writing html to pdf
        // FOR EMAIL
        $content = $mpdf->Output('', 'S'); // Saving pdf to attach to email
        //$content = chunk_split(base64_encode($content));
        //echo "$content == $pdf_filename"; exit;

        //send expiry email content and pdf
        $this->sendEmail($to_email, $to_names, $from_email, $from_names, $subject, $message_expired, "", "", "", $content, $pdf_filename);
        //end send expiry email content and pdf

        //send renewal email
        $this->sendEmail($to_email, $to_names, $from_email, $from_names, $subject, $message, "", "", "", "", "");
        //end send renewal email

        //exit;



        //************************************ END CREATE ORDERS PDF *************************************


        //****************************** END SEND MESSAGE ****************************************

        //store data into array
        $tmp["to_email"] = $to_email;
        $tmp["cc_email"] = $cc_email;
        $tmp["to_names"] = $to_names;
        $tmp["from_names"] = $from_names;
        $tmp["from_email"] = $from_email;
        $tmp["subject"] = $subject;
        $tmp["message_text"] = $message_text;
        $tmp["message"] = $message;

        array_push($result, $tmp); */

    }

    /*
        $response["total"] = $num_recs;
        $response["rows"] = $result;

        $stmt->close();
    */

    /*}  else {
        //$response["query"] = $query;
        $response["message"] = $this->conn->error;
        $response["error_type"] = AN_ERROR_OCCURED_ERROR;
        $response["error"] = true;
    } */

    // return $response;

    DB::commit();

}


// checkAlmostExpiringNonPaidOrders
function processExpiredOrders() {

}


//get company user allowed loan amount
function getAllowedLoanAmount($company_user_id, $borrow_criteria, $loan_calculation_percentage, $user_set_loan_limit,
							  $one_month_limit_amt, $one_to_three_month_limit_amt, $three_to_six_month_limit_amt, $above_six_month_limit_amt) {

	$one_month_limit = config('constants.membership_age_limits.one_month_limit');
	$one_to_three_month_limit = config('constants.membership_age_limits.one_to_three_month_limit');
	$three_to_six_month_limit = config('constants.membership_age_limits.three_to_six_month_limit');
	$above_six_month_limit = config('constants.membership_age_limits.above_six_month_limit');

	$diff_days = 0;
	$diff_months = 0;

	//get user membership age
	$current_date_obj = getCurrentDateObj();
	$company_user_data = CompanyUser::find($company_user_id);
	$registration_date_str = $company_user_data->registration_paid_date;
	$registration_date = Carbon::createFromFormat('Y-m-d H:i:s', $registration_date_str);
	$diff_days = $registration_date->diffInDays($current_date_obj);
	$diff_months = $registration_date->diffInMonths($current_date_obj);

	$member_age_limit = "";
	$member_age_limit_amt = "";

	//start get age limit ranges
	if ($above_six_month_limit_amt) {
		if ($diff_months >= 6){
			$member_age_limit = $above_six_month_limit;
			$member_age_limit_amt = $above_six_month_limit_amt;
		}
	}

	if ($three_to_six_month_limit_amt) {
		if (($diff_months >= 3) && ($diff_months < 6)){
			$member_age_limit = $three_to_six_month_limit;
			$member_age_limit_amt = $three_to_six_month_limit_amt;
		}
	}

	if ($one_to_three_month_limit_amt) {
		if (($diff_months >= 1) && ($diff_months < 3)){
			$member_age_limit = $one_to_three_month_limit;
			$member_age_limit_amt = $one_to_three_month_limit_amt;
		}
	}

	if ($one_month_limit_amt) {
		if (($diff_months < 1) && ($diff_days >= 0)) {
			$member_age_limit = $one_month_limit;
			$member_age_limit_amt = $one_month_limit_amt;
		}
	}
	//end get age limit ranges

	//dd($current_date_obj, $registration_date, $diff_days, $diff_months, $member_age_limit,
	//   $loan_calculation_percentage, $user_set_loan_limit, $member_age_limit_amt);

	//check if this is the first loan by user
	//if so set the limit to initial_loan_limit, if it is set
	$existing_loan_data = LoanAccount::where('company_user_id', $company_user_id)->first();

	//get loan limits
	if ($borrow_criteria == "contributions") {

		//get allowed loan amt based on loan limits
		$allowed_loan_amt = $user_set_loan_limit * ($loan_calculation_percentage/100);
		//end check if loan application meets set loan limit condition

		//if its the first loan and initial_loan_limit is set
		if ((!$existing_loan_data) && ($initial_loan_limit > 0)) {
			//this is the first loan
			$allowed_loan_amt = $initial_loan_limit;
		}

	} else {

		//if its a subsequent loan, use the limit calc to get allowed loan amount
		if ($existing_loan_data) {
			$allowed_loan_amt = $user_set_loan_limit * ($loan_calculation_percentage/100);
		} else {
			$allowed_loan_amt = $initial_loan_limit;
		}

	}

	//are we above membership age limit?
	if ($member_age_limit_amt > 0) {
		if ($allowed_loan_amt > $member_age_limit_amt) {
			$allowed_loan_amt = $member_age_limit_amt;
		}
	}

	$response['allowed_loan_amt'] = $allowed_loan_amt;
	$response['member_age_limit'] = $member_age_limit;
	$response['member_age_limit_amt'] = $member_age_limit_amt;
	$response['membership_date'] = $registration_date_str;

	return json_encode($response);

}

//build loan repayment data table response
function buildTableLoanRepaymentData($loan_account_id) {

	//get user's loan details
	$user_loan_data = LoanAccount::find($loan_account_id);

	$loan_acct_name = $user_loan_data->account_name;
	$loan_amount = $user_loan_data->repayment_amt;
	$loan_bal = $user_loan_data->loan_bal;

	//get repayment schedules
    $loan_repayment_schedules = LoanRepaymentSchedule::where('loan_account_id', $loan_account_id)
		->get();

	$return_table_data = generateTableLoanRepaymentData($loan_acct_name, $loan_amount, $loan_bal, $loan_repayment_schedules);

	return $return_table_data;

}


//build loan repayment data table response
function generateTableLoanRepaymentData($loan_acct_name, $loan_amount, $loan_bal, $loan_repayment_schedules) {

	$table_data = "<table width='100%' align='center' cellpadding='0' cellspacing='0'>";
	//$table_data .= "	<thead>";
	$table_data .= "<tr>";
	$table_data .= "<td style='border: 1px solid #dddddd;padding: 5px 10px;' bgcolor='#E6E6E6' colspan='2'><strong>Loan Acct Name</strong></td>";
	$table_data .= "<td style='border: 1px solid #dddddd;padding: 5px 10px;' bgcolor='#E6E6E6' colspan='3'>$loan_acct_name</td>";
	$table_data .= "</tr>";
	$table_data .= "<tr>";
	$table_data .= "<td style='border: 1px solid #dddddd;padding: 5px 10px;'><strong>Loan Amt</strong></td>";
	$table_data .= "<td style='border: 1px solid #dddddd;padding: 5px 10px;'>$loan_amount</td>";
	$table_data .= "<td style='border: 1px solid #dddddd;padding: 5px 10px;' colspan='2'><strong>Loan Balance</strong></td>";
	$table_data .= "<td style='border: 1px solid #dddddd;padding: 5px 10px;'>$loan_bal</td>";
	$table_data .= "</tr>";
	$table_data .= "<tr>";
	$table_data .= "<td style='border: 1px solid #dddddd;padding: 5px 10px;' width='25%' align='left' bgcolor='#F0F0F0'><strong>Due Date</strong></td>";
	$table_data .= "<td style='border: 1px solid #dddddd;padding: 5px 10px;' width='20%' align='left' bgcolor='#F0F0F0'><strong>Amt Due</strong></td>";
	$table_data .= "<td style='border: 1px solid #dddddd;padding: 5px 10px;' width='20%' align='left' bgcolor='#F0F0F0'><strong>Amt Paid</strong></td>";
	$table_data .= "<td style='border: 1px solid #dddddd;padding: 5px 10px;' width='15%' align='left' bgcolor='#F0F0F0'><strong>Status</strong></td>";
	$table_data .= "<td style='border: 1px solid #dddddd;padding: 5px 10px;' width='20%' align='left' bgcolor='#F0F0F0'><strong>Repaid At</strong></td>";
	$table_data .= "</tr>";
	//$table_data .= "	</thead>";
	//$table_data .= "	<tbody>";

	foreach ($loan_repayment_schedules as $loan_repayment_schedule) {

		$repayment_amount = $loan_repayment_schedule->amount;
		$paid_amt = $loan_repayment_schedule->paid_amt;
		$repayment_at = $loan_repayment_schedule->repayment_at;
		if ($repayment_at) { $repayment_at = formatDisplayDate($repayment_at); }
		$paid_at = $loan_repayment_schedule->paid_at;
		if ($paid_at) { $paid_at = formatDisplayDate($paid_at); }
		$status_name = $loan_repayment_schedule->status->name;

		$table_data .= "<tr>";
		$table_data .= "<td style='border: 1px solid #dddddd;padding: 5px 10px;'>" . $repayment_at . "</td>";
		$table_data .= "<td style='border: 1px solid #dddddd;padding: 5px 10px;'>" . $repayment_amount . "</td>";
		$table_data .= "<td style='border: 1px solid #dddddd;padding: 5px 10px;'>" . $paid_amt . "</td>";
		$table_data .= "<td style='border: 1px solid #dddddd;padding: 5px 10px;'>" . $status_name . "</td>";
		$table_data .= "<td style='border: 1px solid #dddddd;padding: 5px 10px;'>" . $paid_at . "</td>";
		$table_data .= "</tr>";

	}

	//$table_data .= "	</tbody>";
	$table_data .= "</table>";
	//end create table

	return $table_data;

}


function getSiteContent($category, $count=3, $orderBy="site_content.id", $orderStyle="desc", $status=1, $type="normal", $random=99, $startIndex=0) {

    $result = array();

    // set defaults
    $count = $count ? $count : 3;
    $orderBy = $orderBy ? $orderBy : "site_content.id";
    $orderStyle = $orderStyle ? $orderStyle : "desc";
    $status = $status ? $status : 1;
    $type = $type ? $type : "normal";
    $random = $random ? $random : 99;
    $startIndex = $startIndex ? $startIndex : 0;

	// get content listing
	$resultData = SiteContent::where("site_content.status_id", $status)
						->where("site_content.category_id", $category)
						->join("categories", "categories.id", "=", "site_content.category_id")
						->leftJoin('images', function($join) use ($type) {
							$join->on('images.category_id', 'site_content.category_id');
							$join->where('images.imagetable_type', $type);
							$join->where('images.status_id', "1");
							$join->on('images.imagetable_id', 'site_content.id');
						})
						->select(
								'site_content.*',
								'categories.code',
								'categories.cat_permalink',
								'images.full_img',
								'images.thumb_img',
								'images.thumb_img_400'
								)
						//->take($count)
						->when($count, function ($query) use ($count, $startIndex) {
							$query->take($count);
						})
						->orderBy($orderBy, $orderStyle)
						->get();

	$imagesData = Image::where('category_id', $category)
						->where('imagetable_type', $type)
						->where('status_id', "1")
						->get();

	// dd($imagesData, $resultData);

	$result['content'] = $resultData;
	$result['images'] = $imagesData;

	return $result;

}

function getEstablishments($category, $count=3, $orderBy="companies.created_at", $orderStyle="desc", $status=1, $random=true) {

	//get listing
	$result = Company::where('status_id', $status)
						->when($category, function ($query) use ($category) {
							$query->where('category_id', $category);
						})
						->take($count)
						->orderBy($orderBy, $orderStyle)
						->get();

	// dd($result);
	return $result;

}

// check if offer is active
function isOfferActive($id) {

    $status_active = config('constants.status.active');
    if (getOfferData($id, $status_active)) {
        return true;
    }

    return false;

}

// check if company product already exists in offer
function isOfferProductExistsInOffer($offer_id, $company_product_id) {

    $company_product_data =  OfferProduct::where("offer_id", $offer_id)
                                         ->where("company_product_id", $company_product_id)
                                         ->first();

    if ($company_product_data) {
        return true;
    }

    return false;

}

// get % discount on offer products
function getOfferDiscountPercent($normal_price, $offer_price) {

    $discount = ($normal_price - $offer_price) / $normal_price * 100;

    return roundNumber($discount);

}

// adjust the number of offer products
function adjustNumOfferProducts($offer_id) {

    // logged user
    $logged_user_names = getLoggedUserNames();

    // get current number of offer products
    $num_offer_products = getNumOfferProducts($offer_id);

    // adjust num_products field
    $offer_data = Offer::find($offer_id);

    $offer_data->num_products = $num_offer_products;
    $offer_data->updated_by = getLoggedUser()->id;
    $offer_data->updated_by_name = $logged_user_names;

    $result = $offer_data->save();

    return $result;

}

// get number of offer products
function getNumOfferProducts($offer_id, $status_id="") {

    // get current number of offer products
    return OfferProduct::where("offer_id", $offer_id)
                        ->when($status_id, function ($query) use ($status_id) {
                            $query->where('status_id', $status_id);
                        })
                        ->count();

}

// round off digits
function roundNumber($float_number, $decimal_places = 4) {

    // set defaults
    $decimal_places = $decimal_places ? $decimal_places : 4;

    return round($float_number, $decimal_places);

}

// check whether product category id matches main product category id
function productCategoryIdsMatch($product, $product_category_id) {
    if($product->product_category_id == $product_category_id) {
        return true;
    }
    return false;
}

// get offer data
function getOfferData($id, $status_id="1") {

    $status_id = $status_id ? $status_id : 1;

    return Offer::where("id", $id)
                    ->when($status_id, function ($query) use ($status_id) {
                        $query->where('status_id', $status_id);
                    })
                    ->first();

}

// get company product data
function isCompanyProductExists($product_id, $company_id) {
    if (getCompanyProductData("", $product_id, $company_id)) {
        return true;
    }
    return false;
}

// generate permalink
function generatePermalink($id, $slug) {
    return $id . "-" . $slug;
}

// get product category data
function getProductCategoryData($id) {
    return ProductCategory::find($id);
}

// get product data
function getProductData($id) {
    return Product::find($id);
}

// get company product data
function getCompanyProductData($id="", $product_id="", $company_id="") {
    return CompanyProduct::when($id, function ($query) use ($id) {
                                $query->where('id', $id);
                            })
                            ->when($product_id, function ($query) use ($product_id) {
                                $query->where('product_id', $product_id);
                            })
                            ->when($company_id, function ($query) use ($company_id) {
                                $query->where('company_id', $company_id);
                            })
                            ->first();
}

// get offer product data
function getOfferProductData($id) {
    return OfferProduct::find($id);
}

// get id from permalink e.g. 34-barddy-bar-1
function getIdFromPermalink($data) {
	$item_data_array = explode ('-' , $data);
	// id is index 0
	return $item_data_array[0];
}

function getFullImagePath($img_url) {
	$app_url = config('app.url');
	return $app_url . '/' . $img_url;
}

function showNoImage($title, $width="", $height="") {
	$app_url = config('app.url');
	$width_fin = $width ? $width : "100%";
	return "<img src='" . $app_url . "/images/no_image.jpg' alt='" . $title . "'  width=" . $width_fin . ">";
}

// get offer products frontend
function getOfferProductsFront($id="",
					$count=8,
					$offer_id="",
					$status_id="",
					$random=false,
					$company_product_id="",
					$account_search="",
					$company_id="",
					$start_date="",
					$end_date="",
					$created_by="",
					$updated_by="",
					$order_by="companies.created_at",
					$order_style="desc",
					$report="1"
					) {

    // set defaults
    $random = $random ? $random : 1;
    $count = $count ? $count : 8;
    $order_by = $order_by ? $order_by : "companies.created_at";
    $order_style = $order_style ? $order_style : "desc";
    $report = $report ? $report : "1";
    $random = $random ? $random : false;

	//get listing
    $offerProductFrontIndex = new OfferProductFrontIndex();

    $request = request();

    $request->merge([
        'id' => $id,
        'company_id' => $company_id,
        'company_product_id' => $company_product_id,
        'offer_id' => $offer_id,
        'account_search' => $account_search,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'count' => $count,
        'created_by' => $created_by,
        'updated_by' => $updated_by,
        'order_by' => $order_by,
        'order_style' => $order_style,
        'report' => $report,
        'status_id' => $status_id,
        'random' => $random
    ]);

	return $offerProductFrontIndex->getData($request)->get();

}

// get offer products
function getOfferProducts($id="",
					$count=8,
					$offer_id="",
					$status_id="",
					$random=false,
					$company_product_id="",
					$account_search="",
					$company_id="",
					$start_date="",
					$end_date="",
					$created_by="",
					$updated_by="",
					$order_by="companies.created_at",
					$order_style="desc",
					$report="1"
					) {

	//get listing
	$offerProductIndex = new OfferProductIndex();

	// create array to send as object
	$request = array();
	$request['id'] = $id;
	$request['company_id'] = $company_id;
	$request['company_product_id'] = $company_product_id;
	$request['offer_id'] = $offer_id;
	$request['count'] = $count;
	$request['status_id'] = $status_id;
	$request['account_search'] = $account_search;
	$request['start_date'] = $start_date;
	$request['end_date'] = $end_date;
	$request['created_by'] = $created_by;
	$request['updated_by'] = $updated_by;
	$request['order_by'] = $order_by;
	$request['order_style'] = $order_style;
	$request['report'] = $report;
	$request['random'] = $random;

	// convert array to object
	$request = (object) $request;

	return $offerProductIndex->getData($request)->get();

}

// get offer products
function getCounties($id="", $status_id="1") {

    $status_id = $status_id ? $status_id : 1;
    $id = $id ? $id : "";

    $counties = County::where('status_id', $status_id)
                        ->when($id, function ($query) use ($id) {
                            $query->where('id', $id);
                        })
                        ->get();

	return $counties;

}


// get companies
function getCompanies($id="",
					$count=8,
					$cat_id="",
					$status_id="",
					$random=false,
					$paybill_no="",
					$account_search="",
					$phone="",
					$personal_phone="",
					$town="",
					$email="",
					$personal_email="",
					$county_id="",
					$start_date="",
					$end_date="",
					$created_by="",
					$updated_by="",
					$order_by="companies.created_at",
					$order_style="desc",
					$report="1"
					) {

	//get listing
	$offerIndex = new CompanyIndex();

	// create array to send as object
	$request = array();
	$request['id'] = $id;
	$request['company_id'] = $id;
	$request['count'] = $count;
	$request['cat_id'] = $cat_id;
	$request['status_id'] = $status_id;
	$request['paybill_no'] = $paybill_no;
	$request['account_search'] = $account_search;
	$request['phone'] = $phone;
	$request['personal_phone'] = $personal_phone;
	$request['town'] = $town;
	$request['email'] = $email;
	$request['personal_email'] = $personal_email;
	$request['county_id'] = $county_id;
	$request['start_date'] = $start_date;
	$request['end_date'] = $end_date;
	$request['created_by'] = $created_by;
	$request['updated_by'] = $updated_by;
	$request['order_by'] = $order_by;
	$request['order_style'] = $order_style;
	$request['report'] = $report;
	$request['random'] = $random;

	// convert array to object
	$request = (object) $request;

	return $offerIndex->getData($request)->get();

}

// get offers frontend
function getOffersFront($id="",
				   $offer_type="regular",
				   $count=5,
				   $cat_id="",
				   $status_id="",
				   $company_id="",
				   $account_search="",
				   $offer_frequency="",
				   $offer_expiry_method="",
				   $min_age="",
				   $max_age="",
				   $offer_day="",
				   $expiry_date="",
				   $start_date="",
				   $end_date="",
				   $max_sales="",
				   $num_sales="",
				   $created_by="",
				   $updated_by="",
				   $order_by="offers.created_at",
				   $order_style="desc",
				   $report="1",
                   $random=false,
                   $min_products=1) {

    // set defaults
    $random = $random ? $random : 1;
    $offer_type = $offer_type ? $offer_type : "regular";
    $count = $count ? $count : 5;
    $order_by = $order_by ? $order_by : "offers.created_at";
    $order_style = $order_style ? $order_style : "desc";
    $report = $report ? $report : "1";
    $random = $random ? $random : false;
    $min_products = $min_products ? $min_products : 1;

	//get listing
    $offerFrontIndex = new OfferFrontIndex();
    // dd($random);

    // create new request object
    $request = request();

    $request->merge([
        'id' => $id,
        'offer_type' => $offer_type,
        'company_id' => $company_id,
        'account_search' => $account_search,
        'offer_frequency' => $offer_frequency,
        'offer_expiry_method' => $offer_expiry_method,
        'min_age' => $min_age,
        'max_age' => $max_age,
        'offer_day' => $offer_day,
        'expiry_date' => $expiry_date,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'cat_id' => $cat_id,
        'count' => $count,
        'created_by' => $created_by,
        'updated_by' => $updated_by,
        'order_by' => $order_by,
        'order_style' => $order_style,
        'report' => $report,
        'status_id' => $status_id,
        'random' => $random,
        'min_products' => $min_products,
        'max_sales' => $max_sales,
        'num_sales' => $num_sales,

    ]);
    // dd($request);

	return $offerFrontIndex->getData($request)->get();

}

// get offers
function getOffers($id="",
				   $offer_type="regular",
				   $count=5,
				   $cat_id="",
				   $status_id="",
				   $company_id="",
				   $account_search="",
				   $offer_frequency="",
				   $offer_expiry_method="",
				   $min_age="",
				   $max_age="",
				   $offer_day="",
				   $expiry_date="",
				   $start_date="",
				   $end_date="",
				   $max_sales="",
				   $num_sales="",
				   $created_by="",
				   $updated_by="",
				   $order_by="offers.created_at",
				   $order_style="desc",
				   $report="1",
				   $random=false) {

	//get listing
    $offerIndex = new OfferIndex();

    // create new request object
    $request = request();

    $request->merge([
        'id' => $id,
        'offer_type' => $offer_type,
        'company_id' => $company_id,
        'account_search' => $account_search,
        'offer_frequency' => $offer_frequency,
        'offer_expiry_method' => $offer_expiry_method,
        'min_age' => $min_age,
        'max_age' => $max_age,
        'offer_day' => $offer_day,
        'expiry_date' => $expiry_date,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'cat_id' => $cat_id,
        'count' => $count,
        'created_by' => $created_by,
        'updated_by' => $updated_by,
        'order_by' => $order_by,
        'order_style' => $order_style,
        'report' => $report,
        'status_id' => $status_id,
        'random' => $random,
        'max_sales' => $max_sales,
        'num_sales' => $num_sales,

    ]);
    // dd($request);

	return $offerIndex->getData($request)->get();

}

//////////////// START SHOPPING CART ///////////////////////////////

// get active UserShoppingCart
function getActiveUserShoppingCart() {

    $status_active = config('constants.status.active');

	$user = getLoggedUser();
    $user_id = $user->id;
    $company_id = $user->company_id;

    // check if user has an active shopping cart
    $user_shopping_cart = getShoppingCart($user_id, $status_active);

    return $user_shopping_cart;

}

// is cart active
function isActiveShoppingCart($shopping_cart_id) {

    $status_active = config('constants.status.active');

    // check if user has an active shopping cart
    $user_shopping_cart = getShoppingCart("", $status_active, $shopping_cart_id);

    if ($user_shopping_cart) {
        return true;
    }

    return false;

}

// is cart active
function isActiveShoppingCartForStkPush($shopping_cart_id) {

    $status_active = config('constants.status.active');
    $status_order_placed = config('constants.status.orderplaced');

    // create status_ids array
    $status_ids = array();
    $status_ids[] = $status_active;
    $status_ids[] = $status_order_placed;

    // check if user has an active shopping cart
    $user_shopping_cart = getShoppingCartStatusArray("", $status_ids, $shopping_cart_id);
    // dd($status_ids, $user_shopping_cart);

    if ($user_shopping_cart) {
        return true;
    }

    return false;

}

// get UserShoppingCart
function getShoppingCart($user_id, $status_id="1", $shopping_cart_id="", $statuses=array()) {

    // $statuses=array() take precedence if provided
    // set the defaults
    $the_statuses = array();
    if (count($statuses)) {
        $the_statuses = $statuses;
    } else {
        $status_id = $status_id ? $status_id : getStatusActive();
        $the_statuses[] = $status_id;
    }

    // get shopping cart
    $cart = ShoppingCart::when($user_id, function ($query) use ($user_id) {
                            $query->where('user_id', $user_id);
                        })
                        ->when($status_id, function ($query) use ($the_statuses) {
                            $query->whereIn('status_id', $the_statuses);
                        })
                        ->when($shopping_cart_id, function ($query) use ($shopping_cart_id) {
                            $query->where('id', $shopping_cart_id);
                        })
                        ->first();

    return $cart;

}

// get UserShoppingCart in array of statuses
function getShoppingCartWithStatuses($user_id, $statuses=array(), $shopping_cart_id="") {

    // set the defaults
    $status_id = $status_id ? $status_id : "1";

    // get shopping cart
    $cart = ShoppingCart::when($user_id, function ($query) use ($user_id) {
                            $query->where('user_id', $user_id);
                        })
                        ->when($status_id, function ($query) use ($status_id) {
                            $query->where('status_id', $status_id);
                        })
                        ->when($shopping_cart_id, function ($query) use ($shopping_cart_id) {
                            $query->where('id', $shopping_cart_id);
                        })
                        ->first();

    return $cart;

}

// get UserShoppingCart status array
function getShoppingCartStatusArray($user_id, $status_ids=array(), $shopping_cart_id="") {

    // if no user_id is supplied, get from logged user
    if (!$user_id) {
        if (isLoggedIn()) {
            // get logged user
            $logged_user = getLoggedUser();
            $user_id = $logged_user->id;
        }
    }

    // get shopping cart
    $cart = ShoppingCart::when($user_id, function ($query) use ($user_id) {
                            $query->where('user_id', $user_id);
                        })
                        ->when($status_ids, function ($query) use ($status_ids) {
                            $query->whereIn('status_id', $status_ids);
                        })
                        ->when($shopping_cart_id, function ($query) use ($shopping_cart_id) {
                            $query->where('id', $shopping_cart_id);
                        })
                        ->first();

    return $cart;

}

// get shopping cart item in shopping cart
function getShoppingCartItemInCart($shopping_cart_id, $offer_product_id) {

    $shopping_cart_item_data = ShoppingCartItem::where('offer_product_id', $offer_product_id)
                                               ->where('shopping_cart_id', $shopping_cart_id)
                                               ->first();

    return $shopping_cart_item_data;

}

// get shopping cart item in shopping cart
function updateShoppingCartItemInCart($shopping_cart_id, $shopping_cart_item_id, $quantity) {

    // calculate new totals
    $shopping_cart_item_data = ShoppingCartItem::find($shopping_cart_item_id);
    $unit_price = $shopping_cart_item_data->unit_price;

    // update values
    $shopping_cart_item_data->quantity = $quantity;
    $shopping_cart_item_data->total = $quantity * $unit_price;

    $shopping_cart_item_data->save();

    // update shopping cart totals
    synchronizeSumTotalInCart($shopping_cart_id);

    // update shopping cart quantities
    synchronizeNumProductsInCart($shopping_cart_id);

}

// get all shopping cart items
function getShoppingCartItems($shopping_cart_id) {

    $shopping_cart_items_data = ShoppingCartItem::where('shopping_cart_id', $shopping_cart_id)->get();

    return $shopping_cart_items_data;

}

// check whether shopping cart product is from same offer
function cartProductFromSameOffer($offer_product_id) {

    $user_shopping_cart = getActiveUserShoppingCart();
    $offer_product = getOfferProductData($offer_product_id);

    if ($user_shopping_cart->offer_id == $offer_product->offer_id) {
        return true;
    }

    return false;

}

// add product to cart
function addProductToCart($offer_product_id, $quantity, $unit_price="") {

    // statuses
    $status_active = config('constants.status.active');

    $shopping_cart_id = "";

    // get logged in user
    $logged_user_data = getLoggedUser();

    // get offer product
    $offer_product = getOfferProductData($offer_product_id);

    // get user's active shopping cart
    $user_shopping_cart = getActiveUserShoppingCart();

    if (!$unit_price) {
        // get the product unit price
        $unit_price = $offer_product->offer_price;
    }

    // get item total
    $cart_item_total = $quantity * $unit_price;

    // get existing shopping cart or add new shopping cart
    if ($user_shopping_cart) {

        // get shopping cart id from users active shopping cart
        $shopping_cart_id = $user_shopping_cart->id;

        // update cart totals
        $new_cart_total = $user_shopping_cart->total + $cart_item_total;
        $user_shopping_cart->total = -$new_cart_total;
        $user_shopping_cart->total_calc = $new_cart_total;
        $user_shopping_cart->balance = -$new_cart_total;
        $user_shopping_cart->balance_calc = $new_cart_total;
        $user_shopping_cart->save();

    } else {

        // create new shopping cart
        try {

            $user_shopping_cart = new ShoppingCart();

            $user_shopping_cart->company_id = $offer_product->company_id;
            $user_shopping_cart->user_id = $logged_user_data->id;
            $user_shopping_cart->status_id = $status_active;
            $user_shopping_cart->total = $cart_item_total;
            $user_shopping_cart->total_calc = $cart_item_total;
            $user_shopping_cart->balance = -$cart_item_total;
            $user_shopping_cart->balance_calc = $cart_item_total;
            $user_shopping_cart->offer_id = $offer_product->offer_id;
            $user_shopping_cart->created_by = $logged_user_data->id;
            $user_shopping_cart->created_by_name = $logged_user_data->full_name;
            $user_shopping_cart->updated_by = $logged_user_data->id;
            $user_shopping_cart->updated_by_name = $logged_user_data->full_name;

            $user_shopping_cart->save();

            // get last inserted id
            $shopping_cart_id = $user_shopping_cart->id;

        } catch (\Exception $e) {

            log_this($e->getMessage());
            throw new \Exception($e->getMessage());

        }

    }

    // add new shopping cart item
    if ($shopping_cart_id) {

        // if shopping cart item exists, update its total and quantity
        // if it doesnt, create a new shopping cart item
        // get shopping cart item in shopping cart
        $shopping_cart_item_in_cart = getShoppingCartItemInCart($shopping_cart_id, $offer_product_id);

        if ($shopping_cart_item_in_cart) {

            // update existing cart_item quantity, total and updated at fields
            // get current data and increment
            $new_cart_item_quantity = $shopping_cart_item_in_cart->quantity + $quantity;
            $new_cart_item_total = $shopping_cart_item_in_cart->total + $cart_item_total;

            // update
            try {

                $shopping_cart_item_in_cart->quantity = $new_cart_item_quantity;
                $shopping_cart_item_in_cart->total = $new_cart_item_total;
                $shopping_cart_item_in_cart->updated_by = $logged_user_data->id;
                $shopping_cart_item_in_cart->updated_by_name = $logged_user_data->full_name;
                $shopping_cart_item_in_cart->save();

            } catch (\Exception $e) {

                log_this($e->getMessage());
                throw new \Exception($e->getMessage());

            }

        } else {

            try {

                $user_shopping_cart_item = new ShoppingCartItem();

                $user_shopping_cart_item->company_id = $offer_product->company_id;
                $user_shopping_cart_item->shopping_cart_id = $shopping_cart_id;
                $user_shopping_cart_item->user_id = $logged_user_data->id;
                $user_shopping_cart_item->status_id = $status_active;
                $user_shopping_cart_item->offer_id = $offer_product->offer_id;
                $user_shopping_cart_item->quantity = $quantity;
                $user_shopping_cart_item->unit_price = $unit_price;
                $user_shopping_cart_item->total = $cart_item_total;
                $user_shopping_cart_item->offer_product_id = $offer_product->id;
                $user_shopping_cart_item->company_product_id = $offer_product->company_product_id;
                $user_shopping_cart_item->product_id = $offer_product->product_id;
                $user_shopping_cart_item->product_name = $offer_product->product_name;
                $user_shopping_cart_item->created_by = $logged_user_data->id;
                $user_shopping_cart_item->created_by_name = $logged_user_data->full_name;
                $user_shopping_cart_item->updated_by = $logged_user_data->id;
                $user_shopping_cart_item->updated_by_name = $logged_user_data->full_name;

                $user_shopping_cart_item->save();

            } catch (\Exception $e) {

                log_this($e->getMessage());
                throw new \Exception($e->getMessage());

            }

        }

        // synchronize num products in this shopping cart
        synchronizeNumProductsInCart($shopping_cart_id);

        return true;

    }

    return false;

}

function synchronizeNumProductsInCart($shopping_cart_id) {

    // get total & unique num of products in shopping cart
    $unique_num_products = ShoppingCartItem::where('shopping_cart_id', $shopping_cart_id)->count();
    $total_num_products = ShoppingCartItem::where('shopping_cart_id', $shopping_cart_id)->sum('quantity');

    // update shopping cart quantities
    $shopping_cart = ShoppingCart::find($shopping_cart_id);

    $shopping_cart->unique_num_products = $unique_num_products;
    $shopping_cart->total_num_products = $total_num_products;

    $shopping_cart->save();

}

function synchronizeSumTotalInCart($shopping_cart_id) {

    // get total of products total in shopping cart items
    $total_cart_cost = ShoppingCartItem::where('shopping_cart_id', $shopping_cart_id)->sum('total');

    // update shopping cart quantities
    $shopping_cart = ShoppingCart::find($shopping_cart_id);

    $shopping_cart->total = -$total_cart_cost;
    $shopping_cart->total_calc = $total_cart_cost;
    $shopping_cart->balance = -$total_cart_cost;
    $shopping_cart->balance_calc = $total_cart_cost;

    $shopping_cart->save();

}

// change shopping cart status
function markShoppingCartSent($shopping_cart_id) {
    // status
    $status_sent = getStatusSent();

    $shopping_cart = getShoppingCart("", "", $shopping_cart_id);
    $shopping_cart->status_id = $status_sent;
    $shopping_cart->save();
}

// get order data
function getOrderData($status_id="1", $order_id="", $shopping_cart_id="") {

    // set defaults
    $status_id = $status_id ? $status_id : getStatusOrderPlaced();

    $order = Order::where('status_id', $status_id)
                ->when($order_id, function ($query) use ($order_id) {
                    $query->where('id', $order_id);
                })
                ->when($shopping_cart_id, function ($query) use ($shopping_cart_id) {
                    $query->where('shopping_cart_id', $shopping_cart_id);
                })
                ->first();

    return $order;

}

// get account data
function getAccountData($account_no='', $status_id='1', $phone='') {

    // set defaults
    $status_id = $status_id ? $status_id : getStatusActive();

    $order = DepositAccount::where('status_id', $status_id)
                ->when($account_no, function ($query) use ($account_no) {
                    $query->where('account_no', $account_no);
                })
                ->when($phone, function ($query) use ($phone) {
                    $query->where('phone', $phone);
                })
                ->first();

    return $order;

}


// get destination account data
function getDestinationAccountData($account_type, $account_no) {

    $destination_account = NULL;

    if ($account_type == getAccountTypeTransactionAccount()) {

        $logged_user_id = getLoggedUser()->id;

        // get transaction account
        try {
            $destination_account =  TransactionAccount::where('account_no', $account_no)->first();
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
            log_this($error_message);
            throw new \Exception($error_message);
        }

    }

    if ($account_type == getAccountTypeWalletAccount()) {

        // get wallet account with submitted details
        try {
            $destination_account =  DepositAccount::where(function ($query) use ($account_no) {
                                        $query->orWhere('account_no', $account_no);
                                        $query->orWhere('phone', $account_no);
                                    })
                                    ->first();
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
            log_this($error_message);
            throw new \Exception($error_message);
        }

    }

    return $destination_account;

}

// send invoice to user
function sendStkPushRequest($paybill_number, $phone_number, $account_no, $amount, $company_id, $user_id) {

    // get logged in user
    $logged_user_data = getLoggedUser();
    $logged_user_id = $logged_user_data->id;
    $logged_user_names = $logged_user_data->full_name;

    // get paybill if not supplied
    if (!$paybill_number) {
        // site settings
        $site_settings = getSiteSettings();
        // barddy paybill
        $paybill_number = $site_settings['barddy_paybill_number'];
    }

    // start create local stkpush request entry
    $stkpush_data = new StkpushRequest();

    $stkpush_data->paybill = $paybill_number;
    $stkpush_data->phone = $phone_number;
    $stkpush_data->amount = $amount;
    $stkpush_data->acc_ref = $account_no;
    $stkpush_data->user_id = $user_id;
    $stkpush_data->status_id = 1;
    $stkpush_data->company_id = $company_id;

    $stkpush_data->created_by = $logged_user_id;
    $stkpush_data->created_by_name = $logged_user_names;
    $stkpush_data->updated_by = $logged_user_id;
    $stkpush_data->updated_by_name = $logged_user_names;

    $stkpush_data->save();
    // end create local stkpush request entry

    // send request to pendoadmin
    $stk_push_url = config('constants.mpesa.stkpush_url');
	$pendoapi_app_name = getPendoAdminAppName();
	$app_mode = config('constants.settings.app_mode');

	//get app access token
    $access_token = getAdminAccessToken($pendoapi_app_name);
    // dd($stk_push_url, $paybill_number, $phone_number, $account_no, $amount, $company_id, $offer_id, $user_id, $access_token);

    if ($access_token) {

	    //set params
		$params = [
			'json' => [
				"paybill_number" => $paybill_number,
				"phone_number" => $phone_number,
                "amount" => format_num($amount, 0, ''),
                "acct_no" => $account_no
			]
		];

		if ($app_mode != "test") {

			// start create new sms
            $result = sendAuthPostApi($stk_push_url, $access_token, $params);
            // dd($params, $result, $stk_push_url, $access_token, $params);

			log_this(">>>>>>>>> BARRDY STKPUSH RESULT :\n\n" . json_encode($params) . " - " . json_encode($result) . "\n\n\n");

		} else {

			$result = "";

		}

	    return $result;

	} else {

		return false;

	}

}

// send invoice to user
function sendInvoiceToUser($shopping_cart_id) {

    // status
    $status_active = config('constants.status.active');
    $status_order_placed = config('constants.status.orderplaced');
    $order_data = getOrderData("", "", $shopping_cart_id);
    $order_id = $order_data->id;

    // get logged user
    $logged_user = getLoggedUser();
    $logged_user_id = $logged_user->id;
    $logged_user_names = $logged_user->first_name . " " . $logged_user->last_name;

    // create new order
    try {

        $invoice_data = new Invoice();

        $invoice_data->order_id = $order_id;
        /* $invoice_data->total = $shopping_cart->total;
        $invoice_data->club_total = $club_total;
        $invoice_data->commission = $commission_charged;
        $invoice_data->commission_percent = $orders_commission_percent;
        $invoice_data->total_num_products = $shopping_cart->total_num_products;
        $invoice_data->unique_num_products = $shopping_cart->unique_num_products;
        $invoice_data->currency_id = $shopping_cart->currency_id;
        $invoice_data->pickup_product = 1;
        $invoice_data->submitted_by = $logged_user_id;
        $invoice_data->submitted_by_name = $logged_user_names;
        $invoice_data->submitted_at = getCurrentDate();
        $invoice_data->status_id = $status_order_placed; */

        $invoice_data->save();

        // $order_id = $order_data->id;

    } catch(\Exception $e) {

        log_this("sendInvoiceToUser - " . json_encode($e));
        $message = "An error occured. Could not process order.";
        throw new \Exception($message);

    }

}

// submit shopping cart
function submitShoppingCartPayment($shopping_cart_id) {

    // dd($shopping_cart_id);
    // logged in user
    if (isLoggedIn()) {
        $logged_user_data = getLoggedUser();
        $logged_user_id = $logged_user_data->id;
        $logged_user_names = $logged_user_data->full_name;
    }

    if (!isActiveShoppingCartForStkPush($shopping_cart_id)) {
        $message = "Invalid shopping cart state. Please try again.";
        throw new \Exception($message);
    }

    // change shopping cart status, submitted at, submitted by, submitted_times
    $statuses_array = array();
    $statuses_array[] = getStatusOrderPlaced();
    $statuses_array[] = getStatusActive();
    $shopping_cart = getShoppingCart("", "", $shopping_cart_id, $statuses_array);
    // dd("shopping_cart === ", $shopping_cart);
    $submitted_times = $shopping_cart->submitted_times;
    $new_submitted_times = $submitted_times + 1;

    // update
    try {

        $shopping_cart->status_id = getStatusOrderPlaced();
        $shopping_cart->submitted_at = getCurrentDate(1);
        if (isLoggedIn()) {
            $shopping_cart->updated_by = $logged_user_id;
            $shopping_cart->submitted_by = $logged_user_id;
            $shopping_cart->submitted_by_name = $logged_user_names;
        }
        $shopping_cart->submitted_times = $new_submitted_times;

        $shopping_cart->save();

        return $shopping_cart->id;

    } catch(\Exception $e) {

        // dd($e);
        log_this("submitShoppingCartForPayment - " . json_encode($e));
        $message = "An error occured. Could not process order.";
        throw new \Exception($message);

    }

}

// calculate sales commission
function calculateSalesCommission($amount) {

    $commission = 0;

    // go through each amount band and calculate commission
    $commission_scales = CommissionScale::all();

    foreach ($commission_scales as $commission_scale) {

        // check if this amount falls anywhere inbetween
        $min = NULL;
        $max = NULL;

        $min  = $commission_scale->min;
        $max  = $commission_scale->max;

        if (($amount >= $min) && ($amount <= $max)) {
            // get the commission here
            $commission = $commission_scale->commission;
            // stop once commission is found
            break;
        }

    }

    return $commission;

}

// change shopping cart status id
function changeShoppingCartStatus($shopping_cart_id, $status_id='1') {

    // defaults
    $status_id = $status_id ? $status_id : "1";

    // change shopping cart status, submitted at, submitted by, submitted_times
    $shopping_cart = getShoppingCart("", "", $shopping_cart_id);

    // update
    try {

        $shopping_cart->status_id = $status_id;
        $shopping_cart->save();

        return $shopping_cart->id;

    } catch(\Exception $e) {

        log_this("submitShoppingCartForPayment - " . json_encode($e));
        $message = "An error occured. Could not process order.";
        throw new \Exception($message);

    }

}

// create order from shopping cart
function createOrderFromShoppingCart($shopping_cart_id, $payment_id=NULL) {

    $result = "";
    $logged_user_names = "";
    $logged_user_id = NULL;
    $user_phone = "";

    // status
    $status_active = getStatusActive();
    $status_order_placed = getStatusOrderPlaced();

    $current_date = getCurrentDate(1);

    $statuses_array = array();
    $statuses_array[] = getStatusOrderPlaced();
    $statuses_array[] = getStatusActive();
    $shopping_cart = getShoppingCart("", "", $shopping_cart_id, $statuses_array);
    $shopping_cart_total = $shopping_cart->total_calc;
    $user_data = $shopping_cart->user;

    // get logged user
    if (isLoggedIn()) {
        $logged_user = getLoggedUser();
        $logged_user_id = $logged_user->id;
        $logged_user_names = $logged_user->full_name;
    }

    // calculate amounts of commission and club totals
    // $site_settings = getSiteSettings();
    // $orders_commission_percent = $site_settings['orders_commission'];
    // get the commission
    // $commission_charged = ($shopping_cart_total * $orders_commission_percent) / 100;
    $commission_charged = calculateSalesCommission($shopping_cart_total);
    $club_total = $shopping_cart_total - $commission_charged;

    // create new order
    try {

        $order_data = new Order();

        $order_data_attributes = array();
        $order_data_attributes['shopping_cart_id'] = $shopping_cart_id;
        $order_data_attributes['total'] = -$shopping_cart->total;
        $order_data_attributes['total_calc'] = $shopping_cart->total;;
        $order_data_attributes['club_total'] = -$club_total;
        $order_data_attributes['club_total_calc'] = $club_total;
        $order_data_attributes['commission'] = -$commission_charged;
        $order_data_attributes['commission_calc'] = $commission_charged;
        $order_data_attributes['total_num_products'] = $shopping_cart->total_num_products;
        $order_data_attributes['currency_id'] = $shopping_cart->currency_id;
        $order_data_attributes['unique_num_products'] = $shopping_cart->unique_num_products;
        $order_data_attributes['pickup_product'] = 1;
        $order_data_attributes['submitted_at'] = $current_date;
        $order_data_attributes['company_id'] = $shopping_cart->company_id;
        $order_data_attributes['offer_id'] = $shopping_cart->offer_id;
        $order_data_attributes['status_id'] = getStatusOrderPlaced();
        $order_data_attributes['user_id'] = $shopping_cart->user_id;
        $order_data_attributes['paid_at'] = $current_date;
        $order_data_attributes['paid_by_name'] = $logged_user_names;
        $order_data_attributes['submitted_by'] = $logged_user_id;
        $order_data_attributes['submitted_by_name'] = $logged_user_names;
        $order_data_attributes['created_by'] = $logged_user_id;
        $order_data_attributes['created_by_name'] = $logged_user_names;
        $order_data_attributes['updated_by'] = $logged_user_id;
        $order_data_attributes['updated_by_name'] = $logged_user_names;
        // dd("order_data_attributes == ", $order_data_attributes);

        $result = $order_data->create($order_data_attributes);

    } catch(\Exception $e) {

        log_this("createOrderFromShoppingCart - " . json_encode($e));
        $message = "An error occured. Could not process order.";
        throw new \Exception($message);

    }

    // CREATE CLUB INCOME GL ACCOUNT ENTRIES
    try {

        $club_income_gl_account_type_id = getGlAccountTypeClubIncome();
        if ($user_data){
            $user_phone = $user_data->phone;
        }
        $tran_ref_txt = "order_id - $shopping_cart_id - user id - $shopping_cart->user_id - offer_id - $shopping_cart->offer_id";
        $tran_desc = "Club income - user id - $shopping_cart->user_id - User phone number - $user_phone";

        $club_income_gl_account_entry = createGlAccountEntry($payment_id, $club_total, $club_income_gl_account_type_id,
                                                            $shopping_cart->company_id, $user_phone, "DR", $tran_ref_txt, $tran_desc, "neg", "neg");
        // dd($club_income_gl_account_entry);
        log_this(json_encode($club_income_gl_account_entry));

    } catch(\Exception $e) {

        DB::rollback();
        // dd($e);
        $message = 'Error. Could not create club_income_gl_account_entry';
        log_this($message . ' - ' . $e->getMessage());
        throw new \Exception($message);

    }

    return $result;

}

// create order items from shopping cart
function createOrderItemsFromShoppingCart($shopping_cart_id) {

    // status
    $status_active = config('constants.status.active');
    $status_order_placed = config('constants.status.orderplaced');
    $shopping_cart_items = getShoppingCartItems($shopping_cart_id);
    // dd($shopping_cart_items);

    // get logged user
    $logged_user = getLoggedUser();
    $logged_user_id = $logged_user->id;
    $logged_user_names = $logged_user->first_name . " " . $logged_user->last_name;

    // calculate amounts of commission and club totals
    $site_settings = getSiteSettings();
    $orders_commission_percent = $site_settings['orders_commission'];

    // get this shopping cart's order
    $order_data = getOrderData("", "", $shopping_cart_id);
    $order_id = $order_data->id;
    $commission_percent = $order_data->commission_percent;
    // dd("order_data == ", $order_data);

    // loop through each item and insert
    foreach($shopping_cart_items as $shopping_cart_item) {

        $shopping_cart_item_total = $shopping_cart_item->total;

        // get the commission
        $commission_charged = ($shopping_cart_item_total * $orders_commission_percent) / 100;
        $club_total = $shopping_cart_item_total - $commission_charged;

        // create new order item
        try {

            $order_item_data = new OrderItem();

            $order_item_data->order_id = $order_id;
            $order_item_data->total = $shopping_cart_item_total;
            $order_item_data->club_total = $club_total;
            $order_item_data->commission = $commission_charged;
            $order_item_data->commission_percent = $commission_percent;
            $order_item_data->quantity = $shopping_cart_item->quantity;
            $order_item_data->currency_id = $shopping_cart_item->currency_id;
            $order_item_data->unit_price = $shopping_cart_item->unit_price;
            $order_item_data->company_id = $shopping_cart_item->company_id;
            $order_item_data->user_id = $shopping_cart_item->user_id;
            $order_item_data->offer_id = $shopping_cart_item->offer_id;
            $order_item_data->shopping_cart_id = $order_data->shopping_cart_id;
            $order_item_data->offer_product_id = $shopping_cart_item->offer_product_id;
            $order_item_data->company_product_id = $shopping_cart_item->company_product_id;
            $order_item_data->product_id = $shopping_cart_item->product_id;
            $order_item_data->product_name = $shopping_cart_item->product_name;
            $order_item_data->status_id = $status_order_placed;
            $order_item_data->created_by = $logged_user_id;
            $order_item_data->created_by_name = $logged_user_names;
            $order_item_data->updated_by = $logged_user_id;
            $order_item_data->updated_by_name = $logged_user_names;

            $order_item_data->save();

        } catch(\Exception $e) {

            log_this("createOrderItemsFromShoppingCart - " . json_encode($e));
            $message = "An error occured. Could not process order.";
            throw new \Exception($message);

        }

    }

}

//////////////// END SHOPPING CART ///////////////////////////////

// resize image
function resizeImageForDisplay($image, $width=400, $height=400) {

    $img = IntImage::make($image);

	// crop image
    return $img->crop($width, $height);

}

// function get current utc date
function getCurrentUTCDate() {
    return Carbon::now();
}

function getSecondsToDate($date) {

	// diff
	$current_date = Carbon::now();
	$seconds = $current_date->diffInSeconds($date);

	$dtF = new \DateTime('@0');
	$dtT = new \DateTime("@$seconds");

	return $dtF->diff($dtT)->format('%aD %hH %iM');

}

function getDatePart($date) {

	$carbon_date = Carbon::parse($date);
	$day = $carbon_date->format('D');
	$date = $carbon_date->format('d');
	$month = $carbon_date->format('M');
	$year = $carbon_date->format('Y');

	$result = [];

	$result['day'] = $day;
	$result['date'] = $date;
	$result['month'] = $month;
	$result['year'] = $year;

	return $result;

}

function getSiteContentItem($category, $id, $status=1, $type="normal") {

	$result = array();

	//get content listing
	$resultData = SiteContent::where("site_content.status_id", $status)
						->where("site_content.id", $id)
						->where("site_content.category_id", $category)
						->join("categories", "categories.id", "=", "site_content.category_id")
						->leftJoin('images', function($join) use ($type) {
							$join->on('images.category_id', 'site_content.category_id');
							$join->where('images.section', $type);
							$join->where('images.status_id', "1");
							$join->on('images.imagetable_id', 'site_content.id');
						})
						->select(
								'site_content.*',
								'categories.code',
								'categories.cat_permalink',
								'images.full_img',
								'images.thumb_img',
								'images.thumb_img_400'
								)
						->first();

	$imagesData = DB::table('images')
						->where('imagetable_id', $id)
						->where('category_id', $category)
						->where('images.section', $type)
						->where('images.status_id', "1")
						->select(
								'images.*'
								)
						->get();

	//dd($resultData);

	$result['content'] = $resultData;
	$result['images'] = $imagesData;

	return $result;

}

function getAdminAccessToken($app_name) {

    // dd('appa name - ' . $app_name);
    // $site_settings = getSiteSettings();

	if ($app_name == 'pendoadmin') {
		$username = config('constants.pendoapi_passport.username');
		$password = config('constants.pendoapi_passport.password');
		$app_name = getPendoAdminAppName();
		$token_url = config('constants.pendoapi_passport.token_url');
    }
    // dd($username, $password, $app_name, $token_url);

	//get app access token
	$access_token = getAppAccessToken($app_name, '', $token_url, $username, $password);
	//dd($access_token, $token_url);

	return $access_token;

}

//get user reg payments
function getUserRegistrationPayments($company_user_id) {

	//start get registration payments data
	//get company reg fees gl account no
	$company_user_data = CompanyUser::find($company_user_id);
	$user_reg_payments = $company_user_data->registration_amount_paid;

	return $user_reg_payments;

}

//get user shares payments
function getUserSharesPayments($company_user_id) {

	$user_shares_payments = 0;

	$shares_account = new SharesAccountSummary();
	$shares_account = $shares_account->where("company_user_id", $company_user_id)->first();

	if ($shares_account) {
		$user_shares_payments = $shares_account->ledger_balance;
	}

	return $user_shares_payments;

}

//get user set loan limit
function getUserSetLoanLimit($loan_limit_calculation_id, $user_deposit_payments,
							 $user_reg_payments, $user_shares_payments, $initial_loan_limit) {

	//contribution criteria
	$contribution_savings = config('constants.user_contribution_criteria.savings');
	$contribution_savings_shares = config('constants.user_contribution_criteria.savings_shares');
	$contribution_savings_registration = config('constants.user_contribution_criteria.savings_registration');
	$contribution_savings_registration_shares = config('constants.user_contribution_criteria.savings_registration_shares');
	$contribution_initial_loan_limit = config('constants.user_contribution_criteria.initial_loan_limit');

								//start check if user contributions meet set LOAN LIMIT requirements
	if ($loan_limit_calculation_id == $contribution_savings) {

		$user_set_loan_limit = $user_deposit_payments;

	} elseif ($loan_limit_calculation_id == $contribution_savings_shares) {

		$user_set_loan_limit = $user_deposit_payments + $user_shares_payments;

	} elseif ($loan_limit_calculation_id == $contribution_savings_registration) {

		$user_set_loan_limit = $user_deposit_payments + $user_reg_payments;

	} elseif ($loan_limit_calculation_id == $contribution_savings_registration_shares) {

		$user_set_loan_limit = $user_deposit_payments + $user_reg_payments + $user_shares_payments;

	} elseif ($loan_limit_calculation_id == $contribution_initial_loan_limit) {

		$user_set_loan_limit = $initial_loan_limit;

	} else {

		$user_set_loan_limit = $user_deposit_payments;

	}

	return $user_set_loan_limit;

}

// get user deposit account data
function getUserDepositAccountData($phone, $account_no="", $user_id=NULL) {

    try {

        $user_dep_acct_data = DepositAccount::when($phone, function ($query) use ($phone) {
                            $query->orWhere('phone', '=', $phone);
                        })
                        ->when($account_no, function ($query) use ($account_no) {
                            $query->orWhere('account_no', '=', $account_no);
                        })
                        ->when($user_id, function ($query) use ($user_id) {
                            $query->orWhere('user_id', '=', $user_id);
                        })
                        ->first();

        return $user_dep_acct_data;

    } catch(\Exception $e) {
        $error_message = $e->getMessage();
        log_this($error_message);
        throw new \Exception($error_message);
    }

}

// get transaction account data
function getTransactionAccountData($account_no="", $transaction_id=NULL) {

    try {

        $transaction_acct_data = TransactionAccount::when($transaction_id, function ($query) use ($transaction_id) {
                            $query->orWhere('id', '=', $transaction_id);
                        })
                        ->when($account_no, function ($query) use ($account_no) {
                            $query->orWhere('account_no', '=', $account_no);
                        })
                        ->first();

        return $transaction_acct_data;

    } catch(\Exception $e) {
        $error_message = $e->getMessage();
        log_this($error_message);
        throw new \Exception($error_message);
    }

}

// get user account data
function getUserData($phone, $email="", $id=NULL) {

	//get user data
	$user_data = User::when($phone, function ($query) use ($phone) {
                            $query->orWhere('phone', '=', $phone);
                        })
                        ->when($email, function ($query) use ($email) {
                            $query->orWhere('email', '=', $email);
                        })
                        ->when($id, function ($query) use ($id) {
                            $query->orWhere('id', '=', $id);
                        })
					    ->first();

	return $user_data;

}

// get user deposit account balance
function getUserDepositAccountBalance() {

    $ledger_balance = 0;

	$logged_user_id = getLoggedUser()->id;
    $deposit_account_summary = getUserDepositAccountSummaryData();
    // dd("deposit_account_summary == ", $deposit_account_summary);
    if ($deposit_account_summary) {
        $ledger_balance = $deposit_account_summary->ledger_balance;
    }

	return $ledger_balance;

}

// get user deposit account summary data
function getUserDepositAccountSummaryData($user_id=NULL) {

    $user_id = $user_id ? $user_id : getLoggedUser()->id;

    return DepositAccountSummary::where('user_id', $user_id)->first();

}

// get user deposit account summary data
function getTransactionAccountSummaryData($account_no=NULL, $transaction_id=NULL) {

    if ((!$transaction_id) && (!$account_no)) {
        throw new \Exception("Please provide transaction id or account no to get transaction account summary");
    }

    return TransactionAccountSummary::when($transaction_id, function ($query) use ($transaction_id) {
                                        $query->where('id', '=', $transaction_id);
                                    })
                                    ->when($account_no, function ($query) use ($account_no) {
                                        $query->where('account_no', '=', $account_no);
                                    })
                                    ->first();

}

// get payment method
function getPaymentMethodName($payment_method_id) {

    $payment_method_name = "";

    $payment_method_data = getPaymentMethodData($payment_method_id);
    if ($payment_method_data) {
        $payment_method_name = $payment_method_data->name;
    }

	return $payment_method_name;

}

// get payment method
function getPaymentMethodData($payment_method_id) {

    $payment_method_name = "";

    $payment_method_data = PaymentMethod::find($payment_method_id);

	return $payment_method_data;

}

// checkEmailAccountExists
function checkEmailAccountExists($email) {

	//get user data
	$user_data = getUserData("", $email);

    if ($user_data) {
        return true;
    }

	return false;

}

// checkPhoneAccountExists
function checkPhoneAccountExists($phone) {

	//get user data
	$user_data = getUserData($phone, "");

    if ($user_data) {
        return true;
    }

	return false;

}

// activate new user
function activateNewUser($phone) {

    $status_id = getStatusActive();

    //get user data
    $user_data = getUserData($phone);

	return $user_data->updatedata($user_data->id, ['status_id' => $status_id, 'active' => '1']);

}

// get transaction data
function getTransactionData($id, $status_id="") {

	//get trans data
    $trans_data = Transaction::where("id", $id)
                               ->when($status_id, function ($query) use ($status_id) {
                                    $query->orWhere('status_id', '=', $status_id);
                               })
                               ->first();

	return $trans_data;

}

// get transaction request data
function getTransactionRequestData($id, $status_id="") {

	//get trans data
    $trans_request_data = TransactionRequest::where("id", $id)
                               ->when($status_id, function ($query) use ($status_id) {
                                    $query->orWhere('status_id', '=', $status_id);
                               })
                               ->first();

	return $trans_request_data;

}

// change transaction status
function changeTransactionStatus($trans_id, $status_id) {

    // update
    try {

        $result = Transaction::where("id", $trans_id)->update([
                'status_id' => $status_id
        ]);

        return $result;

    } catch(\Exception $e) {

        throw new \Exception($e->getMessage());

    }

}

//save user account inquiry
function saveUserAccountInquiry($user_object, $section_name, $phone, $company_id) {

	//start store user account inquiry history
	$userAccountHistory = new UserAccountInquiry();

	$userAccountHistoryData['user_id'] = $user_object->id;
	$userAccountHistoryData['first_name'] = $user_object->first_name;
	$userAccountHistoryData['last_name'] = $user_object->last_name;
	$userAccountHistoryData['phone'] = $phone;
	$userAccountHistoryData['section'] = $section_name;
	$userAccountHistoryData['company_id'] = $company_id;
	$userAccountHistoryData['created_by'] = $user_object->id;
	$userAccountHistoryData['updated_by'] = $user_object->id;

	$user_account_inquiry_entry = $userAccountHistory->create($userAccountHistoryData);
	//end store user account inquiry history

	return $user_account_inquiry_entry;

}

//check if user has a pending loan, return boolean (true or false)
function userHasPendingLoan($company_user_id, $company_id) {

	$status_open = config('constants.status.open');
	$status_unpaid = config('constants.status.unpaid');
	$status_pending = config('constants.status.pending');

	//DB::enableQueryLog();

	$userLoanAccount = LoanAccount::where('company_id', $company_id)
									->where('company_user_id', $company_user_id)
									->where(function($q) use ($status_open, $status_unpaid, $status_pending){
										$q->where('status_id', '=', $status_open);
										$q->orWhere('status_id', '=', $status_unpaid);
										$q->orWhere('status_id', '=', $status_pending);
									})
									->first();
	//print_r(DB::getQueryLog());

	if ($userLoanAccount) {

		return true;

	} else {

		return false;

	}

}

//check if user has a pending loan application, return boolean (true or false)
function userHasPendingLoanApplication($company_user_id, $company_id, $loan_application_id) {

	$status_waiting = config('constants.status.waiting');
    $status_pending = config('constants.status.pending');

	$userLoanAccount = LoanApplication::where('company_id', $company_id)
									  ->where('company_user_id', $company_user_id)
                                      ->where(function($q) use ($status_pending, $status_waiting){
                                        $q->where('status_id', '=', $status_pending);
                                        $q->orWhere('status_id', '=', $status_waiting);
                                      })
									  ->where('id', '!=', $loan_application_id)
									  ->first();

	if ($userLoanAccount) {

		return true;

	} else {

		return false;

	}

}

//get user loan repayments
function getLoanRepaymentData($company_product_id, $total_loan_plus_interest) {

	//durations
	$day_period = config('constants.duration.day');
	$week_period = config('constants.duration.week');
	$month_period = config('constants.duration.month');
	$year_period = config('constants.duration.year');

	//get the company loan product settings
	$loan_product_setting = LoanProductSetting::where('company_product_id', $company_product_id)
							->first();

	//start get loan product settings
	$interest_amount = $loan_product_setting->interest_amount;
	$loan_instalment_period = $loan_product_setting->loan_instalment_period;
	$loan_instalment_cycle = $loan_product_setting->loan_instalment_cycle;
	//end get loan product settings

	//get no of repayment cycles
	//get single repayment as fraction of total instalment

	$verified_instalment_period = "";
	$verified_instalment_cycle = "";

	if ($interest_amount > 0) {

		if ($loan_instalment_period) {

			$verified_instalment_period = $loan_instalment_period;

			if ($loan_instalment_cycle == $day_period) {
				$verified_instalment_cycle = "day";
			} else if ($loan_instalment_cycle == $week_period) {
				$verified_instalment_cycle = "week";
			} else if ($loan_instalment_cycle == $month_period) {
				$verified_instalment_cycle = "month";
			} else if ($loan_instalment_cycle == $year_period) {
				$verified_instalment_cycle = "year";
			}

		}

	}

	//calculate repayment amounts
	$repayment_amounts = json_decode(get_repayment_amounts($total_loan_plus_interest, $verified_instalment_period));

	//get loan repayment dates from today
	//get current date
	$current_date = Carbon::now();

	//array to keep repayment schedule
	$repayment_schedule_data = array();

	//set dates
	$this_repayment_dates = array();

	//dump($verified_instalment_cycle);

	//loop thru and set repayment dates
	for ($i=0; $i<$verified_instalment_period; $i++) {

		//get repayment amount from repayment_amounts array index
		$repayment_amount = format_num($repayment_amounts[$i]);

		//get new repayment date
		switch($verified_instalment_cycle){
			case "day":
				$repayment_date = $current_date->addDay();
				break;
			case "week":
				$repayment_date = $current_date->addWeek();
				break;
			case "month":
				$repayment_date = $current_date->addMonth();
				break;
			case "year":
				$repayment_date = $current_date->addYear();
				break;
			default:
				$repayment_date = $current_date->addMonth();
				break;
		}

		//dump("repayment_date", $repayment_date);

		//get first repayment
		if ($i == 0) {
			$first_repayment_date = $repayment_date->toDateString();
		}

		//get last repayment
		if ($i == ($verified_instalment_period-1)) {
			$last_repayment_date = $repayment_date->toDateString();
		}

		//create single repayment array item
		$this_repayment = array();
		$this_repayment['date'] = $repayment_date->toDateString();
		$this_repayment['amount'] = $repayment_amount;

		//add to main repayment_schedule_data array
		array_push($repayment_schedule_data, $this_repayment);
		//end create new loan repayment schedule entry

	}
	//dd($first_repayment_date, $last_repayment_date, $this_repayment_dates);

	//return repayment_schedule_data in response
	//$response['repayment_schedule'] = $repayment_schedule_data;
	$response['loan_amount'] = format_num($total_loan_plus_interest);
	$response['first_repayment_date'] = $first_repayment_date;
	$response['last_repayment_date'] = $last_repayment_date;
	$response['number_of_repayments'] = count($repayment_schedule_data);

	return show_json_success($response);

}


//CALCULATE USER LOAN LIMIT
function calculateUserLoanLimit($company_id, $company_product_id, $company_user_id) {


	//settings
	//contribution criteria
	$contribution_savings = config('constants.user_contribution_criteria.savings');
	$contribution_savings_shares = config('constants.user_contribution_criteria.savings_shares');
	$contribution_savings_registration = config('constants.user_contribution_criteria.savings_registration');
	$contribution_savings_registration_shares = config('constants.user_contribution_criteria.savings_registration_shares');

	//get user details
	$company_user_data = CompanyUser::find($company_user_id);
	$user_phone = $company_user_data->user->phone;
	$registration_amount_paid = $company_user_data->registration_amount_paid;
	//dd($registration_amount_paid);

	//check whether company requires reg and whether user has paid reg fees
	//registration event == 1
	$event_type_id = 1;
	$registration_amount = getCompanyEventCost($company_id, $event_type_id);

	//dd($registration_amount);

	if (($registration_amount >0) && ($registration_amount_paid < $registration_amount)) {

		//reg balance
		//$reg_balance = $registration_amount - $registration_amount_paid;
		$allowed_loan_amt = "Ksh. 0";
		//user has not paid registration fees, show user the message
		//$show_message = "You are not fully registered. Please pay registration fee bal of $reg_balance to proceed.";
		//$show_message = $reg_balance;
		//return show_json_error($show_message);
		//$user_registered = false;

	}

	//continue only if user is fully registered i.e. has paid reg fees if required
	//get the company loan product settings
	$loan_product_setting = LoanProductSetting::where('company_product_id', $company_product_id)
							->first();

	//start get loan product settings
	$borrow_criteria = $loan_product_setting->borrow_criteria;
	$max_loan_limit = $loan_product_setting->max_loan_limit;
	$loan_limit_calculation_id = $loan_product_setting->loan_limit_calculation_id;
	$initial_exposure_limit = $loan_product_setting->initial_exposure_limit;
	$minimum_contributions = $loan_product_setting->minimum_contributions;
	$minimum_contributions_condition_id = $loan_product_setting->minimum_contributions_condition_id;
	$loan_product_status = $loan_product_setting->loan_product_status;
	//end get loan product settings

	//is loan product active?
	//check max loan limit
	if (($loan_product_status != 1)) {

		DB::rollback();
		$show_message = "Mobile loan is not available right now.";
		log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
		throw new \Exception($show_message);

	}

	//dump("company_user_id - ", $company_user_id);

	///////////////////////////////////////////////////////////////////////
	$loan_exposure_limit_data = LoanExposureLimit::where('company_user_id', $company_user_id)
	                                             ->first();

	//dd($loan_exposure_limit_data);

	//does the user have existing loan exposure limit data?
	if ($loan_exposure_limit_data) {
		//assign loan based on existing exposure limit
		$user_loan_exposure_limit = $loan_exposure_limit_data->limit;
	} else {
		//use company default exposure limit
		$user_loan_exposure_limit = $initial_exposure_limit;
	}
	//////////////////////////////////////////////////////////////////////

	/////////////////////////////////////////////////////////////////////
	$loan_calculation_percentage = $user_loan_exposure_limit;
	/////////////////////////////////////////////////////////////////////

	//START GET USER CONTRIBUTIONS
	//start get dep acct summary payments data
	$dep_acct_summary = DepositAccountSummary::where('company_user_id', $company_user_id)->first();
	if ( $dep_acct_summary) {
		$user_deposit_payments = $dep_acct_summary->ledger_balance;
	} else {
		$user_deposit_payments = 0;
	}
	//end get dep acct summary payments data

	//dd('here', $registration_amount_paid);

	//start get registration payments data
	$user_reg_payments = getUserRegistrationPayments($company_user_id);

	//start get user shares payments data
	$user_shares_payments = getUserSharesPayments($company_user_id);

	//total user contributions
	$total_user_contributions = $user_deposit_payments + $user_reg_payments + $user_shares_payments;
	//END GET USER CONTRIBUTIONS

	//dd($user_deposit_payments, $user_reg_payments, $user_shares_payments);
	//dd($loan_limit_calculation_id);

	//start check if user contributions meet set LOAN LIMIT requirements
	if ($loan_limit_calculation_id == $contribution_savings) {
		$user_set_loan_limit = $user_deposit_payments;
	} elseif ($loan_limit_calculation_id == $contribution_savings_shares) {
		$user_set_loan_limit = $user_deposit_payments + $user_shares_payments;
	} elseif ($loan_limit_calculation_id == $contribution_savings_registration) {
		$user_set_loan_limit = $user_deposit_payments + $user_reg_payments;
	} elseif ($loan_limit_calculation_id == $contribution_savings_registration_shares) {
		$user_set_loan_limit = $user_deposit_payments + $user_reg_payments + $user_shares_payments;
	}

	//get allowed loan amt based on loan limits
	//dd($loan_calculation_percentage);
	$allowed_loan_amt = $user_set_loan_limit * ($loan_calculation_percentage/100);

	$allowed_loan_amt = formatCurrency($allowed_loan_amt);



	//CHECK CONTRIBUTIONS CONDITIONS
	if ($borrow_criteria == "contributions") {

		if (($minimum_contributions > 0) && ($minimum_contributions_condition_id)) {

			//check if user contributions meet set contribution requirements
			if ($minimum_contributions_condition_id == $contribution_savings) {
				$user_contribution_limit = $user_deposit_payments;
				$contribution_text = "deposits";
			} elseif ($minimum_contributions_condition_id == $contribution_savings_shares) {
				$user_contribution_limit = $user_deposit_payments + $user_shares_payments;
				$contribution_text = "deposits + shares";
			} elseif ($minimum_contributions_condition_id == $contribution_savings_registration) {
				$user_contribution_limit = $user_deposit_payments + $user_reg_payments;
				$contribution_text = "deposits + registration fees";
			} elseif ($minimum_contributions_condition_id == $contribution_savings_registration_shares) {
				$user_contribution_limit = $user_deposit_payments + $user_reg_payments + $user_shares_payments;
				$contribution_text = "deposits + shares + registration fees";
			}

			//dd($minimum_contributions_condition_id, $contribution_text);

			//$minimum_contributions = formatCurrency($minimum_contributions);
			//$user_contribution_limit = formatCurrency($user_contribution_limit);

			//if user does not meet miinimum contributions requirement
			if ($minimum_contributions > $user_contribution_limit) {

				/*
				$show_message = "You must have minimum $contribution_text of $minimum_contributions ";
				$show_message .= " to qualify for a loan. Your total contributions is $user_contribution_limit";
				return show_json_error($show_message);
				*/

				$allowed_loan_amt = "Ksh 0";

			}

		} else if (($minimum_contributions > 0) && (!$minimum_contributions_condition_id)) {

			//check if user has made any contribution at least 1
			if ($total_user_contributions < 1) {

				/*
				$show_message = "You must have contributions to qualify for a loan";
				return show_json_error($show_message);
				*/

				$allowed_loan_amt = "Ksh 0";

			}

		}

	}

	//set response messsage
	$show_message = "Loan limit: $allowed_loan_amt";

	//return $show_message;
	return show_json_success($show_message);

}


//get company loan product setting
function getCompanyLoanProductSetting($company_id, $loan_product_id) {

	//start get company loan exposure limit settings
	$mobile_loan_product_id = config('constants.account_settings.mobile_loan_product_id');
	$company_product_data = CompanyProduct::where("company_id", $company_id)
							->where("product_id", $loan_product_id)
							->first();
	$company_product_id = $company_product_data->id;

	$loan_product_setting = LoanProductSetting::where('company_product_id', $company_product_id)
				->first();

	return $loan_product_setting;

}

// statuses
function getPendoAdminAppName() {
    return config('constants.settings.pendoapi_app_name');
}
function getMpesaB2cUrl() {
    return config('constants.mpesa.mpesab2c_url');
}
function getStatusActive() {
    return config('constants.status.active');
}
function getStatusInactive() {
    return config('constants.status.inactive');
}
function getStatusDisabled() {
    return config('constants.status.disabled');
}
function getStatusExpired() {
    return config('constants.status.expired');
}
function getStatusConfirmed() {
    return config('constants.status.confirmed');
}
function getStatusPending() {
    return config('constants.status.pending');
}
function getStatusOrderPlaced() {
    return config('constants.status.orderplaced');
}
function getStatusSent() {
    return config('constants.status.sent');
}
function getStatusPaid() {
    return config('constants.status.paid');
}
function getStatusCompleted() {
    return config('constants.status.completed');
}
function getStatusCancelled() {
    return config('constants.status.cancelled');
}

// site
function getSiteUrl() {
    return config('constants.site.url');
}
function getSystemUserId() {
    return config('constants.barddy_company.system_user_id');
}
function getSystemUserName() {
    return config('constants.barddy_company.system_user_name');
}

// accounts
function getDefaultCompanyId() {
    return config('constants.account_settings.default_company_id');
}
function getDefaultBranchCd() {
    return config('constants.account_settings.default_branch_cd');
}
function getDefaultAccountTypeCd() {
    return config('constants.account_settings.default_account_type_cd');
}
function getTransactionAccountTypeId() {
    return config('constants.account_settings.transaction_account_type_id');
}

// payment methoods
function getPaymentMethodMpesa() {
    return config('constants.payment_methods.mpesa');
}
function getPaymentMethodCash() {
    return config('constants.payment_methods.cash');
}
function getPaymentMethodCheque() {
    return config('constants.payment_methods.cheque');
}
function getPaymentMethodBank() {
    return config('constants.payment_methods.bank');
}
function getPaymentMethodTransfer() {
    return config('constants.payment_methods.transfer');
}

// transaction roles
function getTransactionRoleBuyer() {
    return config('constants.transactionroles.buyer');
}
function getTransactionRoleSeller() {
    return config('constants.transactionroles.seller');
}
function getSelectTransactionBuyerText() {
    return config('constants.transactionroles.select_buyer_text');
}
function getSelectTransactionSellerText() {
    return config('constants.transactionroles.select_seller_text');
}
function getSelectTransactionBuyerSellerText() {
    return config('constants.transactionroles.select_buyer_seller_text');
}
function getWaitForSellerToAcceptText() {
    return config('constants.transactionroles.wait_seller_accept_text');
}
function getWaitForBuyerToAcceptText() {
    return config('constants.transactionroles.wait_buyer_accept_text');
}
function getAcceptToProceedText() {
    return config('constants.transactionroles.accept_to_proceed_text');
}

// gl account types
function getGlAccountTypeClientDeposits() {
    return config('constants.gl_account_types.client_deposits');
}
function getGlAccountTypeTransactionDeposits() {
    return config('constants.gl_account_types.transaction_deposits');
}
function getGlAccountTypeClubRefunds() {
    return config('constants.gl_account_types.club_refunds');
}
function getGlAccountTypeClubExpenses() {
    return config('constants.gl_account_types.club_expenses');
}
function getGlAccountTypeClubWithdrawals() {
    return config('constants.gl_account_types.club_withdrawals');
}

// start site texts
function getSiteTextPasswordInstructions() {
    return config('constants.sitetexts.passwordinstructions');
}
// end site texts


// gl establishment types
function getEstCategoryAdmin() {
    return config('constants.establishment_category.admin');
}
function getEstCategoryDayNightClub() {
    return config('constants.establishment_category.day_night_club');
}
function getEstCategoryRestaurant() {
    return config('constants.establishment_category.restaurant');
}
function getEstCategoryDrinksShop() {
    return config('constants.establishment_category.drinks_shop');
}
function getEstCategoryOrganization() {
    return config('constants.establishment_category.organization');
}

// get offer frequency
function getOfferFrequencydaily() {
    return config('constants.offer_frequency.daily');
}
function getOfferFrequencyweekly() {
    return config('constants.offer_frequency.weekly');
}
function getOfferFrequencymonthly() {
    return config('constants.offer_frequency.monthly');
}
function getOfferFrequencyyearly() {
    return config('constants.offer_frequency.yearly');
}

// get no images
function getNoImageThumb400() {
    return config('constants.images.no_image_thumb_400');
}
function getNoImageText() {
    return config('constants.site_text.no_photo_text');
}

// start media types
function getMediaTypeEmail() {
    return config('constants.mediatypes.email');
}
function getMediaTypeSms() {
    return config('constants.mediatypes.sms');
}
function getMediaTypeNotification() {
    return config('constants.mediatypes.notification');
}
// end media types

// pagination
function getAppPaginationShort() {
    return config('app.short_pagination_limit');
}

// start site functions
function getSiteFunctionRegistration() {
    return config('constants.sitefunctions.registration');
}
function getSiteFunctionPasswordReset() {
    return config('constants.sitefunctions.passwordreset');
}
function getSiteFunctionTransactionRequest() {
    return config('constants.sitefunctions.transactionrequest');
}
function getSiteFunctionTransactionRequestNoAccount() {
    return config('constants.sitefunctions.transactionrequest_noaccount');
}
function getSiteFunctionPaymentUserDepositAccountSuccess() {
    return config('constants.sitefunctions.payment_user_deposit_account_success');
}
function getSiteFunctionPaymentSenderTransferSuccess() {
    return config('constants.sitefunctions.payment_sender_transfer_success');
}
function getSiteFunctionPaymentRecipientTransferSuccess() {
    return config('constants.sitefunctions.payment_recipient_transfer_success');
}
// end site functions

// start site sections
function getSiteSectionTransactionRequest() {
    return config('constants.sitesections.transactionrequest');
}
// end site sections

// start account types
function getAccountTypeWalletAccount() {
    return config('constants.account_type.wallet_account');
}
function getAccountTypeTextWalletAccount() {
    return config('constants.account_type_text.wallet_account');
}
function getAccountTypeTransactionAccount() {
    return config('constants.account_type.transaction_account');
}
function getAccountTypeTextTransactionAccount() {
    return config('constants.account_type_text.transaction_account');
}
// end account types

// start sms types
function getCompanySmsType() {
    return config('constants.sms_types.company_sms');
}
function getRegistrationSmsType() {
    return config('constants.sms_types.registration_sms');
}
function getRecommendationSmsType() {
    return config('constants.sms_types.recommendation_sms');
}
function getResentRegistrationSmsType() {
    return config('constants.sms_types.resent_registration_sms');
}
function getForgotPasswordSmsType() {
    return config('constants.sms_types.forgot_password_sms');
}
function getConfirmationSmsType() {
    return config('constants.sms_types.confirmation_sms');
}
function getReminderSmsType() {
    return config('constants.sms_types.reminder_sms');
}
function getPasswordResetSmsType() {
    return config('constants.sms_types.password_reset_sms');
}
// end sms types

// is the user accepting the transaction created as a buyer or seller?
function isAcceptingUserSellerOrBuyer($trans_data) {

    // get the logged user
    $logged_user = getLoggedUser();

    // transaction id
    $trans_id = $trans_data->id;

    // get active transaction request with this transaction id
    $transaction_request_data = TransactionRequest::where('transaction_id', $trans_id)
                                                   ->where('status_id', getStatusActive())
                                                   ->first();

    // dd("transaction_request_data == ", $transaction_request_data);
    if ($transaction_request_data) {
        $transaction_sender_user_id = $transaction_request_data->sender_user_id;
        $transaction_sender_role = $transaction_request_data->sender_role;
        $transaction_recipient_role = $transaction_request_data->recipient_role;
    } else {
        $message = "Invalid transaction request link";
        throw new \Exception($message);
    }
    // dd("trans_data->status_id ", $trans_data->status_id);

    // if transaction status is not pending, it is invalid
    if ($trans_data->status_id != getStatusPending()) {
        $message = "Invalid transaction status";
        throw new \Exception($message);
    }

    // if transaction status is active, it already activated
    if ($trans_data->status_id == getStatusActive()) {
        $message = "This transaction is already active";
        throw new \Exception($message);
    }

    // chek if sender is the one accepting the request, if so, show error
    if ($logged_user->id == $transaction_sender_user_id) {
        $message = "You cannot accept a transaction request created by you";
        throw new \Exception($message);
    }

    return titlecase($transaction_recipient_role);

}

// update transaction request status
function updateTransactionStatus($trans_id, $status_id) {

    $trans = new Transaction();

    $trans_attributes['status_id'] = $status_id;

    try {

        return $trans->updatedata($trans_id, $trans_attributes);

    } catch(\Exception $e) {

        log_this(json_encode($e));
        throw new \Exception($e->getMessage());

    }

}

// update transaction request status
function updateTransactionRequestStatus($trans_request_id, $status_id) {

    $trans_request = new TransactionRequest();

    $trans_request_attributes['status_id'] = $status_id;

    try {

        return $trans_request->updatedata($trans_request_id, $trans_request_attributes);

    } catch(\Exception $e) {

        log_this(json_encode($e));
        throw new \Exception($e->getMessage());

    }

}

// activate transaction
function activateTransaction($transaction_id) {

    $logged_user = getLoggedUser();

    $transaction = Transaction::find($transaction_id);

    // get current user's role in transaction
    $current_user_role = getTransactionRole($transaction);

    if ($current_user_role == getTransactionRoleBuyer()) {
        $role_id_field = "buyer_user_id";
    } else {
        $role_id_field = "seller_user_id";
    }

    $transaction_attributes[$role_id_field] = $logged_user->id;
    $transaction_attributes['status_id'] = getStatusActive();

    try {

        log_this("Successfully updated transaction \ntransaction_id - " . $transaction_id . "\nattribs - " .
                 json_encode($transaction_attributes));
        return $transaction->updatedata($transaction_id, $transaction_attributes);

    } catch(\Exception $e) {

        log_this(json_encode($e));
        throw new \Exception($e->getMessage());

    }

}

// get transaction role
function getTransactionRole($trans_data) {

    // dd($trans_data);
    $logged_user = getLoggedUser();
    $trans_role = "";

    if ($logged_user->id == $trans_data->buyer_user_id) {
        $trans_role = getTransactionRoleBuyer();
    } else if ($logged_user->id == $trans_data->seller_user_id) {
        $trans_role = getTransactionRoleSeller();
    }

    return $trans_role;

}

// get transaction partner role
function getTransactionPartnerRole($trans_data) {

    // dd($trans_data);
    $logged_user = getLoggedUser();
    $trans_role = "";

    if ($logged_user->id == $trans_data->buyer_user_id) {
        $trans_role = getTransactionRoleSeller();
    } else if ($logged_user->id == $trans_data->seller_user_id) {
        $trans_role = getTransactionRoleBuyer();
    }

    return $trans_role;

}

// check if user created the transaction
function isTransactionCreator($trans_data) {

    // dd($trans_data);
    $logged_user = getLoggedUser();
    $is_creator = false;

    if ($logged_user->id == $trans_data->created_by) {
        $is_creator = true;
    }

    return $is_creator;

}

// get transaction role user message
function getTransactionRoleUserMessage($transaction_role, $item_data) {

    $trans_role_msg = "";

    switch ($item_data->status_id) {

        case getStatusInactive():

            if ($transaction_role == getTransactionRoleBuyer()) {
                $trans_role_msg = getSelectTransactionSellerText();
            } else if ($transaction_role == getTransactionRoleSeller()) {
                $trans_role_msg = getSelectTransactionBuyerText();
            }
            $trans_message = $trans_role_msg;
            break;

        case getStatusPending():

            if (isTransactionCreator($item_data)) {
                if ($transaction_role == getTransactionRoleBuyer()) {
                    $trans_role_msg = getWaitForSellerToAcceptText();
                } elseif ($transaction_role == getTransactionRoleSeller()) {
                    $trans_role_msg = getWaitForBuyerToAcceptText();
                }
            } else {
                $trans_role_msg = getAcceptToProceedText();
            }
            $trans_message = $trans_role_msg;
            break;

        case getStatusActive():

            $trans_role_msg = "Active";
            $trans_message = $trans_role_msg;
            break;

        case getStatusCompleted():

            $trans_role_msg = "Completed";
            $trans_message = $trans_role_msg;
            break;

        case getStatusCancelled():

            $trans_role_msg = "Cancelled";
            $trans_message = $trans_role_msg;
            break;


        default:
            $trans_message = getSelectTransactionBuyerSellerText();

    }

    return $trans_message;

}

// get my transaction message
function getMyTransactionMessage($item_data) {

    $transaction_role = getTransactionRole($item_data);

    $transaction_role_msg = getTransactionRoleUserMessage($transaction_role, $item_data);

    return $transaction_role_msg;

}

// get barddy company id
function getBarddyCompanyId() {
    $site_settings = getSiteSettings();
    return $site_settings['company_id'];
}

// get barddy company name
function getBarddyCompanyName() {
    $site_settings = getSiteSettings();
    return $site_settings['company_name_title'];
}

// get barddy company phone
function getBarddyCompanyPhone() {
    $site_settings = getSiteSettings();
    // dd($site_settings);
    return $site_settings['contact_phone'];
}


// get payment data
function getPaymentData($id="", $mpesa_code="")
{

    $payment_data = "";

    if ($id || $mpesa_code) {

        $payment_data = Payment::when($id, function ($query) use ($id) {
                                    $query->where('id', $id);
                                })
                                ->when($mpesa_code, function ($query) use ($mpesa_code) {
                                    $query->where('trans_id', $mpesa_code);
                                })
                                ->first();
        return $payment_data;

    }

    return $payment_data;

}

// check if mpesa code has been used
function isMpesaCodeUsed($mpesa_code) {

    // get data
    $mpesa_code_data = getPaymentData("", $mpesa_code);

    if ($mpesa_code_data) {
        return true;
    } else {
        return false;
    }

}


//GET Mpesa B2C request data
function getMpesaB2cRequestData($request_id, $app_name) {

	//check whether request exists and its status/ res_code
    $mpesab2c_url = getMpesaB2cUrl();
    $pendoapi_app_name = getPendoAdminAppName();

	$mpesab2c_url = $mpesab2c_url . "/" . $request_id;
	//dd($mpesab2c_url);

	//get app access token
	$access_token = getAdminAccessToken($pendoapi_app_name);

    if ($access_token) {

	    //set params
		$params = [
			'json' => [
				"request_id"=> $request_id,
				"app_name"=> $app_name
			]
		];
		//dd($access_token, $params, $mpesab2c_url);

		//start request
		$result = sendAuthGetApi($mpesab2c_url, $access_token, $params);
		//dd($result);

		log_this(">>>>>>>>> GET SNB MPESA B2C API RESULT :\n\n" . json_encode($params) . " - " . json_encode($result) . "\n\n\n");

	    return $result;

	} else {

		return false;

	}

}


//Get Mpesa B2C Balance data
function getMpesaB2cBalanceData($shortcode) {

	$url = config('constants.mpesa.mpesab2c_balance_url');
	$url = $url . "/" . $shortcode;
	//dd($url);
    $pendoapi_app_name = getPendoAdminAppName();
	//get app access token
	$access_token = getAdminAccessToken($pendoapi_app_name);

    if ($access_token) {

	    //set params
		$params = [
			'json' => []
		];
		//dd($access_token, $params, $url);
		//start request
		$result = sendAuthGetApi($url, $access_token, $params);
		//dd($result);
		log_this(">>>>>>>>> GET SNB MPESA B2C BALANCE API RESULT :\n\n" . json_encode($params) . " - " . json_encode($result) . "\n\n\n");

	    return $result;

	} else {

		return false;

	}

}


//check if Mpesa Balance Limit has been Reached
function checkIfMpesaBalanceLimitReached($company_id) {

	//get company mpesa balance limit
	$mpesa_balance_limit_data = MpesaB2CTopupLevel::where('company_id', $company_id)->first();
	//dd($mpesa_balance_limit_data->amount, $company_id);

	log_this("mpesa_balance_limit_data - $company_id - ".  json_encode($mpesa_balance_limit_data));

	//continue if limit data exists
	if ($mpesa_balance_limit_data) {

		$limit_amount = $mpesa_balance_limit_data->amount;

		//continue if the limit is set at more than zero
		if ($limit_amount > 0) {

			$the_company_name = "";
			//start get company mpesa shortcode data
			$mpesa_shortcode_data = getMainCompanyMpesaShortcode($company_id);
			log_this(json_encode($mpesa_shortcode_data));
			$mpesa_shortcode_data = json_decode($mpesa_shortcode_data);
			//dd($mpesa_shortcode_data);
			$mpesa_shortcode_data = $mpesa_shortcode_data->data;
			$shortcode_number = $mpesa_shortcode_data->shortcode_number;
			//company details
			$phone_number = $mpesa_shortcode_data->company->data->phone;
			$company_email = $mpesa_shortcode_data->company->data->email;
			$company_name = $mpesa_shortcode_data->company->data->name;
			$company_short_name = $mpesa_shortcode_data->company->data->short_name;
			//set company name
			if ($company_short_name) {
				$the_company_name = $company_short_name;
			} else {
				$the_company_name = $company_name;
			}
			//end get company mpesa shortcode data

			log_this("data - $shortcode_number, $limit_amount, $phone_number, $company_email, $the_company_name");

			//notify company admin as necessary i.e. if topup limit is reached
			notifyAdminIfMpesaBalanceLimitReached($shortcode_number, $limit_amount, $phone_number, $company_email, $the_company_name, $company_id);

		}

	}

}

//check if Mpesa Balance Limit has been Reached
function notifyAdminIfMpesaBalanceLimitReached($shortcode_number, $limit_amount, $phone_number, $company_email, $company_name, $company_id) {

	log_this("notifyAdminIfMpesaBalanceLimitReached data - $shortcode_number - $limit_amount - $phone_number - $company_email - $company_name - $company_id");
	//$limit_reached = false;

	//continue if the limit is set at more than zero
	if ($limit_amount > 0) {

		//start get company mpesa balance
		$mpesa_balance_data = getMpesaB2cBalanceData($shortcode_number);
		log_this("mpesa_balance_data - ".  json_encode($mpesa_balance_data));

		if ($mpesa_balance_data) {
			$mpesa_balance_data = json_decode($mpesa_balance_data);
			//dd($mpesa_balance_data, $limit_amount);
			$mpesa_balance_data = $mpesa_balance_data->data;
			$mpesa_balance_amount = $mpesa_balance_data->utility_bal;

			//if mpesa balance is less than top up level
			if ($mpesa_balance_amount < $limit_amount) {
				//$limit_reached = true;
				//send admin Mpesa Balance Notification
				$balance_amount_fmt = formatCurrency($mpesa_balance_amount);
				$limit_amount_fmt = formatCurrency($limit_amount);

				if ($phone_number) {

					$snb_helpline = config('constants.snb_settings.helpline');
					$snb_company_name = config('constants.snb_settings.company_name');
					$sms_type_id = config('constants.sms_types.company_sms');

					$sms_message = "Dear $company_name admin, your company Mpesa balance has gone below the threshold of:  $limit_amount_fmt. ";
					$sms_message .= "Your current mpesa B2C balance is:  $balance_amount_fmt. ";
					$sms_message .= "Please reload your account to facilitate further disbursements. Regards, $snb_company_name. Helpline: $snb_helpline";

					log_this("sms_message - $sms_message");
					//dd($sms_message);

					$result = createSmsOutbox($sms_message, $phone_number, $sms_type_id, $company_id);

				}

			}
		}

	}

	//return $limit_reached;

}

//GET Mpesa B2C Main request data - from b2c_outgoing_ack
function getMpesaB2cRequestMainData($request_id, $app_name) {

	//check whether request exists and its status/ res_code
	$mpesab2c_url = getMpesaB2cUrl();

	//get orig_con_id
	$result_decode = json_decode(getMpesaB2cRequestData($request_id, $app_name));
	$result_decode = $result_decode->data;
	//dd($result_decode);
	$orig_con_id = $result_decode->orig_con_id;

	$mpesab2c_url = $mpesab2c_url . "/main/" . $orig_con_id;
	//dd($mpesab2c_url);

    $pendoapi_app_name = getPendoAdminAppName();

	//get app access token
	$access_token = getAdminAccessToken($pendoapi_app_name);

    if ($access_token) {

	    //set params
		$params = [];

		//start create new sms
		$result = sendAuthGetApi($mpesab2c_url, $access_token, $params);

		log_this(">>>>>>>>> GET SNB MPESA B2C API RESULT :\n\n" . json_encode($params) . " - " . json_encode($result) . "\n\n\n");

	    return $result;

	} else {

		return false;

	}

	return $response;

}


//SEND Mpesa B2C request
function sendDataToMpesaB2c($shortcode, $phone, $amount, $tran_ref_txt, $company_id, $src_id, $app_name) {

	$params['shortcode']      	= $shortcode;
	$params['phone']     		= $phone;
	$params['amount']     		= $amount;
	$params['tran_ref_txt']     = $tran_ref_txt;
	$params['company_id']     	= $company_id;
	$params['request_id']     	= $src_id;
	$params['app_name']     	= $app_name;

	$app_send_sms = config('constants.settings.app_send_sms');

	//check whether we shud send request
	if ($app_send_sms == "true") {

		//send data
		$response = sendMpesaB2c($params);

		log_this(">>>>>>>>> SNB MPESA B2C REQUEST API RESULT :\n\n" . json_encode($params) . " - " . json_encode($response) . "\n\n\n");

	} else {

		$response = "";

	}

	//log_this("\n\n\n\n>>>>>>>>> send mpesa b2c response :\n\n" . json_encode($response));

	return $response;

}


function sendMpesaB2c($data) {

	//******************* START SEND SMS VIA API ***********************//
	$mpesab2c_url = getMpesaB2cUrl();

    $pendoapi_app_name = getPendoAdminAppName();

	//get app access token
	$access_token = getAdminAccessToken($pendoapi_app_name);

    if ($access_token) {

	    //set params
		$params = [
			'json' => [
				"shortcode"=> $data['shortcode'],
				"phone"=> $data['phone'],
				"amount"=> $data['amount'],
				"tran_ref_txt"=> $data['tran_ref_txt'],
				"company_id"=> $data['company_id'],
				"request_id"=> $data['request_id'],
				"app_name"=> $data['app_name']
			]
		];

		//dd($access_token, $params, $mpesab2c_url);

		//start create new entry
		$result = sendAuthPostApi($mpesab2c_url, $access_token, $params);

		log_this(">>>>>>>>> SNB MPESA B2C API RESULT :\n\n" . json_encode($params) . " - " . json_encode($result) . "\n\n\n");

	    return $result;

	} else {

		return false;

	}

    //end create new sms
    //******************* END SEND SMS VIA API ***********************//

}


function resendB2CRequestToPendoadmin($requestId, $origConID, $transStatus, $conId="",
            $transID="", $rxFullName="", $receiver="", $completedTime="", $srcIp="",
            $res_code="", $res_desc="", $utility_bal="") {

    //log_this("access_token - $access_token\n\n");

    $mpesa_b2c_url = getMpesaB2cUrl();
    $url = $mpesa_b2c_url . "/requestUpdate";

    $username = config('constants.pendoapi_passport.username');
    $password = config('constants.pendoapi_passport.password');
    $pendoapi_app_name = getPendoAdminAppName();
    $token_url = config('constants.pendoapi_passport.token_url');

    //get app access token
    $access_token = getAppAccessToken($pendoapi_app_name, "", $token_url, $username, $password);

    if ($access_token) {

        $params = [
            'json' => [
                "request_id"=> $requestId,
                "orig_con_id"=> $origConID,
                "trans_status"=> $transStatus,
                "con_id"=> $conId,
                "trans_id"=> $transID,
                "rx_fullname"=> $rxFullName,
                "receiver"=> $receiver,
                "completed_time"=> $completedTime,
                "src_ip"=> $srcIp,
                "res_code"=> $res_code,
                "res_desc"=> $res_desc,
                "utility_bal"=> $utility_bal
            ]
		];
		//dd($params, $access_token, $url);

        //start post data

        log_this(">>>>>>>>>>>> URL:\n" . json_encode($url) . "\n\n");

        log_this(">>>>>>>>>>>> PARAMS:\n". json_encode($params) . "\n\n");

		$result = sendAuthPostApi($url, $access_token, $params);
		//dd("resss" , $result, $url);

        $result_decode = json_decode(json_encode($result));
        log_this(json_encode($result) . "\n\n");
		log_this(json_encode($result_decode) . "\n\n");
		//dd($result_decode);

        return $result_decode;

    }

}



//store audit data
function storeLoanApplicationAudit($loan_application_id) {

	//store audits
	//call loan application updated event
	$loan_application_data_fresh = LoanApplication::find($loan_application_id);
	//dd($loan_application_data_fresh);

	event(new LoanApplicationUpdated($loan_application_data_fresh));

}





//SEND SMS
function sendApiSms($data) {

	//******************* START SEND SMS VIA API ***********************//
	$send_sms_url = config('constants.bulk_sms.send_sms_url');
	$pendoapi_app_name = getPendoAdminAppName();
	$app_mode = config('constants.settings.app_mode');

	//get app access token
    $access_token = getAdminAccessToken($pendoapi_app_name);

    // get company id
    $site_settings = getSiteSettings();
    $company_id  = $site_settings['company_id'];

    if ($access_token) {

	    //set params
		$params = [
			'json' => [
				"sms_message"=> $data['sms_message'],
				"phone_number"=> $data['phone_number'],
				"company_id"=> $company_id
			]
        ];
        // dd("params === ", $params);

		//write to the log file
		if ($app_mode != "test") {

			//start create new sms
			$result = sendAuthPostApi($send_sms_url, $access_token, $params);

			log_this(">>>>>>>>> SNB SEND SMS API RESULT :\n\n" . json_encode($params) . " - " . json_encode($result) . "\n\n\n");

		} else {

			$result = "";

		}

	    return $result;

	} else {

		return false;

	}

    //end create new sms
    //******************* END SEND SMS VIA API ***********************//

}

//get user permissions
function isUserHasPermissions($is_admin_user="1", $permissions=array()) {

    //get logged in user
    $user = getLoggedUser();
    $user_id = $user->id;
    $company_id = $user->company_id;

    if ($user->hasRole('superadministrator')) {
        return true;
    }

    if (($user->hasRole('administrator')) && ($is_admin_user=="1")) {
        return true;
    }

    //check if user has any of the permissions
    if ($permissions) {
        foreach ($permissions as $permission) {
            //check if user has this permission
            if ($user->hasPermission($permission)) {
                return true;
            }
        }

    }

    return false;

}

//get user permissions
function isSectionPermissions($section_name) {

    //get section name
    if ($section_name == 'savings_account') {
        //check savings_account permissions
    }

    return false;

}

//get user companies
function getUserCompanyIds($request=null) {

	$companies_array = getUserCompanies($request);
	//dd("companies_array", $companies_array);
	$companies_num_array = [];

	//get data
	foreach ($companies_array as $company) {
		//store in array
		$companies_num_array[] = $company->id;
	}

	return $companies_num_array;

}


//get user companies
function getUserCompanies($request=null) {

	//get logged in user
	$user = getLoggedUser();

	$companies = [];
	$companies_array = [];
    $allowed_companies_array = [];
    $allowed_companies_num_array = [];

    //start check if user is superadmin, show all companies, else show a user's companies
    if ($user->hasRole('superadministrator')) {
        //get all
        $companies = Company::all();
    } else if ($user->hasRole('administrator')) {
		$company_id = $user->company->id;
        $companies = Company::where('id', $company_id)
                            ->where('can_sell', '1')
                            ->get();
    } else {
        abort(503);
	}

    foreach ($companies as $company) {
        //store paybill in array
        $companies_array[] = $company;
		$allowed_companies_array[] = $company;

        $allowed_companies_num_array[] = $company->id;
	}
    //end check if user is superadmin, show all companies, else show a user's companies

	if ($request != null) {

		if ($request->has('companies')) {

			//reset array
			$companies_array = [];
			//get companies data
			$url_companies = $request->companies;
			$url_companies_array = explode(",", $url_companies);

			//if array exists, filter from those
			//else user is suoperadin, allow all
			if (count($url_companies_array)) {

				//get only user allowed companies
				foreach ($allowed_companies_array as $allowed_companies_item) {

					//accept paybill data if it matches allowed companies array
					if (in_array($allowed_companies_item->id, $url_companies_array))
					{
						$companies_array[] = $allowed_companies_item;
					}

				}

			}

		}

	}

	return $companies_array;

}

//extract user companies
function extractUserCompanyIdsArray($companies) {

	$company_ids_array = [];

	foreach ($companies as $company)  {
		$company_ids_array[] = $company->id;
	}

	return $company_ids_array;

}

//does company have reg forms or any attachements
//start get mail attachments
function doesCompanyHaveAssets($company_id, $event_type_id) {

    $has_attachments = 0;

    $company_assets = getCompanyAssets($company_id, $event_type_id);
    $site_url = config('constants.site.url');

    $attach_record = [];

    foreach ($company_assets as $company_asset) {
        $asset_url = $site_url . $company_asset->asset_url;
        //get file extension
        $ext = pathinfo($asset_url, PATHINFO_EXTENSION);
        $attach_record_prop = [];
        $attach_title_slug = getStrSlug($company_asset->name) . '.' . $ext;
        $attach_record_prop['as'] = $attach_title_slug;
        $attach_record_prop['mime'] = $company_asset->mime;
        //array_push($attach_record, $attach_record_prop);
        $attach_record[] = [$asset_url => $attach_record_prop];
    }

    if (count($attach_record)) {
        $has_attachments = 1;
    }

    return $has_attachments;

}

//get all user companies
function getAllUserCompanies($request) {

	//get logged in user
	$user = getLoggedUser();

	$companies_array = [];
    $allowed_companies_array = [];
    $allowed_companies_num_array = [];

    //start check if user is superadmin, show all companies, else show a user's companies
    if ($user->hasRole('superadministrator')) {
        //get all
        $companies = Company::all();
    } else if ($user->hasRole('administrator')) {
        $companies = $user->company;
    } else {
        abort(503);
    }

	return $companies;

}

function generateAgeRangeArray($start, $end) {

	//$array = range($start, $end);

	$index = 0; // array index
	$the_array = array();

	for ($i=$start;$i<=$end;$i++) {
		/*loop start, foreach, while, etc.*/
		$the_array[$index]['id'] = $i;
		$the_array[$index]['age'] = $i;
		$index++;
	}


	/* $nums_array = [];
	$num = array();

	for ($i=$start;$i<=$end;$i++) {

		//create single array item

		$num['id'] = $i;
		$num['age'] = $i;

		//array_push($nums_array, $num);

	} */

	return $the_array;

}

//get company paybill no
function getMainCompanyPaybill($company_id) {

	$params['company_id'] = $company_id;
	$mpesa_paybill_data = getApiCompanyPaybills($params);
	$mpesa_paybill_data = json_decode($mpesa_paybill_data);
	$mpesa_paybill_data = $mpesa_paybill_data->data;

	$mpesa_paybill_data_array= (Array)$mpesa_paybill_data;

    if (count($mpesa_paybill_data_array)) {
    	$mpesa_paybill_data = $mpesa_paybill_data_array[0];

    	$mpesa_paybill = $mpesa_paybill_data->paybill_number;
    } else {
        $mpesa_paybill = null;
    }

	return $mpesa_paybill;

}

function getMainCompanyPaybillData($company_id="", $paybill_number='') {

	$params['company_id'] = $company_id;
	$params['paybill_number'] = $paybill_number;
	$mpesa_paybill_data = getApiCompanyPaybills($params);
	//dd($mpesa_paybill_data);
	$mpesa_paybill_data = json_decode($mpesa_paybill_data);
	$mpesa_paybill_data = $mpesa_paybill_data->data;

	$mpesa_paybill_data_array= (Array)$mpesa_paybill_data;
	$mpesa_paybill_data = $mpesa_paybill_data_array[0];

	return $mpesa_paybill_data;

}

//get company data
function getCompanyPaybillData($company_id) {

	//******************* START GET COMPANIES VIA PENDO API ***********************//

	$url = config('constants.pendoapi_urls.companies_url');
	$url = $url . "/" . $company_id;
    $pendoapi_app_name = getPendoAdminAppName();
    // dd("company_id ", $company_id, $url, $pendoapi_app_name);


	//get app access token
    $access_token = getAdminAccessToken($pendoapi_app_name);
    // dd("access_token ", $access_token);

    if ($access_token) {

		//set params
		$params = [
			'json' => []
		];
		$params = array();

		//start get companies data
		$result = sendAuthGetApi($url, $access_token, $params);

		log_this(">>>>>>>>> SNB GET PENDO COMPANIES API RESULT :\n\n" . json_encode($result) . "\n\n\n");

		return $result;

	}

	//***************** END GET COMPANIES VIA PENDO API ***********************//

}

//get sms data
function getRemoteSmsData($id, $page, $company_ids, $phone, $start_date, $end_date,
						  $order_by, $order_style, $limit, $report, $account_search="") {

	$url = config('constants.bulk_sms.get_sms_outbox_url');
	$pendoapi_app_name = getPendoAdminAppName();

	$companies = implode(",", $company_ids);

	//get app access token
	$access_token = getAdminAccessToken($pendoapi_app_name);

    if ($access_token) {

	    //set params
		$params = [
			'json' => [
				"companies"=> $companies,
				"page"=> $page,
				"phone"=> $phone,
				"account_search"=> $account_search,
				"start_date"=> $start_date,
				"end_date"=> $end_date,
				"order_by"=> $order_by,
				"order_style"=> $order_style,
				"limit"=> $limit,
				"report"=> $report
			]
		];

		//start get sms data
		$result = sendAuthGetApi($url, $access_token, $params);

	    return $result;

	} else {

		return false;

	}

	//end get sms data

}

//show single sms
function showRemoteSmsData($id, $company_ids) {

	$url = config('constants.bulk_sms.get_sms_outbox_url');
	$url = $url . "/" . $id;
	$pendoapi_app_name = getPendoAdminAppName();

	$companies = implode(",", $company_ids);

	//get app access token
	$access_token = getAdminAccessToken($pendoapi_app_name);

    if ($access_token) {

	    //set params
		$params = [
			'json' => [
				"companies"=> $companies
			]
		];

		//start get sms data
		$result = sendAuthGetApi($url, $access_token, $params);

	    return $result;

	} else {

		return false;

	}

}

//get company paybill no
function getApiCompanyPaybills($data) {

	$get_paybills_url = config('constants.mpesa_paybills.get_paybills_url');
    $pendoapi_app_name = getPendoAdminAppName();

	//get app access token
	$access_token = getAdminAccessToken($pendoapi_app_name);

    if ($access_token) {

	    //set params
		$params = [
			'json' => [
				"company_id"=> $data['company_id'],
				"report"=> "1"
			]
		];

		//start get paybill data
		$result = sendAuthGetApi($get_paybills_url, $access_token, $params);

	    return $result;

	} else {

		return false;

	}

	//end get paybill data

}

//get all paybills
function getApiAllPaybills() {

	$get_paybills_url = config('constants.mpesa_paybills.get_paybills_url');
    $pendoapi_app_name = getPendoAdminAppName();

	//get app access token
	$access_token = getAdminAccessToken($pendoapi_app_name);

    if ($access_token) {

	    //set params
		$params = [
			'json' => [
				"app_name"=> "snb",
				"report"=> "1"
			]
		];

		//start get paybill data
		$result = sendAuthGetApi($get_paybills_url, $access_token, $params);
		//dd($result);

	    return $result;

	} else {

		return false;

	}

}

//get company paybill no
function getMainSingleCompanyPaybill($company_id) {

	//******************* START SEND SMS VIA API ***********************//
	$url = config('constants.mpesa_paybills.get_paybills_url');
    $pendoapi_app_name = getPendoAdminAppName();

	//get app access token
	$access_token = getAdminAccessToken($pendoapi_app_name);

    if ($access_token) {

	    //set params
		$params = [];

		$url = $url . '/getmainpaybill/' . $company_id;

		$result = sendAuthGetApi($url, $access_token, $params);

		log_this(">>>>>>>>> SNB GET MAIN PAYBILL API RESULT :\n\n" . json_encode($result) . "\n\n\n");

	    return $result;

	} else {

		return false;

	}

}

//start get company mpesa shortcode
function getMainCompanyMpesaShortcode($company_id) {

	//******************* START SEND SMS VIA API ***********************//
	$url = config('constants.mpesa_shortcodes.get_shortcodes_url');
    $pendoapi_app_name = getPendoAdminAppName();

	//get app access token
	$access_token = getAdminAccessToken($pendoapi_app_name);

    if ($access_token) {

	    //set params
		$params = [];

		$url = $url . '/getmainshortcode/' . $company_id;

		$result = sendAuthGetApi($url, $access_token, $params);

		//log_this(">>>>>>>>> SNB GET MAIN SHORTCODE API RESULT :\n\n" . json_encode($result) . "\n\n\n");

	    return $result;

	} else {

		return false;

	}

}

//get company paybill no
function getMainSingleCompanyPaybillData($paybill_number, $app_name="snb") {

	//******************* START SEND SMS VIA API ***********************//
	$url = config('constants.mpesa_paybills.get_paybills_url');
    $pendoapi_app_name = getPendoAdminAppName();

	//get app access token
	$access_token = getAdminAccessToken($pendoapi_app_name);

    if ($access_token) {

	    //set params
		$params = [
			'json' => [
				"app_name"=> $app_name
			]
		];

		$url = $url . '/getmainpaybilldata/' . $paybill_number;

		$result = sendAuthGetApi($url, $access_token, $params);

		log_this(">>>>>>>>> SNB GET MAIN PAYBILL DATA API RESULT :\n\n" . json_encode($result) . "\n\n\n");

	    return $result;

	} else {

		return false;

	}

}

function sendApiSms2($data) {

	//******************* START SEND SMS VIA API ***********************//
	$username = config('constants.pendoapi_passport.username');
    $password = config('constants.pendoapi_passport.password');
    $send_sms_url = config('constants.bulk_sms.send_sms_url');
    $app_name = getPendoAdminAppName();
    $token_url = config('constants.pendoapi_passport.token_url');

    //$app_short_name = config('constants.settings.app_short_name');
    //$logname = $app_short_name . '_sms';

	//get access token
	$access_token = prepare_access_token($app_name, $user_id, $token_url, $username, $password);

	//set params
	$params = [
		'json' => [
			"sms_message"=> $data['sms_message'],
			"phone_number"=> $data['phone_number']
		]
	];

	//start create new sms
	$result = sendAuthPostApi($send_sms_url, $access_token, $params);

	log_this(">>>>>>>>> SNB SEND SMS API RESULT :\n\n" . json_encode($params) . " - " . json_encode($result) . "\n\n\n");

    //end create new sms
    //******************* END SEND SMS VIA API ***********************//

}

function showActiveStatusText($status_id, $tag="span", $tag_styles="", $text="", $show_html=1) {

    // if no text is supplied, use status_text
    if (!$text) {
        $text = $status_id == 1 ? "Active" : "Not Active";
    }

    // if no tag is supplied, use span
    if (!$tag) {
        $tag = "span";
    }

    // get color
    $text_color = $status_id == 1 ? "text-success" : "text-danger";

    // create open and close tags
    $open_tag = "<" . $tag . " class='$tag_styles $text_color'>";
    $close_tag = "</" . $tag . ">";

    if ($show_html==1) {
        return $open_tag . $text . $close_tag;
    } else {
        return $text;
    }

}

function getStatusText($status_id) {

    $status_active = config('constants.status.active');
    $status_active_text = config('constants.status_text.active');
    $status_open = config('constants.status.open');
    $status_open_text = config('constants.status_text.open');
    $status_disabled = config('constants.status.disabled');
    $status_disabled_text = config('constants.status_text.disabled');
    $status_pending = config('constants.status.pending');
    $status_pending_text = config('constants.status_text.pending');
    $status_expired = config('constants.status.expired');
    $status_expired_text = config('constants.status_text.expired');
    $status_confirmed = config('constants.status.confirmed');
    $status_confirmed_text = config('constants.status_text.confirmed');
    $status_cancelled = config('constants.status.cancelled');
    $status_cancelled_text = config('constants.status_text.cancelled');
    $status_sent = config('constants.status.sent');
    $status_sent_text = config('constants.status_text.sent');
    $status_authorized = config('constants.status.authorized');
    $status_authorized_text = config('constants.status_text.authorized');
    $status_declined = config('constants.status.declined');
    $status_declined_text = config('constants.status_text.declined');
    $status_processed = config('constants.status.processed');
    $status_processed_text = config('constants.status_text.processed');
    $status_disbursed = config('constants.status.disbursed');
    $status_disbursed_text = config('constants.status_text.disbursed');
    $status_b2c_request = config('constants.status.b2c_request');
    $status_b2c_request_text = config('constants.status_text.b2c_request');
    $status_b2c_response_ok = config('constants.status.b2c_response_ok');
    $status_b2c_response_ok_text = config('constants.status_text.b2c_response_ok');
    $status_b2c_completed = config('constants.status.b2c_completed');
    $status_b2c_completed_text = config('constants.status_text.b2c_completed');
    $status_b2c_request_failed = config('constants.status.b2c_request_failed');
    $status_b2c_request_failed_text = config('constants.status_text.b2c_request_failed');
    $status_b2c_complete_failed = config('constants.status.b2c_complete_failed');
    $status_b2c_complete_failed_text = config('constants.status_text.b2c_complete_failed');
    $status_b2c_failed = config('constants.status.b2c_failed');
    $status_b2c_failed_text = config('constants.status_text.b2c_failed');
    $status_b2c_deleted = config('constants.status.b2c_deleted');
    $status_b2c_deleted_text = config('constants.status_text.b2c_deleted');

    $status_b2c_callback_undefined = config('constants.status.b2c_callback_undefined');
    $status_b2c_callback_undefined_text = config('constants.status_text.b2c_callback_undefined');

    $status_c2b_request = config('constants.status.c2b_request');
    $status_c2b_request_text = config('constants.status_text.c2b_request');
    $status_c2b_response_ok = config('constants.status.c2b_response_ok');
    $status_c2b_response_ok_text = config('constants.status_text.c2b_response_ok');
    $status_c2b_completed = config('constants.status.c2b_completed');
    $status_c2b_completed_text = config('constants.status_text.c2b_completed');
    $status_c2b_request_failed = config('constants.status.c2b_request_failed');
    $status_c2b_request_failed_text = config('constants.status_text.c2b_request_failed');
    $status_c2b_complete_failed = config('constants.status.c2b_complete_failed');
    $status_c2b_complete_failed_text = config('constants.status_text.c2b_complete_failed');
    $status_c2b_failed = config('constants.status.c2b_failed');
    $status_c2b_failed_text = config('constants.status_text.c2b_failed');
    $status_c2b_callback_undefined = config('constants.status.c2b_callback_undefined');
    $status_c2b_callback_undefined_text = config('constants.status_text.c2b_callback_undefined');

    $status_request_ok = config('constants.status.request_ok');
    $status_request_ok_text = config('constants.status_text.request_ok');
    $status_inactive = config('constants.status.inactive');
    $status_inactive_text = config('constants.status_text.inactive');

    // new
    $status_suspended = config('constants.status.suspended');
    $status_suspended_text = config('constants.status_text.suspended');
    $status_completed = config('constants.status.completed');
    $status_completed_text = config('constants.status_text.completed');
    $status_awaitingdelivery = config('constants.status.awaitingdelivery');
    $status_awaitingdelivery_text = config('constants.status_text.awaitingdelivery');
    $status_notconfirmed = config('constants.status.notconfirmed');
    $status_notconfirmed_text = config('constants.status_text.notconfirmed');
    $status_paid = config('constants.status.paid');
    $status_paid_text = config('constants.status_text.paid');
    $status_notpaid = config('constants.status.notpaid');
    $status_notpaid_text = config('constants.status_text.notpaid');
    $status_deleted = config('constants.status.deleted');
    $status_deleted_text = config('constants.status_text.deleted');
    $status_orderplaced = config('constants.status.orderplaced');
    $status_orderplaced_text = config('constants.status_text.orderplaced');
    $status_redeemed = config('constants.status.redeemed');
    $status_redeemed_text = config('constants.status_text.redeemed');
    $status_waiting = config('constants.status.waiting');
    $status_waiting_text = config('constants.status_text.waiting');
    $status_deactivated = config('constants.status.deactivated');
    $status_deactivated_text = config('constants.status_text.deactivated');
    $status_incompleted = config('constants.status.incompleted');
    $status_incompleted_text = config('constants.status_text.incompleted');

    $status_text = "";

    if ($status_id == $status_active) {
        $status_text = $status_active_text;
    } else if ($status_id == $status_inactive) {
        $status_text = $status_inactive_text;
    } else if ($status_id == $status_open) {
        $status_text = $status_open_text;
    } else if ($status_id == $status_disabled) {
        $status_text = $status_disabled_text;
    } else if ($status_id == $status_pending) {
        $status_text = $status_pending_text;
    } else if ($status_id == $status_expired) {
        $status_text = $status_expired_text;
    } else if ($status_id == $status_confirmed) {
        $status_text = $status_confirmed_text;
    } else if ($status_id == $status_cancelled) {
        $status_text = $status_cancelled_text;
    } else if ($status_id == $status_sent) {
        $status_text = $status_sent_text;
    } else if ($status_id == $status_authorized) {
        $status_text = $status_authorized_text;
    } else if ($status_id == $status_declined) {
        $status_text = $status_declined_text;
    } else if ($status_id == $status_processed) {
        $status_text = $status_processed_text;
    } else if ($status_id == $status_disbursed) {
        $status_text = $status_disbursed_text;
    } else if ($status_id == $status_b2c_request) {
        $status_text = $status_b2c_request_text;
    }

    else if ($status_id == $status_b2c_response_ok) {
        $status_text = $status_b2c_response_ok_text;
    } else if ($status_id == $status_b2c_completed) {
        $status_text = $status_b2c_completed_text;
    } else if ($status_id == $status_b2c_request_failed) {
        $status_text = $status_b2c_request_failed_text;
    } else if ($status_id == $status_b2c_complete_failed) {
        $status_text = $status_b2c_complete_failed_text;
    } else if ($status_id == $status_b2c_failed) {
        $status_text = $status_b2c_failed_text;
    } else if ($status_id == $status_b2c_deleted) {
        $status_text = $status_b2c_deleted_text;
    } else if ($status_id == $status_request_ok) {
        $status_text = $status_request_ok_text;
    } else if ($status_id == $status_b2c_callback_undefined) {
        $status_text = $status_b2c_callback_undefined_text;
    } else if ($status_id == $status_c2b_request) {
        $status_text = $status_c2b_request_text;
    } else if ($status_id == $status_c2b_response_ok) {
        $status_text = $status_c2b_response_ok_text;
    } else if ($status_id == $status_c2b_completed) {
        $status_text = $status_c2b_completed_text;
    } else if ($status_id == $status_c2b_request_failed) {
        $status_text = $status_c2b_request_failed_text;
    } else if ($status_id == $status_c2b_complete_failed) {
        $status_text = $status_c2b_complete_failed_text;
    } else if ($status_id == $status_c2b_failed) {
        $status_text = $status_c2b_failed_text;
    } else if ($status_id == $status_c2b_callback_undefined) {
        $status_text = $status_c2b_callback_undefined_text;
    }

    else if ($status_id == $status_suspended) {
        $status_text = $status_suspended_text;
    } else if ($status_id == $status_completed) {
        $status_text = $status_completed_text;
    } else if ($status_id == $status_awaitingdelivery) {
        $status_text = $status_awaitingdelivery_text;
    } else if ($status_id == $status_notconfirmed) {
        $status_text = $status_notconfirmed_text;
    } else if ($status_id == $status_paid) {
        $status_text = $status_paid_text;
    } else if ($status_id == $status_notpaid) {
        $status_text = $status_notpaid_text;
    } else if ($status_id == $status_deleted) {
        $status_text = $status_deleted_text;
    } else if ($status_id == $status_orderplaced) {
        $status_text = $status_orderplaced_text;
    } else if ($status_id == $status_redeemed) {
        $status_text = $status_redeemed_text;
    } else if ($status_id == $status_waiting) {
        $status_text = $status_waiting_text;
    } else if ($status_id == $status_deactivated) {
        $status_text = $status_deactivated_text;
    } else if ($status_id == $status_incompleted) {
        $status_text = $status_incompleted_text;
    } else {
        $status_text = $status_active_text;
    }

    return $status_text;

}

function getStatusColor($status_id) {

    $status_active = config('constants.status.active');
    $status_open = config('constants.status.open');
    $status_disabled = config('constants.status.disabled');
    $status_pending = config('constants.status.pending');
    $status_expired = config('constants.status.expired');
    $status_confirmed = config('constants.status.confirmed');
    $status_cancelled = config('constants.status.cancelled');
    $status_sent = config('constants.status.sent');
    $status_authorized = config('constants.status.authorized');
    $status_declined = config('constants.status.declined');
    $status_processed = config('constants.status.processed');
    $status_disbursed = config('constants.status.disbursed');
    $status_b2c_request = config('constants.status.b2c_request');
    $status_b2c_response_ok = config('constants.status.b2c_response_ok');
    $status_b2c_completed = config('constants.status.b2c_completed');
    $status_b2c_request_failed = config('constants.status.b2c_request_failed');
    $status_b2c_complete_failed = config('constants.status.b2c_complete_failed');
    $status_b2c_failed = config('constants.status.b2c_failed');
    $status_b2c_deleted = config('constants.status.b2c_deleted');
    $status_request_ok = config('constants.status.request_ok');
    $status_inactive = config('constants.status.inactive');
    $status_b2c_callback_undefined = config('constants.status.b2c_callback_undefined');
    $status_c2b_request = config('constants.status.c2b_request');
    $status_c2b_response_ok = config('constants.status.c2b_response_ok');
    $status_c2b_completed = config('constants.status.c2b_completed');
    $status_c2b_request_failed = config('constants.status.c2b_request_failed');
    $status_c2b_complete_failed = config('constants.status.c2b_complete_failed');
    $status_c2b_failed = config('constants.status.c2b_failed');
    $status_c2b_callback_undefined = config('constants.status.c2b_callback_undefined');
    $status_suspended = config('constants.status.suspended');
    $status_completed = config('constants.status.completed');
    $status_awaitingdelivery = config('constants.status.awaitingdelivery');
    $status_notconfirmed = config('constants.status.notconfirmed');
    $status_paid = config('constants.status.paid');
    $status_notpaid = config('constants.status.notpaid');
    $status_deleted = config('constants.status.deleted');
    $status_orderplaced = config('constants.status.orderplaced');
    $status_redeemed = config('constants.status.redeemed');
    $status_waiting = config('constants.status.waiting');
    $status_deactivated = config('constants.status.deactivated');
    $status_incompleted = config('constants.status.incompleted');

    $color_code = "";

    switch ($status_id) {

        case $status_active:
            $color_code = "text-success";
            break;
        case $status_inactive:
            $color_code = "text-danger";
            break;
        case $status_open:
            $color_code = "text-primary";
            break;
        case $status_disabled:
            $color_code = "text-danger";
            break;
        case $status_pending:
            $color_code = "text-danger";
            break;
        case $status_expired:
            $color_code = "text-danger";
            break;
        case $status_confirmed:
            $color_code = "text-success";
            break;
        case $status_cancelled:
            $color_code = "text-danger";
            break;
        case $status_sent:
            $color_code = "text-success";
            break;
        case $status_authorized:
            $color_code = "text-success";
            break;
        case $status_declined:
            $color_code = "text-danger";
            break;
        case $status_processed:
            $color_code = "text-success";
            break;
        case $status_disbursed:
            $color_code = "text-success";
            break;
        case $status_b2c_request:
            $color_code = "text-primary";
            break;
        case $status_b2c_response_ok:
            $color_code = "text-success";
            break;
        case $status_b2c_completed:
            $color_code = "text-success";
            break;
        case $status_b2c_request_failed:
            $color_code = "text-danger";
            break;
        case $status_b2c_complete_failed:
            $color_code = "text-danger";
            break;
        case $status_b2c_failed:
            $color_code = "text-danger";
            break;
        case $status_b2c_deleted:
            $color_code = "text-danger";
            break;
        case $status_request_ok:
            $color_code = "text-success";
            break;
        case $status_b2c_callback_undefined:
            $color_code = "text-danger";
            break;
        case $status_c2b_request:
            $color_code = "text-info";
            break;
        case $status_c2b_response_ok:
            $color_code = "text-success";
            break;
        case $status_c2b_completed:
            $color_code = "text-success";
            break;
        case $status_c2b_request_failed:
            $color_code = "text-danger";
            break;
        case $status_c2b_complete_failed:
            $color_code = "text-danger";
            break;
        case $status_c2b_failed:
            $color_code = "text-danger";
            break;
        case $status_c2b_callback_undefined:
            $color_code = "text-danger";
            break;
        case $status_suspended:
            $color_code = "text-danger";
            break;
        case $status_completed:
            $color_code = "text-success";
            break;
        case $status_awaitingdelivery:
            $color_code = "text-warning";
            break;
        case $status_notconfirmed:
            $color_code = "text-danger";
            break;
        case $status_paid:
            $color_code = "text-danger";
            break;
        case $status_notpaid:
            $color_code = "text-success";
            break;
        case $status_deleted:
            $color_code = "text-warning";
            break;
        case $status_orderplaced:
            $color_code = "text-danger";
            break;
        case $status_redeemed:
            $color_code = "text-danger";
            break;
        case $status_waiting:
            $color_code = "text-danger";
            break;
        case $status_deactivated:
            $color_code = "text-danger";
            break;
        case $status_incompleted:
            $color_code = "text-danger";
            break;
        default:
            $color_code = "text-success";

    }

    return $color_code;

}

function showStatusText($status_id, $tag="span", $tag_styles="", $text="") {

    // if no text is supplied, use status_text
    if (!$text) {
        $text = getStatusText($status_id);
    }

    // if no tag is supplied, use span
    if (!$tag) {
        $tag = "span";
    }

    // get color
    $text_color = getStatusColor($status_id);
    // dd("text == ", $text, $status_id, $text_color);

    // tag_styles == other styles to apply to tag

    // create open and close tags
    $open_tag = "<" . $tag . " class='$tag_styles $text_color'>";
    $close_tag = "</" . $tag . ">";

    return $open_tag . $text . $close_tag;

}

function disablePreviousResets($email) {

    // start disable any previous confirm code sent to this number
    $status_active = getStatusActive();
    $status_disabled = getStatusDisabled();

    $result = PasswordReset::where('email', $email)
                           ->where('status_id', $status_active)
                           ->update(['status_id' => $status_disabled]);

    return $result;

}

// START SEND EMAILS
// send password reset email
function sendPasswordResetEmail($new_reset_data) {

    $email = $new_reset_data['email'];
    $token = $new_reset_data['token'];

    // get user data
    $user_data = getUserData("", $email);
    $first_name = $user_data->first_name;

    // formulate email
    $email_media_type = getMediaTypeEmail();
    $passwordreset_site_function = config('constants.sitefunctions.passwordreset');

    // get site settings
    $site_settings = getSiteSettings();
    $email_footer = $site_settings['email_footer'];
    $email_salutation = $site_settings['email_salutation'];
    $company_full_name = $site_settings['company_full_name_ltd'];
    $email_subject = $site_settings['email_subject_password_reset'];
    $link_expiry_minutes = $site_settings['password_reset_token_lifetime_minutes'];

    // create salutation replacement array
    $salutation_replacement_array = array();
    $salutation_replacement_array[] = $first_name;
    // replace [[name]] in template
    $email_salutation = replaceDelimitersInTemplate($email_salutation, $salutation_replacement_array);

    $email_template = getMediaTemplate($passwordreset_site_function, $email_media_type);

    // formulate message from template
    $set_email_template = $email_template->text ? $email_template->text : $email_template->default_text;

    // read and check for delimiters in template
    $reset_url = getSiteUrl() . "/auth/password/reset/" . $token;
    $reset_link = "<a href='$reset_url'>$reset_url</a>";

    // create replacement array
    $replacement_array = array();
    $replacement_array[] = $reset_link;
    $replacement_array[] = $link_expiry_minutes;

    // formulate email
    // replace [[name]] and [[token]] in template
    $email_text = replaceDelimitersInTemplate($set_email_template, $replacement_array);
    // dd("email_text == ", $email_text); getRegistrationSmsType

    // set subject
    $title = $email_subject;
    $company_id = NULL;
    $panel_text = "";
    $table_text = "";
    $parent_id = NULL;
    $reminder_message_id = NULL;

    // send email to user
    try {

        sendTheEmailToQueue(
            $email,
            $email_subject,
            $title,
            $company_full_name,
            $email_text,
            $email_salutation,
            $company_id,
            $email_footer,
            $panel_text,
            $table_text,
            $parent_id,
            $reminder_message_id
        );

    } catch(\Exception $e) {

        // dd($e);
        throw new \Exception($e->getMessage());

    }

}

// send transaction request email
function sendTransactionRequestEmail($sender_user_data, $recipient_user_data, $transaction_data) {

    // get transaction partner role
    $transaction_partner_role = getTransactionPartnerRole($transaction_data);

    // get sender user data
    $sender_first_name = $sender_user_data->first_name;
    $sender_phone = $sender_user_data->phone;
    $sender_email = $sender_user_data->email;

    // get recipient user data
    $recipient_first_name = $recipient_user_data->first_name;
    $recipient_email = $recipient_user_data->email;

    // get trans data
    $transaction_title = $transaction_data->title;

    // formulate email
    $email_media_type = getMediaTypeEmail();
    $transaction_request_site_function = getSiteFunctionTransactionRequest();

    // get site settings
    $site_settings = getSiteSettings();
    $email_footer = $site_settings['email_footer'];
    $email_salutation = $site_settings['email_salutation'];
    $company_full_name = $site_settings['company_full_name_ltd'];
    $email_subject = $site_settings['email_subject_transaction_request'];

    // create salutation replacement array
    $salutation_replacement_array = array();
    $salutation_replacement_array[] = $recipient_first_name;

    // replace [[name]] in template
    $email_salutation = replaceDelimitersInTemplate($email_salutation, $salutation_replacement_array);

    $email_template = getMediaTemplate($transaction_request_site_function, $email_media_type);

    // formulate message from template
    $set_email_template = $email_template->text ? $email_template->text : $email_template->default_text;

    // trans accept_link
    $trans_accept_link = route('transaction-requests.accept', ['token' => $transaction_data->transaction_request_code]);

    // create replacement array
    $replacement_array = array();
    $replacement_array[] = $sender_first_name;
    $replacement_array[] = $sender_phone;
    $replacement_array[] = $transaction_partner_role;
    $replacement_array[] = $transaction_title;
    $replacement_array[] = "<a href='$trans_accept_link'>" . $trans_accept_link . "</a>";

    // formulate email
    // replace [[name]] and [[token]] in template
    $email_text = replaceDelimitersInTemplate($set_email_template, $replacement_array);

    // set subject
    $title = $email_subject;
    $company_id = NULL;
    $panel_text = "";
    $table_text = "";
    $parent_id = NULL;
    $reminder_message_id = NULL;

    // send email to user
    sendTheEmailToQueue($recipient_email, $email_subject, $title, $company_full_name, $email_text, $email_salutation,
                        $company_id, $email_footer, $panel_text, $table_text, $parent_id, $reminder_message_id);

}

// END SEND EMAILS

// send transaction request email
function saveNewTransactionRequest($sender_user_data, $recipient_user_data, $transaction_data) {

    // get transaction partner role
    $sender_transaction_role = getTransactionRole($transaction_data);
    $recipient_transaction_role = getTransactionPartnerRole($transaction_data);

    $transaction_request_attributes = [];

    // recipient data
    $recipient_user_id = $recipient_user_data->id ? $recipient_user_data->id : "";
    $recipient_user_email = $recipient_user_data->email ? $recipient_user_data->email : "";
    $recipient_user_phone = $recipient_user_data->phone ? $recipient_user_data->phone : "";
    $recipient_user_id_no = $recipient_user_data->id_no ? $recipient_user_data->id_no : "";

    // confirm code
    $site_settings = getSiteSettings();
    $transaction_request_code_length = $site_settings['transaction_request_code_length'];
    $transaction_request_code = generateCode($transaction_request_code_length, false, 'lud');

    // create new recipient transaction request
    $new_transaction_request = new TransactionRequest();

    $transaction_request_attributes['transaction_id'] = $transaction_data->id;
	$transaction_request_attributes['sender_user_id'] = $sender_user_data->id;
	$transaction_request_attributes['sender_role'] = $sender_transaction_role;
	$transaction_request_attributes['recipient_role'] = $recipient_transaction_role;
	$transaction_request_attributes['recipient_user_id'] = $recipient_user_id;
	$transaction_request_attributes['recipient_email'] = $recipient_user_email;
    $transaction_request_attributes['recipient_phone'] = $recipient_user_phone;
	$transaction_request_attributes['recipient_id_no'] = $recipient_user_id_no;
	$transaction_request_attributes['confirm_code'] = $transaction_request_code;
	$transaction_request_attributes['status_id'] = getStatusActive();
    $transaction_request_attributes['created_by'] = $sender_user_data->id;
	$transaction_request_attributes['created_by_name'] = $sender_user_data->full_name;
	$transaction_request_attributes['updated_by'] = $sender_user_data->id;
    $transaction_request_attributes['updated_by_name'] = $sender_user_data->full_name;
    // dd("transaction_request_attributes == ", $transaction_request_attributes);

    try {

        $new_transaction_request_result = $new_transaction_request->create($transaction_request_attributes);

        log_this("new_transaction_request_result\n\n" . json_encode($new_transaction_request_result));

        // return $new_transaction_request_result;

    } catch(\Exception $e) {

        log_this($e);
        throw new \Exception($e->getMessage());

    }

    ////////////////////////////////////////////////////
    // get transaction partner role
    $transaction_partner_role = getTransactionPartnerRole($transaction_data);

    // get sender user data
    $sender_first_name = $sender_user_data->first_name;
    $sender_phone = $sender_user_data->phone;

    // get trans data
    $transaction_title = $transaction_data->title;

    // formulate notification
    // get template
    $notification_template = getMediaTemplate(getSiteFunctionTransactionRequest(), getMediaTypeNotification());

    // formulate message from template
    $set_notification_template = $notification_template->text ? $notification_template->text : $notification_template->default_text;

    // notification_link
    $notification_link = route('transaction-requests.accept', ['token' => $transaction_request_code]);

    // create replacement array
    $replacement_array = array();
    $replacement_array[] = $sender_first_name;
    $replacement_array[] = $sender_phone;
    $replacement_array[] = $transaction_partner_role;
    $replacement_array[] = $transaction_title;
    $replacement_array[] = "<a href='$notification_link'>" . $notification_link . "</a>";

    // formulate notification
    $notification_text = replaceDelimitersInTemplate($set_notification_template, $replacement_array);
    // dd("notification_text === ", $notification_text);
    ////////////////////////////////////////////////////

    // create new recipient notification
    $new_notification = new UserNotification();

    $notification_message = $notification_text;

    $notification_attributes['user_id'] = $sender_user_data->id;
    $notification_attributes['notification_message'] = $notification_message;
    $notification_attributes['notification_link'] = $notification_link;
    $notification_attributes['notification_section'] = getSiteSectionTransactionRequest();
    $notification_attributes['notification_section_id'] = $transaction_data->id;
    $notification_attributes['notification_object'] = 'App\Entities\TransactionRequest';
    $notification_attributes['status_id'] = getStatusActive();
    $notification_attributes['created_by'] = $sender_user_data->id;
    $notification_attributes['created_by_name'] = $sender_user_data->full_name;
    $notification_attributes['updated_by'] = $sender_user_data->id;
    $notification_attributes['updated_by_name'] = $sender_user_data->full_name;

    // dd("notification_attributes == ", $notification_attributes);

    try {

        $new_notification_result = $new_notification->create($notification_attributes);

        log_this("new_notification_result\n\n" . json_encode($new_notification_result));

        // return $new_notification_result;

    } catch(\Exception $e) {

        log_this($e);
        throw new \Exception($e->getMessage());

    }

    return $transaction_request_code;

}

function createPhoneConfirmCode($confirm_code, $phone, $phone_country, $establishment_id, $sms_type_id=1, $sms_message="", $user_id="") {

    // start disable any previous confirm code sent to this number
    $status_disabled = config('constants.status.disabled');
    $status_active = config('constants.status.active');
    $default_sms_type_id = getRegistrationSmsType();

    if (!$sms_type_id) { $sms_type_id = $default_sms_type_id; }

    $phone = getDatabasePhoneNumber($phone);

    ConfirmCode::where('phone', $phone)
                ->when($sms_type_id, function ($query) use ($sms_type_id) {
                    $query->where('sms_type_id', $sms_type_id);
                })
                ->when($establishment_id, function ($query) use ($establishment_id) {
                    $query->where('company_id', $establishment_id);
                })
                ->when($user_id, function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                })
                ->update(['status_id' => $status_disabled]);
    // end disable any previous confirm code sent to this number

    // start create new phone confirm code
    $attributes['phone'] = $phone;
    $attributes['phone_country'] = $phone_country;
    $attributes['confirm_code'] = $confirm_code;
    if ($establishment_id) {
        $attributes['company_id'] = $establishment_id;
    }
    $attributes['status_id'] = $status_active;
    $attributes['sms_type_id'] = $sms_type_id;
    if ($user_id) {
        $attributes['user_id'] = $user_id;
    }

    ConfirmCode::create($attributes);
    // end create new phone confirm code

    // send sms to user phone
    createSmsOutbox($sms_message, $phone, $sms_type_id, $establishment_id);

}

function createEmailConfirmCode($confirm_code, $email, $sms_type_id, $user_id) {

    //start disable any previous sent registration sms to this number
    $status_disabled = config('constants.status.disabled');
	$status_active = config('constants.status.active');

    DB::table('confirm_codes')
                    ->where('user_id', $user_id)
                    ->where('email', $email)
                    ->where('sms_type_id', $sms_type_id)
                    ->update(['status_id' => $status_disabled]);
    //end disable any previous sent registration sms to this number
    //start create new email confirm code
    $attributes['email'] = $email;
    $attributes['confirm_code'] = $confirm_code;
    $attributes['status_id'] = $status_active;
    $attributes['sms_type_id'] = $sms_type_id;
	$attributes['user_id'] = $user_id;

    ConfirmCode::create($attributes);
	//end create new email confirm code

}


function getUserMpesaPaybills($user, $request) {

    $paybills_array = [];
    $allowed_paybills_array = [];
    $allowed_paybills_num_array = [];

    //start check if user is superadmin, show all companies, else show a user's companies
    if ($user->hasRole('superadministrator')) {
        //get all paybills
        $paybills = getApiAllPaybills();
    } else if ($user->hasRole('administrator')) {
        $company_id = $user->company->id;
        $attributes['company_id'] = $company_id;
        $paybills = getApiCompanyPaybills($attributes);
        //get company paybills
    } else {
        abort(503);
    }

    //decode paybills data
    $paybills = json_decode($paybills);
    $paybills_data =  $paybills->data;

    foreach ($paybills_data as $paybill_item) {
        //store paybill in array
        $paybills_array[] = $paybill_item;
        $allowed_paybills_array[] = $paybill_item;
        $allowed_paybills_num_array[] = $paybill_item->paybill_number;
    }
    //end check if user is superadmin, show all companies, else show a user's companies

    if ($request->has('paybills')) {
        //reset array
        $paybills_array = [];
        //get paybills data
        $url_paybills = $request->paybills;
        $url_paybills_array = explode(",", $url_paybills);

        //get only user allowed paybills
        foreach ($allowed_paybills_array as $allowed_paybill_item) {

            //accept paybill data if it matches allowed paybills array
            if (in_array($allowed_paybill_item->paybill_number, $url_paybills_array))
            {
              $paybills_array[] = $allowed_paybill_item;
            }

        }

    }

    return $paybills_array;

}


function getAllUserMpesaPaybills($user) {

    $paybills_array = [];

    //start check if user is superadmin, show all companies, else show a user's companies
    if ($user->hasRole('superadministrator')) {
        //get all paybills
        $paybills = getApiAllPaybills();
    } else if ($user->hasRole('administrator')) {
        $company_id = $user->company->id;
        $attributes['company_id'] = $company_id;
        $paybills = getApiCompanyPaybills($attributes);
        //get company paybills
    } else {
        abort(503);
    }

    //decode paybills data
    $paybills = json_decode($paybills);
    $paybills_data =  $paybills->data;

    foreach ($paybills_data as $paybill_item) {
        //store paybill in array
        $paybills_array[] = $paybill_item;
    }
    //end check if user is superadmin, show all companies, else show a user's companies

    return $paybills_array;

}


function createGlAccountEntry($payment_id, $amount, $gl_account_type_id, $company_id, $phone, $dr_cr_ind="DR",
							  $tran_ref_txt="", $tran_desc="", $summ_sign="pos", $hist_sign="pos",
							  $summ_action="pos", $hist_action="pos") {

	//create payment gl entries
	try {

		//start save to company gl accounts
		$paymentGlAccountsStore = new PaymentGlAccountsStore();

		$gl_account_store_attributes['payment_id'] = $payment_id;
		$gl_account_store_attributes['amount'] = $amount;
		$gl_account_store_attributes['gl_account_type_id'] = $gl_account_type_id;
		$gl_account_store_attributes['company_id'] = $company_id;
		$gl_account_store_attributes['phone'] = $phone;
		$gl_account_store_attributes['dr_cr_ind'] = $dr_cr_ind;
		$gl_account_store_attributes['tran_ref_txt'] = $tran_ref_txt;
		$gl_account_store_attributes['tran_desc'] = $tran_desc;
		$gl_account_store_attributes['summ_sign'] = $summ_sign;
		$gl_account_store_attributes['hist_sign'] = $hist_sign;
		$gl_account_store_attributes['summ_action'] = $summ_action;
		$gl_account_store_attributes['hist_action'] = $hist_action;

		//dd($gl_account_store_attributes);

		$gl_account_entry = $paymentGlAccountsStore->createItem($payment_id, $gl_account_store_attributes);

		return $gl_account_entry;

		//end save to company gl accounts

	} catch(\Exception $e) {

		DB::rollback();
		//dd($e);
		$message = 'Error. Could not create gl_account_entry - ' . $e->getMessage();
		log_this($message);
		throw new \Exception($message);

	}

}

//******************* START SMS API FUNCTIONS ********************//

	function getAppAccessToken($app_name, $user_id, $token_url, $username, $password) {

		if ($app_name || $user_id) {

			//get app's access token
			//check if session data exists, use it if so
			$access_token = "";
			$refresh_token = "";
			$access_token_expires_in = "";
			$access_token_expires_time = "";

			//fetch user tokens data
            //$access_token_data = UserAccessToken::where('app_name', $app_name)->first();
            $access_token_data = new UserAccessToken();
            $access_token_data = $access_token_data
						->when($app_name, function ($query) use ($app_name) {
							$query->where('user_access_tokens.app_name', $app_name);
						}, function ($query) use ($user_id) {
							$query->where('user_access_tokens.user_id', $user_id);
						})
						->first();

			if ($access_token_data) {
				$access_token = $access_token_data->access_token;
				$refresh_token = $access_token_data->refresh_token;
				$access_token_expires_in = $access_token_data->expires_in;
				$access_token_expires_time = $access_token_data->expires_time;
			}

			if ($access_token) {

				$current_time = time();
				//if current time is less than expires time + 500, fetch new token
				if ($current_time > ($access_token_expires_time)) {
					//fetch new access token
					$access_token = prepare_access_token($app_name, $user_id, $token_url, $username, $password);
				}

			} else {

				$access_token = prepare_access_token($app_name, $user_id, $token_url, $username, $password);

			}

			return $access_token;

		} else {

			return null;

		}

	}


	//start get app access token
	function prepare_access_token($app_name, $user_id, $token_url, $username, $password)
	{

		//dd($app_name, $token_url, $username, $password);

		try
		{
			$body = [
				'json' => [
					"username" => $username,
					"password" => $password
				]
			];

			$url = $token_url;
			$dataclient = getTokenGuzzleClient();
			$response = $dataclient->request('POST', $url, $body);
			$result = json_decode($response->getBody());

			//start store token in access tokens table
			//$access_token_data = UserAccessToken::where('app_name', $app_name)->first();
            $access_token_data = new UserAccessToken();
            $access_token_data = $access_token_data
                        ->when($app_name, function ($query) use ($app_name) {
							$query->where('user_access_tokens.app_name', $app_name);
						}, function ($query) use ($user_id) {
							$query->where('user_access_tokens.user_id', $user_id);
						})
						->first();

			if ($access_token_data) {

				//update access token data
				//minus 11000 seconds to expiry time (locale allowance(+3hrs = 3600 * 3 = 10800) to expiry)
				$response = $access_token_data->update([
								'access_token'    	=> $result->access_token,
								'refresh_token'   	=> $result->refresh_token,
								'expires_in'    	=> $result->expires_in,
								'expires_time'   	=> (time() + $result->expires_in) - 11000
							]);

			} else {

				//create new record
				$user_acces_token = new UserAccessToken();

					if ($app_name) { $user_acces_token->app_name = $app_name; }
					if ($user_id) { $user_acces_token->user_id = $user_id; }
					$user_acces_token->access_token = $result->access_token;
					$user_acces_token->refresh_token = $result->refresh_token;
					$user_acces_token->expires_in = $result->expires_in;
					$user_acces_token->expires_time = time() + $result->expires_in;

				$user_acces_token->save();
				//end create new record

			}
			//end store token in access tokens table

			//return access_token
			return $result->access_token;

		} catch (RequestException $e) {
			$response = handleAccessTokenError($e, $app_name, $user_id, $token_url, $username, $password);
			return $response;
		}

	}
	//end get pendoapi access token


    //send params with post to api
    function sendAuthPostApi($url, $token, $params)
    {
        try
        {
            $dataclient = getGuzzleClient($token);
            $response = $dataclient->request('POST', $url, $params);
            $result = $response->getBody()->getContents();
            return $result;
        } catch (RequestException $e) {
            return handleGuzzleError($e);
        }
	}

	//send params with get to api
    function sendAuthGetApi($url, $token='', $params=array())
    {
        try
        {

			$dataclient = getGuzzleClient($token);
            $response = $dataclient->request('GET', $url, $params);
            $result = $response->getBody()->getContents();
			return $result;

        } catch (RequestException $e) {

			return handleGuzzleError($e);

        }
    }

	//start handle guzzle errors
	function handleAccessTokenError($e, $app_name, $user_id, $url, $username, $password)
	{
		dd($e);
		$status_code = $e->getResponse()->getStatusCode();
		if ($status_code == 400)
		{
			//$app_name = getPendoAdminAppName();
            //$token_url = config('constants.pendoapi_passport.token_url');
            prepare_access_token($app_name, $user_id, $url, $username, $password);
		}
	}

    function handleGuzzleError(RequestException $e) {

        // dd($e);
        $status_code = "";
        $message = "";

        if ($e->getResponse()) {
            $status_code = $e->getResponse()->getStatusCode();
            //$message = $e->getResponse()->getMessage();
            $message = Psr7\str($e->getResponse());
        }

        $response["error"] = true;
        $response["status_code"] = $status_code;
        $response["message"] = $message;

        return $response;

    }
    //end handle guzzle errors


//******************* END SMS API FUNCTIONS ********************//


function createSmsOutbox($message, $phone, $sms_type_id='1', $company_id='', $company_user_id='') {

    $app_mode = config('constants.settings.app_mode');
    $app_short_name = config('constants.settings.app_short_name');
    $default_sms_type_id = getRegistrationSmsType();

    if (!$sms_type_id) { $sms_type_id = $default_sms_type_id; }

    // get barddy username
    $site_settings = getSiteSettings();
    $sms_user_name = $site_settings['sms_user_name'];

	//convert phone number
    $phone = getDatabasePhoneNumber($phone);

	//start create new outbox
    $sms_attributes['message'] = $message;
	$sms_attributes['sms_user_name'] = $sms_user_name;
    $sms_attributes['sms_type_id'] = $sms_type_id;
    if ($company_id) {
        $sms_attributes['company_id'] = $company_id;
        $sms_attributes['created_by'] = $company_id;
	    $sms_attributes['updated_by'] = $company_id;
    }
	if ($company_user_id) {
		$sms_attributes['company_user_id'] = $company_user_id;
	}
	$sms_attributes['phone_number'] = $phone;

	$smsoutbox = new SmsOutbox();
	$result = $smsoutbox->create($sms_attributes);
    // end create new outbox

    //if we are in test mode, dont send sms, save to log file
    if ($app_mode != 'test') {

        /* start testing */
        //send sms
		$params['sms_message']      = $message;
		$params['phone_number']     = $phone;

        $result = sendApiSms($params);
        // dd("result === ", $result, $message);
        /* end testing */

        $message_log = "\n\n************************************ SNB TEST SMS MSG ************************************\n\n\n";
        $message_log .= "Phone:\t\t\t\t" . $phone . "\n";
        $message_log .= "\nsms_user_name:\t\t\t" . $sms_user_name . "\n";
		$message_log .= "\nestablishment_id:\t\t\t" . $company_id . "\n";
		$message_log .= "\nsms_type_id:\t\t\t" . $sms_type_id . "\n";
		$message_log .= "\ncompany_user_id:\t\t\t" . $company_user_id . "\n";
        $message_log .= "Message:\t\t\t" . $message . "\n\n\n";
        $message_log .= "************************************ SNB TEST SMS MSG ************************************\n\n\n\n\n\n\n\n\n";

        //save the log file
        $logname = $app_short_name . '_sms';
        log_this($message_log, $logname);
        $result = $message_log;

    } else {

		//send sms
		$params['sms_message']      = $message;
		$params['phone_number']     = $phone;

		log_this("\n\n\n\n>>>>>>>>> send user sms - Request :\n\n" . json_encode($params));

		//send sms
        $result = sendApiSms($params);

    }

    return $result;

}

//activate a user and company user data
function getCompanyEventCost($company_id, $event_type_id) {

    $event_cost = 0;
    $event_cost_data = DB::table('companies')
                ->join('ussd_events', 'companies.id', '=', 'ussd_events.company_id')
                ->join('ussd_event_maps', 'ussd_event_maps.ussd_event_id', '=', 'ussd_events.id')
                ->where('ussd_event_maps.ussd_event_type_id', $event_type_id)
                ->where('ussd_events.company_id', $company_id)
                ->select('ussd_events.amount')
                //->getQuery() // Optional: downgrade to non-eloquent builder so we don't build invalid User objects.
                ->first();
    if ($event_cost_data) {
        //set the reg amount
        $event_cost = $event_cost_data->amount;
    }

    return $event_cost;

}

//get company assets
function getCompanyAssets($company_id, $event_type_id) {

	$status_active = config('constants.status.active');
	$status_disabled = config('constants.status.disabled');

	//DB::enableQueryLog();

	$assets_data = DB::table('assets')
				->join('companies', 'companies.id', '=', 'assets.company_id')
                ->join('ussd_events', 'companies.id', '=', 'ussd_events.company_id')
				->join('ussd_event_maps', 'ussd_event_maps.ussd_event_id', '=', 'ussd_events.id')
                ->where('ussd_event_maps.ussd_event_type_id', $event_type_id)
				->where('ussd_events.company_id', $company_id)
				->where('assets.status_id', $status_active)
                ->select('assets.name', 'assets.asset_url', 'assets.mime', 'assets.short_url')
				->get();

	//print_r(DB::getQueryLog());

	//dd('stop here', $account_data);

    return $assets_data;

}

//activate a user and company user data
function activate_user_company($user_id, $company_id) {

    $status_active = config('constants.status.active');
    $status_disabled = config('constants.status.disabled');

    //start check if user is still inactive (i.e. new user)
    //if so, update
    $user_inactive_data = User::where('id', $user_id)
                    ->where('status_id', $status_disabled)
                    ->first();

    if ($user_inactive_data) {
        //update user
        $user_update = User::where('id', $user_id)
            ->update([
                        'status_id' => $status_active,
                        'active' => 1
                    ]);
    }
    //end check if user is still inactive (i.e. new user)


    //start check if company user entry is active
    //if so, update
    $company_user_inactive_data = CompanyUser::where('user_id', $user_id)
                    ->where('company_id', $company_id)
                    ->where('status_id', $status_disabled)
                    ->first();

    if ($company_user_inactive_data) {
        //update user
        $user_update = CompanyUser::where('user_id', $user_id)
                    ->where('company_id', $company_id)
                    ->update([
                        'status_id' => $status_active
                    ]);
    }
    //end check if company user entry is active

}


function formatErrorJson($error) {
	return json_encode($error);
}

function show_error($message) {
	$response['message'] = $message;
	$response['status_code'] = "422";
	$response['error'] = "1";

	return $response;
}

function show_success($message) {
    $response['message'] = $message;
    $response['status_code'] = "200";
    $response['error'] = '0';

    return $response;
}

function show_json_error($message, $status_code='422') {
	$response['message'] = $message;
	$response['status_code'] = $status_code;
	$response['error'] = "1";

	return json_encode($response);
}

function show_json_success($message) {
	$response['message'] = $message;
	$response['status_code'] = "200";
	$response['error'] = "0";

	return json_encode($response);
}

function show_error_response($message) {
	$response['error'] = true;
    $response['message'] = $message;

	return show_json_error($response);
}

function show_success_response($message) {
	$response['error'] = false;
    $response['message'] = $message;

	return show_json_success($response);
}

function createCarbonDate($date, $format) {

	$result = Carbon::createFromFormat($format, $date);
	// dd($result);

	return $result;
}

function showCompoundMessage($status_code, $message="", $data="", $data_tag="", $error="", $has_data_tag=null) {

    $final_message = [];

    if (!$message) {
        $message = getMessageText($status_code);
    }

    if ($data) {
        $data = json_decode(json_encode($data));
    }

    if (!$error) {
        $error = getErrorCode($status_code);
    }

    // generate message
    $final_message['message'] = $message;
    $final_message['status_code'] = $status_code;
    $final_message['error'] = $error;
    if ($data) {
        // get the tag
        $the_tag = $data_tag ? $data_tag : 'data';
        // if the json has been transformed with data tag
        if ($has_data_tag) {
            $final_message = $data;
        } else {
            $final_message[$the_tag] = $data;
        }
    }

    return response()->json($final_message, $status_code);

}

function getMessageText($status_code) {

    $message_text = "";

    // get error text
    $message_text_200 = config('constants.message_text.200');
    $message_text_201 = config('constants.message_text.201');
    $message_text_401 = config('constants.message_text.401');
    $message_text_403 = config('constants.message_text.403');
    $message_text_404 = config('constants.message_text.404');
    $message_text_422 = config('constants.message_text.422');
    $message_text_500 = config('constants.message_text.500');

    switch ($status_code) {

        case 200:
            $message_text = $message_text_200;
            break;
        case 201:
            $message_text = $message_text_201;
            break;
        case 401:
            $message_text = $message_text_401;
            break;
        case 403:
            $message_text = $message_text_403;
            break;
        case 404:
            $message_text = $message_text_404;
            break;
        case 422:
            $message_text = $message_text_422;
            break;
        case 500:
            $message_text = $message_text_500;
            break;
        default:
            $message_text = $message_text_422;

    }

    return $message_text;

}

function getErrorCode($status_code) {

    $error_code = "";

    // get status code
    switch ($status_code) {

        case 200:
            $error_code = 0;
            break;
        case 201:
            $error_code = 0;
            break;
        case 401:
            $error_code = 1;
            break;
        case 403:
            $error_code = 1;
            break;
        case 404:
            $error_code = 1;
            break;
        case 422:
            $error_code = 1;
            break;
        case 500:
            $error_code = 1;
            break;
        default:
            $error_code = 0;

    }

    return $error_code;

}


//format api validation errors
function formatValidationErrors($errors) {
    //loop thru validation errors
    $error_messages = [];
    $messages = $errors->toArray();
    foreach ($messages as $message){
        $error_messages[] = $message[0];
    }
	$json = json_encode($error_messages);
    return $json;
}


//save new payment deposit to account
function saveUserDepositPayment($company_user_id, $account_no, $amount, $payment_id) {

}

function check_company_user_exists($company_id, $user_id)
{

	//check if user already is already a member of company list
	$company_user_data = CompanyUser::where('user_id', $user_id)
						->where('company_id', $company_id)
						->first();

	return $company_user_data;

}

function log_this($lmsg, $logname='')
{

    $app_short_name = config('constants.settings.app_short_name');
    $app_mode = config('constants.settings.app_mode');
    //set the log file name
    if (!$logname) { $logname = $app_short_name; }

    $date = Carbon::now();
    $date = getLocalDate($date);
    $short_date = $date->format('Ymd');
    $full_date = $date->format('Y-m-d H:i:s T: ');

	//write to the log file
	if ($app_mode != "test") {
		/* $flog = sprintf("/data/log/" . $logname . "_%s.log", $short_date);
		$tlog = sprintf("\n%s%s : %s", $full_date, $_SERVER["REMOTE_ADDR"], $lmsg);
		$f    = fopen($flog, "a");
		fwrite($f, $tlog);
		fclose($f); */
	}

}

function titlecase($text){
	return ucwords(strtolower($text));
}

function getHttpStatus($url) {
	$http = curl_init($url);
	// do your curl thing here
	$result = curl_exec($http);
	$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
	curl_close($http);
	return $http_status;
}

function removeSpecialChars($data) {
    //$remove_spaces_regex = "/\s+/";
    $remove_spaces_regex = "/[^A-Za-z0-9\-]/";
    //remove all spaces
    return preg_replace($remove_spaces_regex, '', $data->sms_user_name);
}

/**
* change plain number to formatted currency
*/

//generate user account number
function generate_account_number($company_id='622', $branch_id='01', $user_id, $account_type) {

    $company_id = $company_id ? $company_id : getDefaultCompanyId();
	$company_cd = sprintf('%03d', $company_id);

    $branch_cd = $branch_id ? $branch_id : getDefaultBranchCd();
	$branch_cd = sprintf('%02d', $branch_cd);

    //get account type to use in account number formulation
    $account_type_cd = $account_type ? $account_type : getDefaultAccountTypeCd();
    $account_type_cd = sprintf('%02d', $account_type_cd);

    $user_account_number = sprintf('%06d', $user_id);

    //formulate account number
    $account_number = $company_cd . $branch_cd . $user_account_number . $account_type_cd;

    return $account_number;

}

//get loan interest
function get_loan_interest() {

	$interest_amount = 3000;

	return $interest_amount;;

}

//Behaviour: 50 outputs 50, 52 outputs 60, 50.25 outputs 60
function roundUpToAny($n,$x=10) {
	$result = (ceil($n)%$x === 0) ? ceil($n) : round(($n+$x/2)/$x)*$x;
	//check if total of parts will surpass total amt
	/*
	if (($result * $x) > $n) {
		//total is higher, reset calculations
		$x = 1;
		$result = (ceil($n)%$x === 0) ? ceil($n) : round(($n+$x/2)/$x)*$x;
	}
	*/
	return $result;
}

//check if user has active loan in company
function getUserIncompletedLoan($company_user_id, $company_id) {

	$status_open = config('constants.status.open');
	$status_unpaid = config('constants.status.unpaid');

	$user_loan_data = LoanAccount::where('company_user_id', $company_user_id)
								->where('company_id', $company_id)
								->where(function($q) use ($status_open, $status_unpaid){
									$q->where('status_id', '=', $status_open);
									$q->orWhere('status_id', '=', $status_unpaid);
								})
								->first();
	return $user_loan_data;

}

//get repayment amounts array
function get_repayment_amounts($amount, $period) {

	$repayment_amounts = array();
	$total_so_far = 0;
	$last_amount_set = false;
	//round off to the next multiple of 10
	$indiv_amount = roundUpToAny($amount / $period);

	//if we still higher, use multiple of 5
	if ($indiv_amount > $amount) {
		//recalculate
		$indiv_amount = roundUpToAny($amount, 5);
	}

	//if we still higher, use multiple of 1
	if ($indiv_amount > $amount) {
		//recalculate
		$indiv_amount = roundUpToAny($amount, 1);
	}

	for ($i=0; $i<$period; $i++) {

		if (($i < ($period)) && (!$last_amount_set)) {

			$new_total = $total_so_far + $indiv_amount;

			//we are not on the last item
			//check that we are not above total
			if ($new_total < $amount) {
				//add next amount
				$repayment_amounts[$i] = $indiv_amount;
				$total_so_far += $indiv_amount;
			}

			//check if we are hitting last item
			if ($new_total >= $amount) {
				//add last amount
				$last_amount_set = true;
				$last_amount = $amount - $total_so_far;

				if ($last_amount > 0) {
					$repayment_amounts[$i] = $last_amount;
					$total_so_far += $last_amount;
				}
				//break;
			}

			//dump($new_total, $repayment_amounts);

		}

	}

	return json_encode($repayment_amounts);

}

//get transfer account data
function getTransferAccountData($request, $company_ids_array, $account_type) {

	//DB::enableQueryLog();

	//account type texts
	$deposit_account_text = config('constants.account_type_text.deposit_account');
	$loan_account_text = config('constants.account_type_text.loan_account');
	$shares_account_text = config('constants.account_type_text.shares_account');

	//deposit accounts
	if ($account_type == $deposit_account_text) {

		$source_account_search = $request->source_account_search;
		$source_account_search_values = getSplitTerms($source_account_search);
		$source_accounts = new DepositAccountSummary();
		$source_accounts = $source_accounts->join('deposit_accounts', 'deposit_account_summary.account_no', '=', 'deposit_accounts.account_no');
		$source_accounts = $source_accounts->whereIn("deposit_account_summary.company_id", $company_ids_array);
		if ($source_account_search) {
			$source_accounts = $source_accounts->where(function ($q) use ($source_account_search, $source_account_search_values) {
														 $q->orWhere('deposit_account_summary.account_no', "LIKE", '%' . $source_account_search . '%')
														 ->orWhere('deposit_account_summary.phone', "LIKE", '%' . $source_account_search . '%')
														 ->orWhere(function ($q2) use ($source_account_search_values) {
																foreach ($source_account_search_values as $value) {
																	$q2->orWhere('deposit_accounts.account_name', 'LIKE', "%{$value}%");
																}
															});
														});
		}
		/* if ($source_account_search) {
			$source_accounts = $source_accounts->where('deposit_account_summary.account_no', "LIKE", '%' . $source_account_search . '%')
					->orWhere('deposit_account_summary.phone', "LIKE", '%' . $source_account_search . '%')
					->orWhere(function ($q) use ($source_account_search_values) {
					foreach ($source_account_search_values as $value) {
						$q->orWhere('deposit_accounts.account_name', 'LIKE', "%{$value}%");
					}
					});
		} */
		$source_accounts = $source_accounts->orderBy('deposit_accounts.account_name');
		$source_accounts = $source_accounts->select('deposit_account_summary.id as id', 'deposit_account_summary.ledger_balance as amount',
													'deposit_accounts.account_name', 'deposit_account_summary.phone', 'deposit_account_summary.account_no',
													'deposit_account_summary.company_id', 'deposit_account_summary.company_user_id')
						->get();

		$response = $source_accounts;

	}

	//shares account
	if ($account_type == $shares_account_text) {

		$destination_account_search = $request->destination_account_search;
		$destination_account_search_values = getSplitTerms($destination_account_search);
		$destination_accounts = new DepositAccountSummary();
		$destination_accounts = $destination_accounts->join('deposit_accounts', 'deposit_account_summary.account_no', '=', 'deposit_accounts.account_no');
		$destination_accounts = $destination_accounts->whereIn("deposit_account_summary.company_id", $company_ids_array);
		if ($destination_account_search) {
			$destination_accounts = $destination_accounts->where(function ($q) use ($destination_account_search, $destination_account_search_values) {
														 $q->orWhere('deposit_account_summary.account_no', "LIKE", '%' . $destination_account_search . '%')
														 ->orWhere('deposit_account_summary.phone', "LIKE", '%' . $destination_account_search . '%')
														 ->orWhere(function ($q2) use ($destination_account_search_values) {
																foreach ($destination_account_search_values as $value) {
																	$q2->orWhere('deposit_accounts.account_name', 'LIKE', "%{$value}%");
																}
															});
														});
		}

		/* if ($destination_account_search) {
			$destination_accounts = $destination_accounts->where('deposit_account_summary.account_no', "LIKE", '%' . $destination_account_search . '%')
					->orWhere('deposit_account_summary.phone', "LIKE", '%' . $destination_account_search . '%')
					->orWhere(function ($q) use ($destination_account_search_values) {
					foreach ($destination_account_search_values as $value) {
						$q->orWhere('deposit_accounts.account_name', 'LIKE', "%{$value}%");
					}
					});
		} */
		$destination_accounts = $destination_accounts->orderBy('deposit_accounts.account_name');
		$destination_accounts = $destination_accounts->select('deposit_account_summary.id as id', 'deposit_account_summary.ledger_balance as amount',
													'deposit_accounts.account_name', 'deposit_account_summary.phone', 'deposit_account_summary.account_no',
													'deposit_account_summary.company_id', 'deposit_account_summary.company_user_id')
						->get();

		$response = $destination_accounts;

	}

	//loan account
	if ($account_type == $loan_account_text) {

		$status_open = config('constants.status.open');

		$destination_account_search = $request->destination_account_search;
		$destination_account_search_values = getSplitTerms($destination_account_search);
		$destination_accounts = new LoanAccount();
		$destination_accounts = $destination_accounts->join('users', 'users.id', '=', 'loan_accounts.user_id');
		$destination_accounts = $destination_accounts->where('loan_bal_calc', ">", '0');
		$destination_accounts = $destination_accounts->where('loan_accounts.status_id', $status_open);
		if ($destination_account_search) {
			$destination_accounts = $destination_accounts->where(function ($q) use ($destination_account_search, $destination_account_search_values) {
														 $q->orWhere('account_no', "LIKE", '%' . $destination_account_search . '%')
														 ->orWhere('users.phone', "LIKE", '%' . $destination_account_search . '%')
														 ->orWhere(function ($q2) use ($destination_account_search_values) {
																foreach ($destination_account_search_values as $value) {
																	$q2->orWhere('account_name', 'LIKE', "%{$value}%");
																}
															});
														});
		}
		/* if ($destination_account_search) {
			$destination_accounts = $destination_accounts->where('account_no', "LIKE", '%' . $destination_account_search . '%')
					->orWhere('users.phone', "LIKE", '%' . $destination_account_search . '%')
					->orWhere(function ($q) use ($destination_account_search_values) {
					foreach ($destination_account_search_values as $value) {
						$q->orWhere('account_name', 'LIKE', "%{$value}%");
					}
					});
		} */
		$destination_accounts = $destination_accounts->orderBy('account_name');
		$destination_accounts = $destination_accounts->select('loan_accounts.id as id', 'loan_bal_calc as amount', 'account_name',
																'users.phone as phone', 'loan_accounts.company_id as company_id',
																'loan_accounts.account_no', 'loan_accounts.company_user_id')
						->get();

		$response = $destination_accounts;

	}
	//dd(DB::getQueryLog());

	return $response;

}

//get transfer summary data
function getTransferSummaryData($request) {

	//account type texts
	$deposit_account_text = config('constants.account_type_text.deposit_account');
	$loan_account_text = config('constants.account_type_text.loan_account');
	$shares_account_text = config('constants.account_type_text.shares_account');

    $response = [];


    /////////////////////////////////////////
    // site settings
    $site_settings = getSiteSettings();
    $settings_company_id = $site_settings['company_id'];

    // get destination account
    try {

        $destination_account_data = getDestinationAccountData($destination_account_type, $destination_account_no);

    } catch(\Exception $e) {

        $error_message = $e->getMessage();
        log_this($error_message);
        throw new \exception($error_message);

    }
    dd("HEret == destination_account_data == ", $destination_account_type, $destination_account_no, $destination_account_data);
    /////////////////////////////////////////

	//get logged in user companies
	$company_ids_array = getUserCompanyIds($request);

	//start get source data
	if ($request->source_text == $deposit_account_text) {
		//get deposit account data
		$source_account = new DepositAccountSummary();
		$source_account = $source_account->join('deposit_accounts', 'deposit_account_summary.account_no', '=', 'deposit_accounts.account_no');
		$source_account = $source_account->where('deposit_account_summary.id', $request->source_account);
		$source_account = $source_account->whereIn('deposit_account_summary.company_id', $company_ids_array);
		$source_account = $source_account->select('deposit_account_summary.id as id',
							   'deposit_account_summary.ledger_balance as amount', 'deposit_accounts.account_name',
							   'deposit_account_summary.phone', 'deposit_account_summary.company_id',
							   'deposit_account_summary.company_user_id', 'deposit_account_summary.user_id',
							   'deposit_account_summary.account_no')
							   ->first();
	}
	//end get source data

	//start get destination data
	if ($request->destination_text == $deposit_account_text) {
		$destination_account = new DepositAccountSummary();
		$destination_account = $destination_account->join('deposit_accounts', 'deposit_account_summary.account_no', '=', 'deposit_accounts.account_no');
		$destination_account = $destination_account->where('deposit_account_summary.id', $request->destination_account);
		$destination_account = $destination_account->whereIn('deposit_account_summary.company_id', $company_ids_array);
		$destination_account = $destination_account->select('deposit_account_summary.id as id',
							   'deposit_account_summary.ledger_balance as amount', 'deposit_accounts.account_name',
							   'deposit_account_summary.phone', 'deposit_account_summary.company_id',
							   'deposit_account_summary.company_user_id', 'deposit_account_summary.user_id',
							   'deposit_account_summary.account_no')
							   ->first();
	}

	if ($request->destination_text == $shares_account_text) {
		$destination_account = new DepositAccountSummary();
		$destination_account = $destination_account->join('deposit_accounts', 'deposit_account_summary.account_no', '=', 'deposit_accounts.account_no');
		$destination_account = $destination_account->where('deposit_account_summary.id', $request->destination_account);
		$destination_account = $destination_account->whereIn('deposit_account_summary.company_id', $company_ids_array);
		$destination_account = $destination_account->select('deposit_account_summary.id as id',
							   'deposit_account_summary.ledger_balance as amount', 'deposit_accounts.account_name',
							   'deposit_account_summary.phone', 'deposit_account_summary.company_id',
							   'deposit_account_summary.company_user_id', 'deposit_account_summary.user_id',
							   'deposit_account_summary.account_no')
							   ->first();
	}

	if ($request->destination_text == $loan_account_text) {
		$destination_account = new LoanAccount();
		$destination_account = $destination_account->join('users', 'users.id', '=', 'loan_accounts.user_id');
		$destination_account = $destination_account->where('loan_accounts.id', $request->destination_account);
		$destination_account = $destination_account->whereIn('loan_accounts.company_id', $company_ids_array);
		$destination_account = $destination_account->select('loan_accounts.id as id', 'loan_bal_calc as amount',
							   'account_name', 'users.phone as phone', 'loan_accounts.company_id as company_id',
							   'loan_accounts.company_user_id', 'users.id as user_id', 'loan_accounts.account_no')
							   ->first();
							   //dd($request, $destination_account);
	}
	//end get destination data

	//show results
	$response['source_account'] = $source_account;
	$response['destination_account'] = $destination_account;
	$response['source_text'] = $request->source_text;
    $response['destination_text'] = $request->destination_text;
	$response['source_title'] = $request->source_title;
    $response['destination_title'] = $request->destination_title;

	return json_encode($response);

}

//get account name text
function getAccountNameText($account_type_text) {

	//account type texts
	$account_name_text = "";

	if ($account_type_text == getAccountTypeWalletAccount()){
		$account_name_text = getAccountTypeTextWalletAccount();
	}

	if ($account_type_text == getAccountTypeTransactionAccount()){
		$account_name_text = getAccountTypeTextTransactionAccount();
	}

	return $account_name_text;

}

//get gl account cd
function get_gl_account_cd($account_type_id) {

	$gl_account_cd_data = DB::table('gl_account_types')
            ->select('gl_account_cd')
            ->where('id', $account_type_id)
			->first();

	return $gl_account_cd_data->gl_account_cd;

}

//get gl account no
function get_gl_account_number($account_type_id, $company_id) {

	$gl_account_data = DB::table('gl_accounts')
            ->select('gl_account_no')
            ->where('gl_account_type_id', $account_type_id)
            ->where('company_id', $company_id)
			->first();

	return $gl_account_data->gl_account_no;

}

//get next gl account sequence
function get_next_gl_account_sequence() {

	$gl_account_sequence = DB::table('gl_accounts')
			->max('gl_account_sequence');

	$next_gl_account_sequence = $gl_account_sequence + 1;

	return $next_gl_account_sequence;

}




//generate gl account number
function generate_gl_account_number($company_id, $branch_id, $gl_account_cd, $next_gl_account_sequence) {

	//format - company_id(3), branch(2), account_number(6), gl_account_type(3)
	//example - 055-0001-01-012 (without hyphens)
	//get next gl account no using sequence
	//DB::enableQueryLog();

	//format number to four digits
	$next_gl_account_number = sprintf('%06d', $next_gl_account_sequence);

	//company id
	$company_id = sprintf('%03d', $company_id);

	//company id
	$branch_id = sprintf('%02d', $branch_id);

	//company id
	$gl_account_cd = sprintf('%03d', $gl_account_cd);

	//formulate gl account number
	$gl_account_number = $company_id . $branch_id . $next_gl_account_number . $gl_account_cd;

    return $gl_account_number;

}


function enableUserAccount($company_id, $company_user_id, $product_id) {

	$status_active = config('constants.status.active');

	try {

		$account_update = Account::where('company_user_id', $company_user_id)
										->where('company_id', $company_id)
										->where('product_id', $product_id)
								->update([
											'status_id' => $status_active
										]);

		return $account_update;

	} catch(\Exception $e) {

		DB::rollback();
		//dd($e);
		$message = 'Error. Could not update company user';
		throw new \Exception($message);

	}

}


function saveToRegistrationAccount($payment_id, $company_id, $company_user_id, $amount) {


	//get company data
	$company_data = Company::find($company_id);
	$company_name = $company_data->name;

	//get the company's registration account
    $reg_account_product_id = config('constants.account_settings.registration_account_product_id');
    //dd($company_id, $company_user_id, $amount, $reg_account_product_id);
    $registration_account_data = Account::where('company_id', $company_id)
                                ->where('product_id', $reg_account_product_id)
								->first();
	if (!$registration_account_data) {
		//throw an error, company reg account does not exist
		throw new \Exception("Registration account for $company_name does not exist!");
	}
    $registration_account_id = $registration_account_data->id;
	$registration_account_no = $registration_account_data->account_no;

	//get the company registration deposit account no
	$registration_deposit_account_data = DepositAccount::where('ref_account_no', $registration_account_no)
								->first();
	if (!$registration_deposit_account_data) {
		//throw an error, company reg account does not exist
		throw new \Exception("Registration deposit account for $company_name does not exist!");
	}
	$registration_deposit_account_no = $registration_deposit_account_data->account_no;
	$registration_deposit_account_name = $registration_deposit_account_data->account_name;
	//dd($registration_deposit_account_no);

    //save new reg deposit
    $attributes['amount'] = $amount;
    $attributes['account_no'] = $registration_deposit_account_no;
	$attributes['account_name'] = $registration_deposit_account_name;
	$attributes['company_id'] = $company_id;
	$attributes['company_user_id'] = $company_user_id;
	$attributes['company_name'] = $company_name;
	$attributes['payment_id'] = $payment_id;

    //store as a deposit
    $deposit_store = new DepositStore();

    $new_deposit = $deposit_store->createItem($attributes);

    return $new_deposit;

}


/*check whether reminder message is active*/
function isReminderMessageActive($reminder_cycle, $reminder_period, $reminder_type,
								 $reminder_type_section_id, $parent_id="", $reminder_message_days_send_to_expiry_value="") {

    //log_this("reminder_active params - $reminder_cycle, $reminder_period, $reminder_type, $reminder_type_section_id, $parent_id");

    $is_active = false;

	$current_date = getCurrentDateObj();
	$current_date_day = $current_date->startOfDay();

	$status_open = config('constants.status.open');

	$new_date = "";

	//duration
	$duration_day = config('constants.duration.day');
	$duration_week = config('constants.duration.week');
	$duration_month = config('constants.duration.month');
	$duration_year = config('constants.duration.year');

	//reminder type sections
	$overdue_loans_reminder_type_section_id = config('constants.reminder_type_sections.overdue_loans');
	$almost_expiring_loans_reminder_type_section_id = config('constants.reminder_type_sections.almost_expiring_loans');

	//products
	$mobile_loan_product_id = config('constants.account_settings.mobile_loan_product_id');
	$loan_account_product_id = config('constants.account_settings.loan_account_product_id');
	$deposit_account_product_id = config('constants.account_settings.deposit_account_product_id');
	$registration_account_product_id = config('constants.account_settings.registration_account_product_id');

	//check whether max repay period has been exhausted
	//get repayment_reminder_entry
	$latest_reminder = new ReminderMessage();

	if (($reminder_type == $mobile_loan_product_id) && ($parent_id)) {
		$latest_reminder = $latest_reminder->where("loan_account_id", $parent_id);
	}

	$latest_reminder = $latest_reminder->first();
	//dd($latest_reminder);

	if ($latest_reminder) {

		//get last reminder date
		$last_reminder_date = $latest_reminder->last_sent_at;
		$messages_count = $latest_reminder->messages_count;
		//have we sent maximum messages?
		//dd($messages_count, $reminder_period);
		if ($messages_count < $reminder_period) {

			//check reminder cycle and compare
			//check whether reminder is due
			//compare last_reminder_date to current date
			//dd($reminder_type_section_id, $overdue_loans_reminder_type_section_id, $reminder_cycle, $duration_week);
			if ($reminder_cycle == $duration_year) {
				$new_date = $last_reminder_date->addYear();
			} else if ($reminder_cycle == $duration_month) {
				$new_date = $last_reminder_date->addMonth();
			} else if ($reminder_cycle == $duration_week) {
				$new_date = $last_reminder_date->addWeek();
			} else if ($reminder_cycle == $duration_day) {
				$new_date = $last_reminder_date->addDay();
			} else {
				$new_date = $last_reminder_date->addDay();
			}

			if ($reminder_type_section_id == $overdue_loans_reminder_type_section_id) {
				if ($new_date < $current_date_day) {
					$is_active = true;
					//dd("less than today");
				}
			}

			if ($reminder_type_section_id == $almost_expiring_loans_reminder_type_section_id) {
				//get new expected expiry date
				$expected_expiry_date = $current_date_day->addDays($reminder_message_send_to_expiry_value);
				if ($expected_expiry_date = $new_date) {
					$is_active = true;
					//dd("less than today");
				}
			}

			//dump($new_date, $current_date_day);

			/* if ($new_date < $current_date_day) {

				$is_active = true;
				//dd("less than today");

			} else {

				$is_active = false;
				//dd("more than today");

			} */

		}

	} else {

		$is_active = true;

	}

    return $is_active;

}


/*send reminder message*/
function sendReminderMessage($company_user_id, $reminder_cycle, $reminder_period, $reminder_type, $send_sms,
							 $send_email, $loan_bal_fmt="", $maturity_at="", $parent_id="") {

	$company_user = CompanyUser::find($company_user_id);

	$is_active = false;

	$current_date = getCurrentDateObj();

	$status_open = config('constants.status.open');
	$status_active = config('constants.status.active');

	//reminder message categories
	$reminder_category_sms = config('constants.reminder_category.sms');
	$reminder_category_email = config('constants.reminder_category.email');

	//duration
	$duration_day = config('constants.duration.day');
	$duration_week = config('constants.duration.week');
	$duration_month = config('constants.duration.month');
	$duration_year = config('constants.duration.year');

	//products
	$mobile_loan_product_id = config('constants.account_settings.mobile_loan_product_id');
	$loan_account_product_id = config('constants.account_settings.loan_account_product_id');
	$deposit_account_product_id = config('constants.account_settings.deposit_account_product_id');
	$registration_account_product_id = config('constants.account_settings.registration_account_product_id');

	//vars
	$reminder_message = "";
	$email = "";
	$phone = "";
	$company_id = "";
	$company_name = "";
	$company_short_name = "";
	$full_names = "";
	$messages_count = 0;
	$reminder_message_id = "";
	$user_phone = "";
	$localised_phone = "";
	$new_messages_count = 0;

	//check whether max repay period has been exhausted
	//get repayment_reminder_entry
	$latest_reminder = new ReminderMessage();

	if (($reminder_type == $mobile_loan_product_id) && ($parent_id)) {
		$latest_reminder = $latest_reminder->where("loan_account_id", $parent_id);
	}

	$latest_reminder = $latest_reminder->first();

	if ($latest_reminder) {
		//get last reminder date
		$last_reminder_date = $latest_reminder->last_sent_at;
		$messages_count = $latest_reminder->messages_count;
		$new_messages_count = $messages_count + 1;
	} else {
		$new_messages_count = 1;
	}

	if ($company_user) {

		$user = $company_user->user;

		if ($user) {
			$email = $user->email;
			$phone = $user->phone;
			$phone_country = $user->phone_country;
			$company_id = $user->company_id;
			$company_name = $user->company->name;
			$company_short_name = $user->company->short_name;
			$company_user_id = $company_user->id;
			$first_name = $user->first_name;
			$full_names = $user->first_name . ' ' . $user->last_name;

			//start get main paybill no
			$mpesa_paybill_data = getMainSingleCompanyPaybill($company_id);
			$mpesa_paybill_data = json_decode($mpesa_paybill_data);
			$mpesa_paybill_data = $mpesa_paybill_data->data;
			$mpesa_paybill = $mpesa_paybill_data->paybill_number;
			//end get main paybill no

		}

	}

	///start test ***********************
	//$email = "heavybitent@gmail.com";
	//$phone = "254720743211";
	///end test ***********************

	if ($phone && $phone_country) {
		$user_phone = getDatabasePhoneNumber($phone, $phone_country);
		$localised_phone = getLocalisedPhoneNumber($phone, $phone_country);
	}

	//test ***********************************************************
	//$new_messages_count=1;

	if (($reminder_type == $mobile_loan_product_id) && ($parent_id)) {

		if ($company_user) {

			$user = $company_user->user;

			if ($user) {
				//create message
				$reminder_message = "Dear " . titlecase($full_names) . ", ";
				$reminder_message .= ordinal($new_messages_count) . " reminder:";
				$reminder_message .= " Your loan balance of $loan_bal_fmt with $company_name was overdue on $maturity_at.";
				$reminder_message .= " Please make your repayments to Paybill: $mpesa_paybill A/C: $localised_phone";
				$reminder_message .= " to qualify for more loans. Regards, $company_name";
			}

		}

	}

	//dd($latest_reminder);
	//dd($localised_phone, $user_phone, $mpesa_paybill, $email, $phone, $reminder_message);

	if ($latest_reminder) {

		$reminder_message_id = $latest_reminder->id;

		//start update existing reminder_message
		$existing_reminder_attributes['last_sent_at'] = $current_date;
		$existing_reminder_attributes['messages_count'] = $new_messages_count;

		$existing_reminder_message_result = $latest_reminder->updatedata($latest_reminder->id, $existing_reminder_attributes);
		//end update existing reminder_message

	} else {

		try {
			//save new reminder_message
			$new_reminder_message = new ReminderMessage();

			$new_reminder_attributes['company_id'] = $company_id;
			$new_reminder_attributes['reminder_message_type_id'] = $reminder_type;
			if ($user) {
				$new_reminder_attributes['user_id'] = $user->id;
			}
			if ($company_user_id) {
				$new_reminder_attributes['company_user_id'] = $company_user_id;
			}
			if ($reminder_type == $mobile_loan_product_id){
				$new_reminder_attributes['loan_account_id'] = $parent_id;
			}
			$new_reminder_attributes['last_sent_at'] = $current_date;
			$new_reminder_attributes['messages_count'] = $new_messages_count;
			$new_reminder_attributes['user_phone'] = $user_phone;
			$new_reminder_attributes['localised_phone'] = $localised_phone;

			$new_reminder_message_result = $new_reminder_message->create($new_reminder_attributes);

			//dd($new_reminder_message_result);

			$reminder_message_id = $new_reminder_message_result->id;

		} catch (\Exception $e) {
			//dd($e);
			//send error sms to admin
		}

	}

	//doees user have a phone number
	if ($phone) {

		//sms type
		$sms_type_id = config('constants.sms_types.company_sms');

		//send sms reminder
		if (($reminder_type == $mobile_loan_product_id) && ($send_sms == $status_active)){
			$result = createSmsOutbox($reminder_message, $phone, $sms_type_id, $company_id, $company_user_id);
		}

		//start create new reminder message detail
		$new_reminder_message_detail = createNewReminderMessageDetail($company_id, $reminder_message_id,
												$reminder_message, $phone, $email, $reminder_category_sms, $parent_id);
		//end create new reminder message detail

	}

	if ($email) {

		//send email reminder
		if (($reminder_type == $mobile_loan_product_id) && ($send_email == $status_active)){

			$email_reminder = ReminderMessage::find($reminder_message_id);

			$email_reminder->reminder_message = $reminder_message;
			$email_reminder->first_name = $first_name;
			$email_reminder->full_names = $full_names;
			$email_reminder->email = $email;
			$email_reminder->phone = $phone;
			$email_reminder->company_id = $company_id;
			$email_reminder->company_name = $company_name;
			$email_reminder->company_short_name = $company_short_name;
			$email_reminder->mpesa_paybill = $mpesa_paybill;
			$email_reminder->messages_count = $new_messages_count;
			$email_reminder->reminder_type = $reminder_type;

			Mail::to($email)
				->send(new ReminderMessageEmail($email_reminder));

		}

		//start create new reminder message detail
		$new_reminder_message_detail = createNewReminderMessageDetail($company_id, $reminder_message_id,
												$reminder_message, $phone, $email, $reminder_category_email, $parent_id);
		//end create new reminder message detail

	}

}

/*send email to queue*/
function sendTheEmailToQueue($email, $subject, $title, $company_name, $email_text, $email_salutation, $company_id,
							 $email_footer="", $panel_text="", $table_text="", $parent_id="", $reminder_message_id="",
							 $has_attachments="99", $event_type_id="") {

	try {

		//start send email to queue
		$emailQueueStore = new EmailQueueStore();

		//replace amount with new deposit_amount
		$email_queue_store_attributes['subject'] = $subject;
		$email_queue_store_attributes['title'] = $title;
		$email_queue_store_attributes['company_name'] = $company_name;
		$email_queue_store_attributes['email_text'] = $email_text;
		$email_queue_store_attributes['panel_text'] = $panel_text;
		$email_queue_store_attributes['table_text'] = $table_text;
		$email_queue_store_attributes['email_salutation'] = $email_salutation;
		$email_queue_store_attributes['email_footer'] = $email_footer;
		$email_queue_store_attributes['email_address'] = $email;
		$email_queue_store_attributes['parent_id'] = $parent_id;
		$email_queue_store_attributes['reminder_message_id'] = $reminder_message_id;
		$email_queue_store_attributes['company_id'] = $company_id;
		$email_queue_store_attributes['has_attachments'] = $has_attachments;
		if ($event_type_id) {
			$email_queue_store_attributes['event_type_id'] = $event_type_id;
		}

        $result = $emailQueueStore->createItem($email_queue_store_attributes);
        // dd("result == ", $result);

		return $result;
		// end send email to queue

	} catch (\Exception $e) {

		// DB::rollback();
		// dd($e);
		$show_message = "Could not send to email queue:  $email_queue_store_attributes -- ";
		log_this($show_message);
		throw new \Exception($show_message);

	}

}


/*send email to queue*/
function sendEmailToQueue($reminder_message_id, $company_user_id, $parent_id, $subject, $title, $reminder_message, $email_footer="", $panel_text="") {

	$company_user = CompanyUser::find($company_user_id);

	$current_date = getCurrentDateObj();

	$status_open = config('constants.status.open');
	$status_active = config('constants.status.active');

	//reminder message categories
	$reminder_category_sms = config('constants.reminder_category.sms');
	$reminder_category_email = config('constants.reminder_category.email');

	//duration
	$duration_day = config('constants.duration.day');
	$duration_week = config('constants.duration.week');
	$duration_month = config('constants.duration.month');
	$duration_year = config('constants.duration.year');

	//products
	$mobile_loan_product_id = config('constants.account_settings.mobile_loan_product_id');
	$loan_account_product_id = config('constants.account_settings.loan_account_product_id');
	$deposit_account_product_id = config('constants.account_settings.deposit_account_product_id');
	$registration_account_product_id = config('constants.account_settings.registration_account_product_id');

	//vars
	$reminder_message = "";
	$email = "";
	$phone = "";
	$company_id = "";
	$company_name = "";
	$company_short_name = "";
	$full_names = "";
	$messages_count = 0;
	$reminder_message_id = "";
	$user_phone = "";
	$localised_phone = "";
	$new_messages_count = 0;


	if ($company_user) {

		$user = $company_user->user;

		if ($user) {
			$email = $user->email;
			$phone = $user->phone;
			$phone_country = $user->phone_country;
			$company_id = $user->company_id;
			$company_name = $user->company->name;
			$company_short_name = $user->company->short_name;
			$company_user_id = $company_user->id;
			$first_name = $user->first_name;
			$full_names = $user->first_name . ' ' . $user->last_name;

			//start get main paybill no
			$mpesa_paybill_data = getMainSingleCompanyPaybill($company_id);
			$mpesa_paybill_data = json_decode($mpesa_paybill_data);
			$mpesa_paybill_data = $mpesa_paybill_data->data;
			$mpesa_paybill = $mpesa_paybill_data->paybill_number;
			//end get main paybill no

		}

	}

	///start test ***********************
	$email = "heavybitent@gmail.com";
	$phone = "254720743211";
	///end test ***********************

	if ($phone && $phone_country) {
		$user_phone = getDatabasePhoneNumber($phone, $phone_country);
		$localised_phone = getLocalisedPhoneNumber($phone, $phone_country);
	}


}


// delete existing images
function deleteCurrentImages($current_image_data) {

	//if current images exist, delete them
	if (count($current_image_data)){

		$current_image_main_data = $current_image_data[0];

		$current_thumb = $current_image_main_data->thumb_img;
		$current_thumb_400 = $current_image_main_data->thumb_img_400;
		$current_full_img = $current_image_main_data->full_img;

		// dd(Storage::disk("public")->delete($current_thumb));

		//start if current images exists, delete
		if ($current_thumb) {

			deleteImage($current_thumb);

		}

		if ($current_thumb_400) {

			// get current thumb400 file path
			// if file exists, delete it
			deleteImage($current_thumb_400);

		}

		if ($current_full_img) {

			// get current full img file path
			// if file exists, delete it
            deleteImage($current_full_img);



		}
		//end if current images exists, delete

	}

}

// delete image
function deleteImage($path)
{

  if(\File::exists(public_path($path))){

    \File::delete(public_path($path));

  }

}


//upload images
function storeItemImage($request, $base_path, $thumb_status, $thumb_400_status, $large_status) {

	$image_array = [];

	if ($request->hasFile('item_image')) {

		//get filename without extension
		$filenameWithExt = $request->file('item_image')->getClientOriginalName();

		//get filename only
		$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

		//format filename
		$filename = str_replace('-', '_', getStrSlug($filename));

		//get file extension
		$extension = $request->file('item_image')->getClientOriginalExtension();

		//filename to store
        $filenameToStore = $filename . '_' . time() . '.' . $extension;

		//upload image
		//get path
		if ($base_path) {
			$image_storage_path = "public/images/" . $base_path;
			$thumb_storage_path = "public/images/" . $base_path . "/thumbs";
			$thumb_400_storage_path = "public/images/" . $base_path . "/thumbs400";
			$server_image_storage_path = "public/images/" . $base_path . "/";
			$server_thumb_storage_path = "public/images/" . $base_path . "/thumbs/";
			$server_thumb_400_storage_path = "public/images/" . $base_path . "/thumbs400/";
			$public_image_storage_path = "images/" . $base_path . "/";
			$public_thumb_storage_path = "images/" . $base_path . "/thumbs/";
			$public_thumb_400_storage_path = "images/" . $base_path . "/thumbs400/";
		} else {
			$image_storage_path = "public/images";
			$thumb_storage_path = "public/images/thumbs";
			$thumb_400_storage_path = "public/images/thumbs400";
			$server_image_storage_path = "public/images/";
			$server_thumb_storage_path = "public/images/thumbs/";
			$server_thumb_400_storage_path = "public/images/thumbs400/";
			$public_image_storage_path = "images/";
			$public_thumb_storage_path = "images/thumbs/";
			$public_thumb_400_storage_path = "images/thumbs400/";
		}

		//get site settings
		$site_settings = app('site_settings');

		$thumb_width_setting = $site_settings['image_thumbnail_width'];
		$thumb_height_setting = $site_settings['image_thumbnail_height'];
		$image_width_setting = $site_settings['image_width'];
		$image_height_setting = $site_settings['image_height'];

		//set values
		$thumb_width = ($thumb_width_setting) ? $thumb_width_setting : 100;
		$thumb_height = ($thumb_height_setting) ? $thumb_height_setting : 100;
		$image_width = ($image_width_setting) ? $image_width_setting : 650;
		$image_height = ($image_height_setting) ? $image_height_setting : 400;
		$thumb_400_width = 400;
		$thumb_400_height = 400;

		$image_real_path = $request->file('item_image')->getRealPath();
		// dd($image_real_path);

		if ($large_status == 1) {

			// get the storage path
			$server_image_storage_path = base_path($server_image_storage_path);

			// create dir if it doesnt exist
            createDirIfNotExists($server_image_storage_path);

            // resize image
			$imagepath = $server_image_storage_path . $filenameToStore;
			$img = IntImage::make($image_real_path)->fit($image_width, $image_height, function($constraint) {
				$constraint->upsize();
			});
			$img->save($imagepath);
			// get image path
			$public_largeimg = $public_image_storage_path . $filenameToStore;
			$image_array['full_img'] = $public_largeimg;
		}

		if ($thumb_400_status == 1) {

			// get the storage path
			$server_thumb_400_storage_path = base_path($server_thumb_400_storage_path);

			// resize thumb400
			createDirIfNotExists($server_thumb_400_storage_path);
			// dump($server_thumb_400_storage_path . $filenameToStore);
			$thumbnail400path = $server_thumb_400_storage_path . $filenameToStore;
			//dd($thumbnail400path);
			$thumb400img = IntImage::make($image_real_path)->fit($thumb_400_width, $thumb_400_height, function($constraint) {
				$constraint->upsize();
			});
			//$img = Image::make($request->file('item_image')->getRealPath());
			$thumb400img->save($thumbnail400path);
			//get image path
			$public_thumb400img = $public_thumb_400_storage_path . $filenameToStore;
			$image_array['thumb_img_400'] = $public_thumb400img;
		}

		if ($thumb_status == 1) {

			// get the storage path
			$server_thumb_storage_path = base_path($server_thumb_storage_path);

			//resize thumb
			// dump($server_thumb_storage_path . $filenameToStore);
			createDirIfNotExists($server_thumb_storage_path);
			$thumbnailpath = $server_thumb_storage_path . $filenameToStore;
			$thumbimg = IntImage::make($image_real_path)->fit($thumb_width, $thumb_height, function($constraint) {
				$constraint->upsize();
			});
			$thumbimg->save($thumbnailpath);
			//get image path
			$public_thumbimg = $public_thumb_storage_path . $filenameToStore;
			$image_array['thumb_img'] = $public_thumbimg;
		}

	}
	// dd('hapaa');

	return json_encode($image_array);

}

function getStrSlug($text) {
    return Str::slug($text);
}

//start save image
function saveItemImage($parent_object, $caption, $image_section, $full_img, $thumb_img, $thumb_img_400) {

	//start store image
	$image = new Image(
		[
			'caption' => $caption,
			'imagetable_type' => $image_section,
			'imagetable_id' => $parent_object->id,
			'full_img' => $full_img,
			'thumb_img' => $thumb_img,
			'thumb_img_400' => $thumb_img_400
		]);

	$result = $parent_object->images()->save($image);

	return $result;

}
//end save image

//start update image
function updateItemImage($id, $caption, $image_section, $full_img, $thumb_img, $thumb_img_400) {

    // dd($id, $caption, $image_section, $full_img, $thumb_img, $thumb_img_400);
	// start edit image
	$result = Image::where('imagetable_id', $id)
					->where('imagetable_type', $image_section)
                    ->update([
                        'caption' => $caption,
                        'imagetable_type' => $image_section,
                        'full_img' => $full_img,
                        'thumb_img' => $thumb_img,
                        'thumb_img_400' => $thumb_img_400,
                    ]);

	return $result;

}
//end update image

//start create dir
function createDirIfNotExists($dir, $permission="0777") {

	if (!file_exists($dir)) {
		mkdir($dir, $permission, true);
	}

	//Storage::disk('local')->makeDirectory($dir);

}
//end create dir

//get ordinal number e.g. 1st, 2nd, 3rd, etc...
function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

/* create New Reminder Message Detail */
function createNewReminderMessageDetail($company_id, $reminder_message_id,
                                        $reminder_message, $phone, $email,
                                        $reminder_category, $parent_id){

	try {

		$new_reminder_message_detail = new ReminderMessageDetail();

		$new_reminder_message_detail_attributes['company_id'] = $company_id;
		$new_reminder_message_detail_attributes['reminder_message_id'] = $reminder_message_id;
		$new_reminder_message_detail_attributes['message'] = $reminder_message;
		$new_reminder_message_detail_attributes['phone'] = $phone;
		$new_reminder_message_detail_attributes['email'] = $email;
		$new_reminder_message_detail_attributes['reminder_message_category_id'] = $reminder_category;
		$new_reminder_message_detail_attributes['loan_account_id'] = $parent_id;

		$new_reminder_message_detail_result = $new_reminder_message_detail->create($new_reminder_message_detail_attributes);

		return $new_reminder_message_detail_result;

	} catch (\Exception $e) {

		//DB::rollback();
		$show_message = "Could not create new reminder message detail:  $new_reminder_message_detail_attributes -- ";
		log_this($show_message . "<br>  new_reminder_message_detail_attributes -" . $new_reminder_message_detail_attributes);
		throw new \Exception($show_message);

	}

}

// is the user sending a request to himself/ herself?
function getSentFieldName($partner_details_select) {

    if ($partner_details_select == 'phone') {
        return "Phone No";
    } else if ($partner_details_select == 'id_no') {
        return "National ID No";
    } else if ($partner_details_select == 'email') {
        return "Email Address";
    }

    return "";

}

// is the user sending a request to himself/ herself?
function isLoggedUserDetails($partner_details_select, $transaction_partner_details) {

    $logged_user_data = getLoggedUser();
    $logged_user_phone = $logged_user_data->phone;
    $logged_user_email = $logged_user_data->email;
    $logged_user_id_no = $logged_user_data->id_no;

    if ($partner_details_select == 'phone') {
        // check if supplied phone is the same as logged user phone
        if ($logged_user_phone == getDatabasePhoneNumber($transaction_partner_details)){
            return true;
        }
    } else if ($partner_details_select == 'id_no') {
        // check if supplied id_no is the same as logged user id_no
        if ($logged_user_id_no == $transaction_partner_details){
            return true;
        }
    } else if ($partner_details_select == 'email') {
        // check if supplied email is the same as logged user email
        if ($logged_user_email == $transaction_partner_details){
            return true;
        }
    }

    return false;

}

/* getgetTransUserData($partner_details_select, $transaction_partner_details) */
function getTransUserData($partner_details_select, $transaction_partner_details) {

    $user_data = new User();

    if ($partner_details_select == 'phone') {
        $user_data = $user_data->where('phone', getDatabasePhoneNumber($transaction_partner_details));
    } else if ($partner_details_select == 'id_no') {
        $user_data = $user_data->where('id_no', $transaction_partner_details);
    } else if ($partner_details_select == 'email') {
        // check email validity
        if (!isValidEmail($transaction_partner_details)) {
            throw new \Exception("Invalid email address: $transaction_partner_details");
        }
        $user_data = $user_data->where('email', $transaction_partner_details);
    }

    // dont get logged user data
    $user_data = $user_data->where('id', '!=', getLoggedUser()->id)->first();

    return $user_data;

}


/*generate user account number*/
function generate_user_cd() {

	//get the highest account number and add 1 to it
	$users_data = DB::table('company_user')
                     ->select(DB::raw('max(user_cd) as user_cd'))
                     ->first();
    $max_user_cd = $users_data->user_cd;

    if ($max_user_cd) {
	    //add +1 to get new account number sequence
	    $next_user_cd = $max_user_cd + 1;
	} else {
	    //add +1 to get new account number sequence
	    $next_user_cd = 1;
	}

    return $next_user_cd;

}

/*
* @param $number
* @param $currency
*/
function formatCurrency($number, $decimals = 2, $currency = 'Ksh')
{
    return $currency . " " . format_num($number, $decimals);
}

//format number
function format_num($num, $decimals=2, $thousand_sep=",") {
	if (checkCharExists(',', $num)) {
		return $num;
	}
	return number_format($num, $decimals, '.', $thousand_sep);
}

function checkCharExists($char, $value) {
	if (strpos($value, $char) !== false) {
	  return true;
	}
	return false;
}

function executeCurl($url, $method=NULL, $data_string = NULL)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type:application/json',
        'Authorization:Bearer ACCESS_TOKEN'
    )); //setting custom header
    //log_this(">>>>>>>>> CURL RESPONSE :\n\n$data_string");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    if ($method == 'post') {
        curl_setopt($curl, CURLOPT_POST, true);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
	}

    return curl_exec($curl);

}

//format to local phone number
function getLocalisedPhoneNumber($phone_number, $country_code='KE') {
	$phone_number = PhoneNumber::make($phone_number, $country_code)->formatNational();
	//remove spaces
	return str_replace(" ", "", $phone_number);

}

//format to international phone number with spaces in between
function getInternationalPhoneNumber($phone_number, $country_code='KE') {
	return PhoneNumber::make($phone_number, $country_code)->formatInternational();
}

//format to international phone number with no spaces in between
function getInternationalPhoneNumberNoSpaces($phone_number, $country_code='KE') {
	return PhoneNumber::make($phone_number, $country_code)->formatE164();
}

//format to db format, remove plus (+) sign
function getDatabasePhoneNumber2($phone_number, $country_code='KE') {
	/* try {
		$phone_number = PhoneNumber::make($phone_number, $country_code)->formatE164();
		return str_replace("+", "", $phone_number);
	} catch (\Exception $e) {
		$message = "Error occured on phone - " . $phone_number;
		throw new Exception($message);
	} */

	if (isValidPhoneNumber($phone_number)){
		$phone_number = formatPhoneNumber($phone_number);
	} else {
		$message = "Error occured on phone - " . $phone_number;
		throw new Exception($message);
	}

	return $phone_number;

}

function getDatabasePhoneNumber($phone_number, $country_code='KE') {
    try {
        $phone_number = PhoneNumber::make($phone_number, $country_code)->formatE164();
        return str_replace("+", "", $phone_number);
    } catch(\Exception $e) {
        $message = "Invalid phone number: $phone_number";
        throw new \Exception($message);
    }
}

//format for dialling in country
function getForMobileDialingPhoneNumber($phone_number, $country_code='KE', $dialling_country_code='KE') {
	return PhoneNumber::make($phone_number, $country_code)->formatForMobileDialingInCountry($dialling_country_code);
}

//format phone number
function formatPhoneNumber($phone_number) {
	return   "254". substr(trim($phone_number),-9);
}

//check for valid phone number
function isValidPhoneNumber($phone_number) {

	$phone_number_status = false;

	$phone_number = trim($phone_number);

	if (strlen($phone_number) == 12)
	{
		$pattern = "/^2547(\d{8})$/";
		if (preg_match($pattern, $phone_number)) {
			$phone_number_status = true;
		}
	}

	if (strlen($phone_number) == 13)
	{
		$pattern = "/^\+2547(\d{8})$/";
		if (preg_match($pattern, $phone_number)) {
			$phone_number_status = true;
		}
	}

	if (strlen($phone_number) == 10)
	{
		$pattern = "/^07(\d{8})$/";
		if (preg_match($pattern, $phone_number)) {
			$phone_number_status = true;
		}
	}

	if (strlen($phone_number) == 9)
	{
		$pattern = "/^7(\d{8})$/";
		if (preg_match($pattern, $phone_number)) {
			$phone_number_status = true;
		}
	}

    return  $phone_number_status;

}

//validate an email address
function validateEmail($email) {

	return preg_match("/^(((([^]<>()[\.,;:@\" ]|(\\\[\\x00-\\x7F]))\\.?)+)|(\"((\\\[\\x00-\\x7F])|[^\\x0D\\x0A\"\\\])+\"))@((([[:alnum:]]([[:alnum:]]|-)*[[:alnum:]]))(\\.([[:alnum:]]([[:alnum:]]|-)*[[:alnum:]]))*|(#[[:digit:]]+)|(\\[([[:digit:]]{1,3}(\\.[[:digit:]]{1,3}){3})]))$/", $email);

}

//validate email
function isValidEmail($email){
    // Check the formatting is correct
    if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        return FALSE;
    }

    return true;

    // Next check the domain is real.
    /* $domain = explode("@", $email, 2);
    return checkdnsrr($domain[1]); */
    // returns TRUE/FALSE;
}

//format excel floating point number
function formatExcelFloat($num) {
    return (float) $num;
}

//format date
function formatFriendlyDate($date, $format='d-M-Y, H:i') {
    if ($date) {
        return Carbon::parse($date)->format($format);
    } else {
        return null;
    }
}

//format display date
function formatDisplayDate($date) {
    if ($date) {
        return Carbon::parse($date)->format('d-M-Y');
    } else {
        return null;
    }
}

//format excel date
function formatExcelDate($date) {
    if ($date) {
        return Carbon::parse($date)->format('m-d-Y');
    } else {
        return null;
    }
}

//format datepicker date
function formatDatePickerDate($date, $format='d-m-Y H:i') {
	if ($date) {
        return Carbon::parse($date)->format($format);
    } else {
        return null;
    }
}

//format utc date
function formatUTCDate($date, $date_format='Y-m-d H:i:s') {

    $timezone = getLocalTimezone();
    $tzdate = Carbon::createFromFormat($date_format, $date, $timezone);

    return $tzdate->timezone('UTC');

}

//convert alphabet to num, e.g. A=1, B=2, Z=25, AA=26, ETC
function letterToNum($number) {
    $alphabet = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
	return $alphabet[$number];
}

//get url to be cached
function getFullCacheUrl($url, $params) {

        //Sorting query params by key (acts by reference)
        ksort($params);

        //Transforming the query array to query string
        $queryString = http_build_query($params);

        $fullUrl = "{$url}?{$queryString}";

        return $fullUrl;

}

//get cache duration - for caching pages
function getCacheDuration($config='') {

        if ($config == 'low') {
		    $minutes = config('app.cache_minutes_low');
		} else {
		    $minutes = config('app.cache_minutes');
		}

        return $minutes;

}

function downloadExcelFile($excel_name, $excel_title, $excel_desc, $data_array, $data_type, $columns=8) {

	Excel::create($excel_name, function($excel) use ($data_array, $excel_name, $excel_title, $excel_desc, $columns) {

        // Set the spreadsheet title, creator, and description
        $excel->setTitle($excel_title);
        $excel->setCreator(config('app.name'))->setCompany(config('app.name'));
        $excel->setDescription($excel_desc);

        // Build the spreadsheet, passing in the data array
        $excel->sheet("sheet1", function($sheet) use ($data_array, $excel_name, $excel_title, $excel_desc, $columns) {

            $sheet->fromArray($data_array, null, 'A1', false, false);
            // Set auto size for sheet
			$sheet->setAutoSize(true);

			// Sets all borders
			$sheet->setAllBorders('thin');

			//get last column letter
			$letter = letterToNum($columns);
            //dd('A1:' . $letter . '1');

			$sheet->cells('A1:' . $letter . '1', function($cells) {
				// Set black background
				//$cells->setBackground('#000000');
				// Set with font color
				//$cells->setFontColor('#ffffff');

				// Set font family
				$cells->setFontFamily('Calibri');

				// Set font size
				$cells->setFontSize(14);

				// Set font weight to bold
				$cells->setFontWeight('bold');

			});

        });

    })->download($data_type);

}

//shorten text title
function reducelength($str,$maxlength=100) {
	if (strlen($str) > $maxlength) {
		$newstr = substr($str,0,$maxlength-3) . "...";
	} else {
		$newstr = $str;
	}
	return $newstr;
}

// get phone country - currently only KE
function getPhoneCountry()
{
    return "KE";
}

/// function to generate random number ///////////////
function generateCode($length = 5, $add_dashes = false, $available_sets = 'ud')
{
	$sets = array();
	if(strpos($available_sets, 'l') !== false)
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
	if(strpos($available_sets, 'u') !== false)
		$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
	if(strpos($available_sets, 'd') !== false)
		$sets[] = '23456789';
	if(strpos($available_sets, 's') !== false)
		$sets[] = '!@#$%&*?';
	$all = '';
	$password = '';
	foreach($sets as $set)
	{
		$password .= $set[array_rand(str_split($set))];
		$all .= $set;
	}
	$all = str_split($all);
	for($i = 0; $i < $length - count($sets); $i++)
		$password .= $all[array_rand($all)];
	$password = str_shuffle($password);
	if(!$add_dashes)
		return $password;
	$dash_len = floor(sqrt($length));
	$dash_str = '';
	while(strlen($password) > $dash_len)
	{
		$dash_str .= substr($password, 0, $dash_len) . '-';
		$password = substr($password, $dash_len);
	}
	$dash_str .= $password;
	return $dash_str;
}
// end of generate random number function

//get paybill name
function getPaybillName($paybill_no) {
	$res = MpesaPaybill::where('paybill_number', $paybill_no)->first();
	$name = $res->name;
	return $name;
}

function getUserAgent(){
	return @$_SERVER["HTTP_USER_AGENT"]?$_SERVER["HTTP_USER_AGENT"]: "" ;
}

function getIp(){
	$ip = request()->ip();
    return $ip;
}

function getHost() {
	return @$_SERVER["REMOTE_HOST"]? $_SERVER["REMOTE_HOST"]: "" ;
}

function getLocalDate($date) {
	//return Carbon::parse($date)->timezone(getLocalTimezone());
	$timezone = config('app.local_timezone');
	//return Carbon::parse($date)->timezone($timezone)->format($format);
	return Carbon::parse($date)->timezone($timezone);
}

function reArrangeSubmittedDate($date) {

    // input sample == 19-05-2020
    $date_array = explode ('-' , $date);

    // return as 2020-05-19
    return $date_array[2] . '-' . $date_array[1] . '-' . $date_array[0];

}

// mutate model dates
function showLocalizedDate($date) {
    return formatFriendlyDate(Carbon::parse($date)->timezone(getLocalTimezone()));
}

// get date in UTC timezone
function getUTCDate($date, $timezone="") {
    if (!$timezone) {
        $timezone = getLocalTimezone();
    }
    return Carbon::parse($date, $timezone)->setTimezone('UTC');
}

function getGMTDate($date) {
	return Carbon::parse($date);
}

// create date from format
function createDateFromFormat($date, $format='Y-m-d H:i:s') {

    $timezone = getLocalTimezone();
    // dd($timezone);
    $thedate = Carbon::createFromFormat($format, $date)->timezone($timezone);
    return $thedate;

}

function getLocalTimezone() {
	//get user timezone and return,
	//if blank return default timezone ('Africa/Nairobi')
	//$location = getUserLocation();
	//$userTimezone=$location->timezone;
	$userTimezone = '';
	if ($userTimezone) {
		$timezone = $userTimezone;
	} else {
		$timezone = config('app.local_timezone');
	}
	return $timezone;
}

function getCompanyData($company_id) {
    $company_data = Company::find($company_id);

    return $company_data;
}

// check if till exists for company
function tillExistsForCompany($till_no, $company_id, $id="") {

    $till_data = Till::where('company_id', $company_id)
                                ->where('till_number', $till_no)
                                ->when($id, function ($query) use ($id) {
                                    $query->where('id', "!=", $id);
                                })
                                ->first();

    if ($till_data){
        return true;
    }

    return false;

}

// check if activation code is valid
function isActivationCodeValid($activationCode, $phone_number="") {

    $confirm_code_data = getConfirmCodeData($activationCode, $phone_number);

    if ($confirm_code_data){
        return true;
    }

    return false;

}


// send account activation email/ sms
function sendAccountActivationDetails($phone, $email="", $resent_flag=false) {

    // defaults
    $resent_flag = $resent_flag ? $resent_flag : false;

    $sms_media_type = getMediaTypeSms();
    $email_media_type = getMediaTypeEmail();
    $registration_site_function = getSiteFunctionRegistration();

    /* $sms_template = getMediaTemplate($registration_site_function, $sms_media_type);
    $email_template = getMediaTemplate($registration_site_function, $email_media_type); */

    // get user data
    $user_data = getUserData($phone, $email);
    $first_name = $user_data->first_name;
    $phone_country = $user_data->phone_country;

    // generate activation code
    $site_settings = getSiteSettings();
    $activation_code_length = $site_settings['activation_code_length'];

    // get sms data
    $company_name = $site_settings['company_name_title'];

    $activation_code = generateCode($activation_code_length, false, 'd');

    // read and check for delimiters in template
    // create sms replacement array
    $sms_replacement_array = array();
    $sms_replacement_array[] = $first_name;
    $sms_replacement_array[] = $company_name;
    $sms_replacement_array[] = $activation_code;

    // generate sms message
    $sms_message = generateTemplateMessage($sms_media_type, $registration_site_function, $sms_replacement_array);

    // start send sms activation code
    // $sms_type = config('constants.sms_types.registration_sms');
    $sms_type = getRegistrationSmsType();

    // if this is resent reg sms
    if($resent_flag) {
        $sms_type = getResentRegistrationSmsType();
    }

    $confirm_code = $activation_code;
    $company_id = "";
    createPhoneConfirmCode($confirm_code, $phone, $phone_country, $company_id, $sms_type, $sms_message);
    // end send sms activation code

    // log data
    log_this("\n\n\n\n>>>>>>>>> send user sms - request :\n\n" . "sms_message == " . $sms_message . "\n phone == " . $phone);

    // send registration email to user
    // dd("email_message == ", $email_message);

    // set subject
    /* $title = $email_subject;
    $company_id = NULL;
    $panel_text = "";
    $table_text = "";
    $parent_id = NULL;
    $reminder_message_id = NULL; */

    // send email to user
    /* try {

        sendTheEmailToQueue(
            $email,
            $email_subject,
            $title,
            $company_full_name,
            $email_message,
            $email_salutation,
            $company_id,
            $email_footer,
            $panel_text,
            $table_text,
            $parent_id,
            $reminder_message_id
        );

    } catch(\Exception $e) {

        // dd($e);
        throw new \Exception($e->getMessage());

    } */

    // log data
    // log_this("\n\n\n\n>>>>>>>>> send user email - request :\n\n" . "email_message == " . $email_message . "\n email address == " . $email);

}


// generate template message
function generateTemplateMessage($media_type="", $site_function="", $replacement_array=[]) {

    // media_type - either email or sms
    $media_type = $media_type ? $media_type : getMediaTypeSms();

    // get the template
    $message_template = getMediaTemplate($site_function, $media_type);

    // formulate message from template
    $set_template = $message_template->text ? $message_template->text : $message_template->default_text;

    // replace delited text in template
    $message_text = replaceDelimitersInTemplate($set_template, $replacement_array);

    return $message_text;

}

// replaceDelimitersInTemplate
function replaceDelimitersInTemplate($template_text, $replacement_array) {

    $matches_regex = "/\[\[(\w+)\]\]/";
    $remove_spaces_regex = "/\s+/";

    // remove all spaces
    $regex_message = preg_replace($remove_spaces_regex, ' ', $template_text);
    $regex_message = strtolower($regex_message);

    // get the replaceable matches array - match_results
    preg_match_all($matches_regex, $regex_message, $match_results, PREG_PATTERN_ORDER);

    $replaceable_array = $match_results[0];

    $new_template_text = str_replace($replaceable_array, $replacement_array, $template_text);

    return $new_template_text;

}

// get media template
function getMediaTemplate($site_function, $media_type) {

    return MediaTemplate::where('site_function', $site_function)
                                        ->where('media_type', $media_type)
                                        ->first();

}

// encrypt data
function encryptData($data) {

    return encrypt($data);

}

// decrypt data
function decryptData($data) {

    $result = "";

    try {

        $result = decrypt($data);

    } catch(\Exception $e) {

        throw new \Exception("Could not decrypt text - " . $e->getMessage());

    }

    return $result;

}

// get confim code till
function getConfirmCodeData($activationCode, $phone_number="", $email="", $status_id="1") {

    $status_active = config('constants.status.active');

    // defaults
    $status_id = $status_id ? $status_id : $status_active;

    $confirm_code_data = ConfirmCode::where('confirm_code', $activationCode)
                                    ->where('status_id', $status_id)
                                    ->when($phone_number, function ($query) use ($phone_number) {
                                        $query->where('phone', $phone_number);
                                    })
                                    ->when($email, function ($query) use ($email) {
                                        $query->where('email', $email);
                                    })
                                    ->first();

    return $confirm_code_data;

}

// activate phone till
function activatePhoneTill($activationCode, $confirm_code_phone) {

    $status_disabled = getStatusDisabled();
    $status_confirmed = getStatusConfirmed();

    // activate till
    changeTillStatus($confirm_code_phone, $status_confirmed);

    // disable activation code
    changeConfirmCodeStatus($activationCode, $status_disabled);

    return true;

}

// activate phone number
function changeConfirmCodeStatus($activationCode, $status) {

    // disable activation code
    ConfirmCode::where('confirm_code', $activationCode)
                ->update(['status_id' => $status]);

    return true;

}

// change till status
function changeTillStatus($phone_number, $status) {
    // dump($phone_number, $status);

    $status_confirmed = getStatusConfirmed();
    $current_date = getCurrentDate(1);

    // change status
    $till_data = Till::where('phone_number', $phone_number)->first();
    // dd($till_data);

    $till_data->status_id = $status;
    if ($status == $status_confirmed) {
        $till_data->confirmed_at = $current_date;
    }

    $till_data->save();

    return true;

}

// check if phone till exists for company
function phoneTillExistsForCompany($phone_number, $company_id, $id="") {

    $till_data = Till::where('company_id', $company_id)
                                ->where('phone_number', $phone_number)
                                ->when($id, function ($query) use ($id) {
                                    $query->where('id', "!=", $id);
                                })
                                ->first();

    if ($till_data){
        return true;
    }

    return false;

}

function getJsonOauthData() {

	$data = [
	        'json' => [
	            "grant_type"=> "password",
				"client_id"=> config('constants.oauth.client_id'),
				"client_secret"=> config('constants.oauth.client_secret'),
				"username"=> config('constants.oauth.username'),
				"password"=> config('constants.oauth.password'),
				"scope"=> ""
	        ]
	    ];

	return $data;

}

function getyehuJsonOauthData() {

	$data = [
	        'json' => [
	            "grant_type"=> "password",
				"client_id"=> config('constants.yehuoauth.client_id'),
				"client_secret"=> config('constants.yehuoauth.client_secret'),
				"username"=> config('constants.yehuoauth.username'),
				"password"=> config('constants.yehuoauth.password'),
				"scope"=> ""
	        ]
	    ];

	return $data;

}

function getBulkSmsJsonOauthData() {

	$data = [
	        'json' => [
	            "grant_type"=> "password",
				"client_id"=> config('constants.bulk_sms.client_id'),
				"client_secret"=> config('constants.bulk_sms.client_secret'),
				"username"=> config('constants.bulk_sms.username'),
				"password"=> config('constants.bulk_sms.password'),
				"scope"=> ""
	        ]
	    ];

	return $data;

}

// fetching remote mpesa payments data
function getMpesaPayments2($data) {

	//dd($data);
	$body = [];
	//get bulk sms data for this client
	$get_mpesa_data_url = config('constants.mpesa.getpayments_url');

	//url params
	if ($data->id) { $body['id'] = $data->id; }
	if ($data->page) { $body['page'] = $data->page; }
	if ($data->limit) { $body['limit'] = $data->limit; }
	if ($data->report) { $body['report'] = $data->report; }
	if ($data->paybills) { $body['paybills'] = $data->paybills; }
	if ($data->phone_number) { $body['phone_number'] = $data->phone_number; }
	if ($data->account_name) { $body['account_name'] = $data->account_name; }
	if ($data->start_date) { $body['start_date'] = $data->start_date; }
	if ($data->end_date) { $body['end_date'] = $data->end_date; }

	//dd($body);

	//get sms urls
	$get_oauth_token_url = config('constants.oauth.token_url');

    //get oauth access token
    $tokenclient = getTokenGuzzleClient();

    $oauth_json_data = getJsonOauthData();

	$resp = $tokenclient->request('POST', $get_oauth_token_url, $oauth_json_data);

    if ($resp->getBody()) {

        $result = json_decode($resp->getBody());
        $access_token = $result->access_token;
        $refresh_token = $result->refresh_token;
        //dd($result);

        try {

            //send request to get mpesa
            $dataclient = getGuzzleClient($access_token);
            $respons = $dataclient->request('GET', $get_mpesa_data_url, [
                'query' => $body
                //,'http_errors' => false
			]);
			//dd($get_mpesa_data_url, $respons);

            if ($respons->getStatusCode() == 200) {

                if ($respons->getBody()) {

                    $response = json_decode($respons->getBody());
                    //dd($get_mpesa_data_url, $response);

                } else {

					$response["error"] = true;
					$response["message"] = "An error occured while fetching mpesa data";

			    }

			    return $response;

            }

        } catch (RequestException $e) {

            return handleGuzzleError($e);
            //return $e;

        }

    }

	//return $response;

}

//get company paybill no
function getMpesaPayments($data) {

	$report = false;

	$url = config('constants.mpesa.getpayments_url');
    $pendoapi_app_name = getPendoAdminAppName();

	//get app access token
	$access_token = getAdminAccessToken($pendoapi_app_name);
	//dd($access_token, $pendoapi_app_name, $url);

    if ($access_token) {

		$account_search = "";
		$start_date = "";
		$end_date = "";
		$id = "";
		$phone = "";
		$trans_id = "";
		$order_by = "";
		$order_style = "";
		$paybills = "";
		$page = "";

		if ($data->has('report')) {
			$report = $data->report;
		}
		if ($data->has('account_search')) {
			$account_search = $data->account_search;
		}
		if ($data->has('start_date')) {
			$start_date = $data->start_date;
		}
		if ($data->has('end_date')) {
			$end_date = $data->end_date;
		}
		if ($data->has('id')) {
			$id = $data->id;
		}
		if ($data->has('phone')) {
			$phone = $data->phone;
		}
		if ($data->has('trans_id')) {
			$trans_id = $data->trans_id;
		}
		if ($data->has('order_by')) {
			$order_by = $data->order_by;
		}
		if ($data->has('order_style')) {
			$order_style = $data->order_style;
		}
		if ($data->has('paybills')) {
			$paybills = $data->paybills;
		}
		if ($data->has('page')) {
			$page = $data->page;
		}
		//set params
		$params = [
			'json' => [
				"report"=> $report,
				"account_search"=> $account_search,
				"start_date"=> $start_date,
				"end_date"=> $end_date,
				"id"=> $id,
				"phone"=> $phone,
				"trans_id"=> $trans_id,
				"order_by"=> $order_by,
				"order_style"=> $order_style,
				"paybills"=> $paybills,
				"page"=> $page
			]
		];
		//dd($data, $params);

		//start get paybill data
		$result = sendAuthGetApi($url, $access_token, $params);
		//dd($result);

	    return $result;

	} else {

		return false;

	}

	//end get paybill data

}

//create remote pesapaybill
function createRemoteMpesaPaybill($data) {

	$report = false;

	$url = config('constants.mpesa_paybills.create_paybills_url');
    $pendoapi_app_name = getPendoAdminAppName();

	//get app access token
	$access_token = getAdminAccessToken($pendoapi_app_name);
	//dd($access_token, $pendoapi_app_name, $url);

    if ($access_token) {

		$paybill_number = "";
		$name = "";
		$type = "";
		$till_number = "";
		$company_id = "";
		$description = "";
		$company_branch_id = "";
		$created_by = "";
		$updated_by = "";

		if (array_key_exists('paybill_number', $data)) {
            $paybill_number = $data['paybill_number'];
        }
        if (array_key_exists('company_id', $data)) {
            $company_id = $data['company_id'];
        }
        if (array_key_exists('description', $data)) {
            $description = $data['description'];
        }
        if (array_key_exists('name', $data)) {
            $name = $data['name'];
        }
        if (array_key_exists('type', $data)) {
            $type = $data['type'];
        }
        if (array_key_exists('till_number', $data)) {
            $till_number = $data['till_number'];
        }
        if (array_key_exists('company_branch_id', $data)) {
            $company_branch_id = $data['company_branch_id'];
        }
        if (array_key_exists('created_by', $data)) {
            $created_by = $data['created_by'];
        }
        if (array_key_exists('updated_by', $data)) {
            $updated_by = $data['updated_by'];
		}

		//set params
		$params = [
			'json' => [
				"paybill_number"=> $paybill_number,
				"name"=> $name,
				"type"=> $type,
				"app_name"=> "snb",
				"till_number"=> $till_number,
				"company_id"=> $company_id,
				"description"=> $description,
				"company_branch_id"=> $company_branch_id,
				"created_by"=> $created_by,
				"updated_by"=> $updated_by
			]
		];
		//dd($url, $params);

		//start get paybill data
		$result = sendAuthPostApi($url, $access_token, $params);
		//dd($result);

	    return $result;

	} else {

		return false;

	}

	//end get paybill data

}


// fetching local payments data
function getLocalPayments($data) {

	//dd($data);
	$body = [];
	//get bulk sms data for this client
	$get_local_yehu_deposits_data_url = config('constants.yehu.getdepositslocal_url');
	//dd($get_local_yehu_deposits_data_url);

	//url params
	if ($data->id) { $body['id'] = $data->id; }
	if ($data->page) { $body['page'] = $data->page; }
	if ($data->limit) { $body['limit'] = $data->limit; }
	if ($data->report) { $body['report'] = $data->report; }
	if ($data->paybills) { $body['paybills'] = $data->paybills; }
	if ($data->phone_number) { $body['phone_number'] = $data->phone_number; }
	if ($data->acct_no) { $body['acct_no'] = $data->acct_no; }
	if ($data->bu_id) { $body['bu_id'] = $data->bu_id; }
	if ($data->trans_id) { $body['trans_id'] = $data->trans_id; }
	if ($data->processed) { $body['processed'] = $data->processed; }
	if ($data->failed) { $body['failed'] = $data->failed; }
	if ($data->start_date) { $body['start_date'] = $data->start_date; }
	if ($data->end_date) { $body['end_date'] = $data->end_date; }

	//dd($body);

	//get sms urls
	//$get_oauth_token_url = config('constants.yehuoauth.token_url');

    //get oauth access token
    //$tokenclient = getTokenGuzzleClient();

    //$oauth_json_data = getYehuJsonOauthData();

    //$resp = $tokenclient->request('POST', $get_oauth_token_url, $oauth_json_data);

    //if ($resp->getBody()) {

        /*$result = json_decode($resp->getBody());
        $access_token = $result->access_token;
        $refresh_token = $result->refresh_token;
        */

        try {

            //send request to get mpesa
            //$dataclient = getGuzzleClient($access_token);
            $dataclient = getTokenGuzzleClient();
            $respons = $dataclient->request('GET', $get_local_yehu_deposits_data_url, [
                'query' => $body
            ]);

            if ($respons->getStatusCode() == 200) {

                if ($respons->getBody()) {

                    $result = json_decode($respons->getBody());
                    $response["error"] = false;
					$response["message"] = $result;

                } else {

					$response["error"] = true;
					$response["message"] = "An error occured while fetching local payments data";

			    }

			    return $response;

            }

        } catch (\Exception $e) {

            return handleGuzzleError($e);

        }

    //}

	return $response;

}

// fetching remote payments data
function getRemotePayments($data) {

	$body = [];
	//get yehu deposit
	$get_yehu_deposits_data_url = config('constants.yehu.getdepositsremote_url');

	//url params
	if ($data->id) { $body['id'] = $data->id; }
	if ($data->page) { $body['page'] = $data->page; }
	if ($data->limit) { $body['limit'] = $data->limit; }
	if ($data->report) { $body['report'] = $data->report; }
	if ($data->paybills) { $body['paybills'] = $data->paybills; }
	if ($data->phone_number) { $body['phone_number'] = $data->phone_number; }
	if ($data->acct_no) { $body['acct_no'] = $data->acct_no; }
	if ($data->bu_id) { $body['bu_id'] = $data->bu_id; }
	if ($data->trans_id) { $body['trans_id'] = $data->trans_id; }
	if ($data->processed) { $body['processed'] = $data->processed; }
	if ($data->failed) { $body['failed'] = $data->failed; }
	if ($data->start_date) { $body['start_date'] = $data->start_date; }
	if ($data->end_date) { $body['end_date'] = $data->end_date; }

	//get sms urls
	//$get_oauth_token_url = config('constants.yehuoauth.token_url');

    //get oauth access token
    //$tokenclient = getTokenGuzzleClient();

    //$oauth_json_data = getYehuJsonOauthData();

    //$resp = $tokenclient->request('POST', $get_oauth_token_url, $oauth_json_data);

    //if ($resp->getBody()) {

        /*$result = json_decode($resp->getBody());
        $access_token = $result->access_token;
        $refresh_token = $result->refresh_token;
        */

        try {

            //send request to get mpesa
            //$dataclient = getGuzzleClient($access_token);
            $dataclient = getTokenGuzzleClient();
            $respons = $dataclient->request('GET', $get_yehu_deposits_data_url, [
                'query' => $body
                //, 'http_errors' => false
            ]);

            if ($respons->getStatusCode() == 200) {

                if ($respons->getBody()) {

                    $result = json_decode($respons->getBody());
                    $response["error"] = false;
					$response["message"] = $result;

                } else {

					$response["error"] = true;
					$response["message"] = "An error occured while fetching remote payments data";

			    }

			    return $response;

            }

        } catch (RequestException $e) {

            return handleGuzzleError($e);
            //return $e;

        }

    //}

}

//update existing local yehu deposit
function updateYehuDeposit($id, $data) {

	//update yehu deposit
	$update_yehu_deposit_data_url = config('constants.yehu.update_depositlocal_url');
	$update_yehu_deposit_data_url .=  "/" . $id;

	$user_full_names = getLoggedUser()->first_name . ' ' . getLoggedUser()->last_name;
	$user_full_names = trim($user_full_names);

	if ($data->acct_no) { $body['acct_no'] = $data->acct_no; }
	$body['updated_by'] = $user_full_names;

	//dd($update_yehu_deposit_data_url, $body);

	try {

            //send request to save deposit
            $dataclient = getTokenGuzzleClient();
            $respons = $dataclient->request('PUT', $update_yehu_deposit_data_url, [
                'query' => $body
            ]);

            if ($respons->getStatusCode() == 200) {

                if ($respons->getBody()) {

                    $result = json_decode($respons->getBody());
                    $response["error"] = false;
					$response["message"] = $result;

                } else {

					$response["error"] = true;
					$response["message"] = "An error occured while updating local payments data";

			    }

			    return $response;

            }

        } catch (RequestException $e) {

            return handleGuzzleError($e);

        }

}

//create remote yehu deposit
function createYehuDeposit($data) {

	//update yehu deposit
	$create_yehu_deposit_data_url = config('constants.yehu.create_depositremote_url');

	$user_full_names = getLoggedUser()->first_name . ' ' . getLoggedUser()->last_name;
	$user_full_names = trim($user_full_names);

	if ($data->id) { $body['id'] = $data->id; }
	if ($data->acct_no) { $body['acct_no'] = $data->acct_no; }
	if ($data->amount) { $body['amount'] = $data->amount; }
	if ($data->paybill_number) { $body['paybill_number'] = $data->paybill_number; }
	if ($data->full_name) { $body['full_name'] = $data->full_name; }
	if ($data->phone_number) { $body['phone_number'] = $data->phone_number; }
	if ($data->src_ip) { $body['src_ip'] = $data->src_ip; }
	if ($data->trans_id) { $body['trans_id'] = $data->trans_id; }
	$body['updated_by'] = $user_full_names;
	//dd($create_yehu_deposit_data_url, $body);

	try {

        //send request to save deposit
        $dataclient = getTokenGuzzleClient();
        $respons = $dataclient->request('POST', $create_yehu_deposit_data_url, [
            'query' => $body
        ]);
        //dd($respons);

        if ($respons->getStatusCode() == 200) {

            if ($respons->getBody()) {

                $result = json_decode($respons->getBody());
                $response["error"] = false;
				$response["message"] = $result;

            } else {

				$response["error"] = true;
				$response["message"] = "An error occured while creating remote yehu deposit";

		    }

		    return $response;

        }

    } catch (RequestException $e) {

        return handleGuzzleError($e);

    }

}


// fetching bulk sms data
function getCompanyBulkSMSData($company_id) {

	$company_data = Company::find($company_id);
	$sms_user_name = $company_data->sms_user_name;
	$data = getRealSMSData($sms_user_name);

	return $data;

}

function getBulkSMSData($user_id) {

	$user = User::where('id', $user_id)
		->with('company')
		->first();

	$sms_user_name = "";
	if ($user->company) {
		$sms_user_name = $user->company->sms_user_name;
	}

	$data = getRealSMSData($sms_user_name);

	return $data;

}

function getRealSMSData($sms_user_name) {

	/*$user = User::where('id', $user_id)
		->with('company')
		->first();

	$sms_user_name = "";
	if ($user->company) {
		$sms_user_name = $user->company->sms_user_name;
	}*/
	//$sms_user_name = "steve";

	if ($sms_user_name) {

		//get bulk sms data for this client
		$get_sms_data_url = config('constants.bulk_sms.get_sms_data_url');

		//url params
		$body['username'] = $sms_user_name;

		//get sms urls
		$get_oauth_token_url = config('constants.oauth.token_url');

	    //get oauth access token
	    $tokenclient = getTokenGuzzleClient();

	    $oauth_json_data = getJsonOauthData();

	    $resp = $tokenclient->request('POST', $get_oauth_token_url, $oauth_json_data);

	    if ($resp->getBody()) {

	        $result = json_decode($resp->getBody());
	        $access_token = $result->access_token;
	        $refresh_token = $result->refresh_token;

	        try {

	            //send request to send sms
	            $dataclient = getGuzzleClient($access_token);
	            $respons = $dataclient->request('GET', $get_sms_data_url, [
	                'query' => $body
	            ]);

	            if ($respons->getStatusCode() == 200) {

	                if ($respons->getBody()) {

	                    $result = json_decode($respons->getBody());
	                    //dd($result);

	                    $response["error"] = false;
						$response["sms_user_name"] = $sms_user_name;
						$response["passwd"] = $result->data->passwd;
						$response["alphanumeric_id"] = $result->data->alphanumeric_id;
						$response["fullname"] = $result->data->fullname;
						$response["rights"] = $result->data->rights;
						$response["active"] = $result->data->active;
						$response["default_sid"] = $result->data->default_sid;
						$response["default_source"] = $result->data->default_source;
						$response["paybill"] = $result->data->paybill;
						$response["relationship"] = $result->data->relationship;
						$response["home_ip"] = $result->data->home_ip;
						$response["default_priority"] = $result->data->default_priority;
						$response["default_dest"] = $result->data->default_dest;
						$response["default_msg"] = $result->data->default_msg;
						$response["sms_balance"] = $result->data->sms_balance;
						$response["sms_expiry"] = $result->data->sms_expiry;
						$response["routes"] = $result->data->routes;
						$response["last_updated"] = $result->data->last_updated;

	                } else {

						$response["error"] = true;
						$response["message"] = "An error occured while fetching bulk sms account";

				    }

				    return $response;

	            }

	        } catch (\Exception $e) {
	            //dd($e);
	        }

	    }

	} else {

		$response["error"] = true;
		$response["message"] = "No SMS account exists";

    }

	return $response;

}


//send sms
function sendSms($params) {

	//get data array
	$body['usr'] = $params['usr'];
    $body['pass'] = $params['pass'];
    $body['src'] = $params['src'];
    $body['dest'] = $params['phone_number'];
    $body['msg'] = $params['sms_message'];

	//get urls
	$get_oauth_token_url = config('constants.oauth.token_url');
	$send_sms_url = config('constants.bulk_sms.send_sms_url');

    //get oauth access token
    $tokenclient = getTokenGuzzleClient();

    $oauth_json_data = getJsonOauthData();

	$resp = $tokenclient->request('POST', $get_oauth_token_url, $oauth_json_data);

    if ($resp->getBody()) {

        $result = json_decode($resp->getBody());
        $access_token = $result->access_token;
        $refresh_token = $result->refresh_token;

        try {

            //send request to send sms
            $dataclient = getGuzzleClient($access_token);
            $respons = $dataclient->request('POST', $send_sms_url, [
                'query' => $body
            ]);

            if ($respons->getStatusCode() == 200) {

                if ($respons->getBody()) {

                    $result = json_decode($respons->getBody());
                    //dd($result);

                    // get results
					if  ($result->success) {

						//show data
						$response["error"] = false;
						$response["message"] = $result->success->message;

				    } else {

						$response["error"] = true;
						$response["message"] = $result->success->message;

				    }

                } else {

					$response["error"] = true;
					$response["message"] = "An error occured while sending sms";

			    }

			    return $response;

            }

        } catch (\Exception $e) {

            return handleGuzzleError($e);

        }

    }

}


//check if paybill is valid
function isPaybillValid($est_id, $user_id=NULL, $admin=NULL) {

	$response = array();

	$results = array();

	if (!$user_id) { $user_id = USER_ID; }

	//check user permissions
	$super_admin = $this->isSuperAdmin($user_id);
	if ($admin && !$super_admin) {
		$perms = ALL_MPESA_TRANS_PERMISSIONS;
		$company_ids = $this->getUserCompanyIds($user_id, $perms, $est_id);
	}

	if ($super_admin || ($admin && $company_ids)) {

		//get bulk sms data
		$bulk_sms_data = $this->getBulkSMSData(BULK_SMS_USERNAME);
		$usr = $est_id;
		$pass = $bulk_sms_data["passwd"];
		$src = $bulk_sms_data["default_source"];
		$paybill_no = $bulk_sms_data["paybill"];

		if ($usr && $pass && $paybill_no) {

			//show success msg
			$response["message"] = SUCCESS_MESSAGE;
			$response["error"] = false;

		} else {

			//get est name
			$est_data_items = $this->getEstablishments("", $est_id);
			$est_data_item = $est_data_items["rows"][0];
			$est_name = $est_data["name"];

			//show error msg
			$response["message"] = sprintf(NO_PAYBILL_NUMBER_ERROR_MESSAGE, $est_name);
			$response["error_type"] = NO_PERMISSION_ERROR;
			$response["error"] = true;

		}

	} else {

		//show error msg
		$response["message"] = NO_PERMISSION_ERROR_MESSAGE;
		$response["error_type"] = NO_PERMISSION_ERROR;
		$response["error"] = true;

	}

	return $response;

}

function getGuzzleClient($token)
{
    return new \GuzzleHttp\Client([
        'headers' => [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ],
    ]);
}

function getTokenGuzzleClient()
{
    return new \GuzzleHttp\Client([
        'headers' => [
            'Content-Type' => 'application/json'
        ]
    ]);
}


/**
 * Check if the @param is formatted as an e-mail address.
 *
 * @param string $emailToCkeck
 * @return bool
 */
/*private function validateEmailCheck($emailToCkeck)
{
    $my_data = [
        'email' => $emailToCkeck,
    ];
    $validator = Validator::make($my_data, [
        'email' => 'email',
    ]);
    if ($validator->fails()) {
        return false;
    } else {
        return true;
    }
}*/
