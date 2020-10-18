<?php

namespace App\Http\Controllers;

use App\Entities\Company;
use App\Entities\SmsOutbox;
use App\Services\Export\ToExcel\MpesaIncomingToExcel;
use App\Services\Export\ToExcel\SmsOutboxExcel;
use App\Services\Export\ToExcel\UserSavingsAccountToExcel;
use App\Services\Export\ToExcel\UssdContactUsToExcel; 
use App\Services\Export\ToExcel\UssdEventsToExcel;
use App\Services\Export\ToExcel\UssdPaymentsToExcel;
use App\Services\Export\ToExcel\UssdRecommendsToExcel;
use App\Services\Export\ToExcel\UssdRegistrationToExcel; 
use App\Services\Export\ToExcel\YehuDepositsToExcel;
use App\Services\Export\ToExcel\PaymentsToExcel;
use App\Services\Export\ToExcel\LoanAccountToExcel;
use App\Services\Export\ToExcel\DepositAccountToExcel;
use App\Services\Export\ToExcel\TransfersToExcel;
use App\Services\Export\ToExcel\DepositAccountHistoryToExcel;
use App\Services\Export\ToExcel\DepositAccountSummaryToExcel;
use App\Services\Export\ToExcel\GlAccountHistoryToExcel;
use App\Services\Export\ToExcel\GlAccountSummaryToExcel;
use App\Services\Export\ToExcel\SupervisorClientsToExcel;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExcelController extends Controller
{
    
    //export sms outbox
    public function exportOutboxSmsToExcel($type, SmsOutboxExcel $smsOutboxExcel) {
        $exportedExcel = $smsOutboxExcel->exportExcel($type, request());
    }

    //export mpesa incoming
    public function exportMpesaIncomingToExcel($type, MpesaIncomingToExcel $mpesaIncomingToExcel) {
        $exportedExcel = $mpesaIncomingToExcel->exportExcel($type, request());
    }

    //export ussd registration
    public function exportUssdRegistrationToExcel($type, UssdRegistrationToExcel $ussdRegistrationToExcel) {
        $exportedExcel = $ussdRegistrationToExcel->exportExcel($type, request());
    }

    //export ussd events
    public function exportUssdEventsToExcel($type, UssdEventsToExcel $ussdEventsToExcel) {
        $exportedExcel = $ussdEventsToExcel->exportExcel($type, request());
    }

    //export ussd payments
    public function exportUssdPaymentsToExcel($type, UssdPaymentsToExcel $ussdPaymentsToExcel) {
        $exportedExcel = $ussdPaymentsToExcel->exportExcel($type, request());
    }

    //export ussd recommends
    public function exportUssdRecommendsToExcel($type, UssdRecommendsToExcel $ussdRecommendsToExcel) {
        $exportedExcel = $ussdRecommendsToExcel->exportExcel($type, request());
    }

    //export ussd contact us
    public function exportUssdContactUsToExcel($type, UssdContactUsToExcel $ussdContactUsToExcel) {
        $exportedExcel = $ussdContactUsToExcel->exportExcel($type, request());
    }

    //export yehu deposits
    public function exportYehuDepositsToExcel($type, YehuDepositsToExcel $yehuDepositsToExcel) {
        $exportedExcel = $yehuDepositsToExcel->exportExcel($type, request());
    }

    //export loan applications
    public function exportLoanApplicationsToExcel($type, LoanApplication $loanApplicationsToExcel) {
        $exportedExcel = $loanApplicationsToExcel->exportExcel($type, request());
    }

    //export user savings accounts
    public function exportUserSavingsAccountsToExcel($type, UserSavingsAccountToExcel $userSavingsAccountToExcel) {
        $exportedExcel = $userSavingsAccountToExcel->exportExcel($type, request());
    }

    //export user savings accounts
    public function exportUserLoanAccountsToExcel($type, LoanAccountToExcel $loanAccountToExcel) {
        $exportedExcel = $loanAccountToExcel->exportExcel($type, request());
    }

    //export users
    public function exportUsersToExcel($type, LoanAccountToExcel $loanAccountToExcel) {
        $exportedExcel = $loanAccountToExcel->exportExcel($type, request());
    }

    //export deposit accounts history
    public function exportDepositAccountHistoryToExcel($type, DepositAccountHistoryToExcel $depositAccountHistoryToExcel) {
        $exportedExcel = $depositAccountHistoryToExcel->exportExcel($type, request());
    }

    //export transfers To Excel
    public function exportTransfersToExcel($type, TransfersToExcel $transfersToExcel) {
        $exportedExcel = $transfersToExcel->exportExcel($type, request());
    }

    //export deposit accounts summary
    public function exportDepositAccountSummaryToExcel($type, DepositAccountSummaryToExcel $depositAccountSummaryToExcel) {
        $exportedExcel = $depositAccountSummaryToExcel->exportExcel($type, request());
    }

    //exportSupervisorClientsToExcel
    public function exportSupervisorClientsToExcel($type, SupervisorClientsToExcel $supervisorClientsToExcel) {
        $exportedExcel = $supervisorClientsToExcel->exportExcel($type, request());
    }

    //export gl accounts history
    public function exportGlAccountHistoryToExcel($type, GlAccountHistoryToExcel $glAccountHistoryToExcel) {
        $exportedExcel = $glAccountHistoryToExcel->exportExcel($type, request());
    }

    //export gl accounts summary
    public function exportGlAccountSummaryToExcel($type, GlAccountSummaryToExcel $glAccountSummaryToExcel) {
        $exportedExcel = $glAccountSummaryToExcel->exportExcel($type, request());
    }

    //export user loan repayment accounts
    public function exportUserLoanRepaymentAccountsToExcel($type, UserLoanrepaymentAccountToExcel $userLoanrepaymentAccountToExcel) {
        $exportedExcel = $userLoanrepaymentAccountToExcel->exportExcel($type, request());
    }


    //export deposit savings accounts
    public function exportdepositSavingsAccountsToExcel($type, DepositSavingsAccountToExcel $depositSavingsAccountToExcel) {
        $exportedExcel = $depositSavingsAccountToExcel->exportExcel($type, request());
    }

    //export deposit loan repayment accounts
    public function exportDepositLoanRepaymentAccountsToExcel($type, DepositLoanrepaymentAccountToExcel $depositLoanrepaymentAccountToExcel) {
        $exportedExcel = $depositLoanrepaymentAccountToExcel->exportExcel($type, request());
    }

    //export user payments
    public function exportPaymentsToExcel($type, PaymentsToExcel $paymentsToExcel) {
        $exportedExcel = $paymentsToExcel->exportExcel($type, request());
    }

    //export user logins
    public function exportUserLoginsToExcel($type, PaymentsToExcel $yehuDepositsToExcel) {
        $exportedExcel = $yehuDepositsToExcel->exportExcel($type, request());
    }
    
}
