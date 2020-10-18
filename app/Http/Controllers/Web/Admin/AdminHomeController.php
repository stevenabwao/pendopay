<?php

namespace App\Http\Controllers\Web\Admin;

use App\Entities\Company;
use App\Entities\CompanyJoinRequest;
use App\Entities\Group;
use App\Entities\SmsOutbox;
use App\Entities\CompanyUser;
use App\Entities\LoanAccount;
use App\Entities\Offer;
use App\Entities\Order;
use App\Role;
use App\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Http\Controllers\Controller;

class AdminHomeController extends Controller
{

    /**
     * Show the application home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (isUserHasPermissions("1", ['read-dashboard'])) {

            $user = auth()->user();
            $smsoutboxes = [];

            $status_active = config('constants.status.active');
            $status_inactive = config('constants.status.inactive');
            $status_open = config('constants.status.open');
            $status_paid = config('constants.status.paid');
            $status_unpaid = config('constants.status.unpaid');

            $company_ids = getUserCompanyIds();
            // dd($company_ids);

            //get company users/ groups
            $users = [];
            //$groups = [];

            if ($company_ids) {

                /*$groups = Group::whereIn('company_id', $company_ids)
                        ->orderBy('id', 'desc')
                        ->with('company')
                        ->with('users')
                        ->paginate(10);*/

                $users = CompanyUser::whereIn('company_id', $company_ids)
                        ->whereNotIn('user_id', [1,2,3,4])
                        ->orderBy('id', 'desc')
                        ->paginate(5);
                $users_count = CompanyUser::whereIn('company_id', $company_ids)
                        ->whereNotIn('user_id', [1,2,3,4])
                        ->count();
                $users->users_count = $users_count;
                //dd($users_count);

                $orders = Order::whereIn('company_id', $company_ids)
                        ->orderBy('id', 'desc')
                        ->paginate(5);

                $offers = Offer::whereIn('company_id', $company_ids)
                        ->orderBy('id', 'desc')
                        ->paginate(5);

                /* $smsoutboxes = SmsOutbox::whereIn('company_id', $company_ids)
                        ->orderBy('id', 'desc')
                        ->get(); */
                        //->paginate(10);

                /* $activeloanscount = LoanAccount::where('status_id', $status_open)
                        ->whereIn('company_id', $company_ids)
                        ->count(); */

                $current_date = getCurrentDateObj();

                $establishmentscount = Company::whereIn('id', $company_ids)
                        ->count();

                $activeorderscount = 11;

                $pendingorderscount = 25;

                $completedorderscount = 112;

                /* $pendingloanscount = LoanAccount::whereDate('maturity_at', "<", $current_date)
                        ->whereIn('company_id', $company_ids)
                        ->where('status_id', '!=', $status_paid)
                        ->count();

                */

                //dd($activeloanscount, $pendingloanscount, $completedloanscount);

                //sms outbox count
                /* $count_smsoutbox = count($smsoutboxes);
                $user->sms_outbox_count = $count_smsoutbox; */

                $totalorderscount = $activeorderscount + $pendingorderscount;
                //calculate percentages
                $activeorderscountpercent = ($activeorderscount/ $totalorderscount) * 100;
                $pendingorderscountpercent = ($pendingorderscount/ $totalorderscount) * 100;

                $activeorderscountpercent = format_num($activeorderscountpercent, 3);
                $pendingorderscountpercent = format_num($pendingorderscountpercent, 3);


            }

            //dd($user, $smsoutboxes);

            return view('_admin.home', compact('smsoutboxes', 'user', 'users', 'orders', 'offers', 'establishmentscount',
                                        'activeorderscount', 'pendingorderscount', 'completedorderscount', 'activeorderscountpercent',
                                        'pendingorderscountpercent'));

        } else {

            abort(503);

        }

    }

}
