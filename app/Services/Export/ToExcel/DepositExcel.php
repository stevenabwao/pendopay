<?php

namespace App\Services\Export\ToExcel;

use App\Deposit;
use App\Group;
use App\Loan;
use App\RoleUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DepositExcel
{

	public function exportExcel($type, $data) {

        //set page permissions
        $permissions = array('create-report', 'update-report');

        //get logged in user
        $auth_user = auth()->user();

        $search = $data->search;
        $search_text = $data->search_text;

        //if user is superadmin, show all deposits and user accounts,
        //else show deposits as necessary
        $deposits = [];
        $users = [];

        if ($auth_user->hasRole('superadministrator')){

            //get deposits
            $deposits = Deposit::with('user');

        } else {

            //get current user group/ team ids
            $team_ids = $auth_user->teams->pluck('id');
            $team_ids = $team_ids->unique('id');

            //find current user permissions in above groups/ teams on deposits model??
            $team_ids = getAdminGroupIds($team_ids, $permissions);

            //get current user's account ids
            $user_account_ids = RoleUser::where('user_id', $auth_user->id)->pluck('id');

            //get group user ids
            if (count($team_ids)) {

                //get team users deposits
                $deposits = Deposit::whereIn("team_id", $team_ids)
                        ->orWhereIn("user_id", $user_account_ids);

            } else {

                //get current user deposits using account ids
                $deposits = Deposit::whereIn("user_id", $user_account_ids);

            }

            //get user accounts
            $users = $users->get();

        }

        //get sheets titles and other data
        $excel_name = "deposits";
        $excel_title = "Deposits";
        $excel_desc = "Deposits data";

        //search params - for filtering records based on search criteria
        $start_date = $data->start_date;
        $end_date = $data->end_date;
        $user_id = $data->user_id;
        $start_at_date = Carbon::parse($start_date);
        $end_at_date = Carbon::parse($end_date);

        if ($start_date) {
            $deposits = $deposits->where('created_at', '>=', $start_at_date);
            //get excel titles
            $excel_name .= "_from_" . $start_at_date;
            $excel_title .= "_from_" . $start_at_date;
        }

        if ($end_date) {
            $deposits = $deposits->where('created_at', '<=', $end_at_date);
            //get excel titles
            $excel_name .= "_to_" . $end_at_date;
            $excel_title .= "_to_" . $end_at_date;
        }

        if ($user_id) {
            $deposits = $deposits->where('user_id', '=', $user_id);
            //get excel titles
            $user_account = RoleUser::where('user_id', $user_id)->first();
            $user_first_name = $user_account->user->first_name;
            $user_last_name = $user_account->user->last_name;
            $full_names = $user_first_name . ' ' . $user_last_name;
            $excel_name .= "_user_" . $full_names;
            $excel_title .= "_user_" . $full_names;
        }
        //end search params

        //format excel name
        $excel_name = getStrSlug($excel_name);

        //get user accounts
        $deposits = $deposits->get();

        //if deposits exist
        if (count($deposits)) {

            // Initialize the array which will be passed into the Excel
            // generator.
            $depositsArray = [];

            // Define the Excel spreadsheet headers
            $depositsArray[] = ['id', 'amount','name','group','created_at'];

            // Convert each member of the returned collection into an array,
            // and append it to the array.
            foreach ($deposits as $deposit) {

            	$single_deposit = [];

            	$single_deposit['id'] = $deposit->id;
            	$single_deposit['amount'] = formatExcelFloat($deposit->amount);
            	$first_name = $deposit->user->user->first_name;
            	$last_name = $deposit->user->user->last_name;
            	$single_deposit['full_names'] = titlecase($first_name . " " . $last_name);
            	$single_deposit['company_name'] = $deposit->user->team->display_name;
            	$single_deposit['created_at'] = formatExcelDate($deposit->created_at);

                $depositsArray[] = $single_deposit;

            }

            // Generate and return the spreadsheet

            $data_array = $depositsArray;
            $data_type = $type;

            //dd($depositsArray, $excel_name, $excel_title);

            //download the file
            downloadExcelFile($excel_name, $excel_title, $excel_desc, $data_array, $data_type);

        }

	}

}
