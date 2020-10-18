<?php

namespace App\Http\Controllers;

use App\Entities\Company;
use App\Entities\Group;
use App\Entities\SmsOutbox;
use App\Entities\ScheduleSmsOutbox;
use App\User;
use Session;

use Illuminate\Http\Request;


class ScheduleSmsOutboxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scheduled_smsoutboxes = ScheduleSmsOutbox::orderBy('id', 'desc')->paginate(10);
        //dd($smsoutboxes);
        return view('scheduled-smsoutbox.index', compact('scheduled_smsoutboxes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        //if user is superadmin, show all companies, else show a user's companies
        if ($user->hasRole('superadministrator')){
            $groups = Group::all();
            $users = User::all();
        } else {
            $groups = Group::all();
            $users = User::all();
        }
        return view('smsoutbox.create')
               ->withGroups($groups)
               ->withUsers($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $user_id = auth()->user()->id;

        $this->validate($request, [
            'sms_message' => 'required'
        ]);


        /*$send_sms_link = SEND_BULK_SMS_URL;
        $fields = "usr=" . $usr . "&pass=" . $pass . "&src=" . $src . "&dest=" . $phone_number . "&msg=" . $message; 
        $result = $this->executeLink($send_sms_link, $fields, "post");*/

        $send_bulk_sms_url = "http://localhost:6000/admin/api/v1/sendBulkSMS";

        //$send_bulk_sms_url = \Config::get('constants.bulk_sms.send_sms_url');
        $src = \Config::get('constants.bulk_sms.src');
        $usr = \Config::get('constants.bulk_sms.usr');
        $pass = \Config::get('constants.bulk_sms.pass');

        $usersSelected = explode(',', $request->usersSelected);

        if (count($usersSelected) > 0) {
            foreach ($usersSelected as $x) {
                
                //get the recipient user details
                $user = User::where('id', $x)->first();

                if ($request->sendSmsCheckBox == 'now') {
            
                    //send sms
                    $client = new \GuzzleHttp\Client();

                    $body['usr'] = $usr;
                    $body['pass'] = $pass;
                    $body['src'] = $src;
                    $body['dest'] = $user->phone_number;
                    $body['msg'] = $request->message;

                    $response = $client->request('POST', $send_bulk_sms_url, ['form_params' => $body]);

                    dd($response);

                    //create new outbox
                    $smsoutbox = new SmsOutbox();
                    $smsoutbox->message = $request->sms_message;
                    $smsoutbox->short_message = reducelength($sms_message,100);
                    $smsoutbox->user_id = $x;
                    $smsoutbox->phone_number = $user->phone_number;
                    $smsoutbox->user_agent = getUserAgent();
                    $smsoutbox->src_ip = getIp();
                    $smsoutbox->src_host = getHost();
                    $smsoutbox->created_by = $user_id;
                    $smsoutbox->updated_by = $user_id;
                    $smsoutbox->save();

                    Session::flash('success', 'SMS successfully sent');
                    return redirect()->route('smsoutbox.index');

                } else {
                    
                    //create new scheduled sms outbox
                    $schedulesmsoutbox = new ScheduleSmsOutbox();
                    $schedulesmsoutbox->message = $request->sms_message;
                    $schedulesmsoutbox->user_id = $x;
                    $schedulesmsoutbox->phone_number = $user->phone_number;
                    $schedulesmsoutbox->user_agent = getUserAgent();
                    $schedulesmsoutbox->src_ip = getIp();
                    $schedulesmsoutbox->src_host = getHost();
                    $schedulesmsoutbox->created_by = $user_id;
                    $schedulesmsoutbox->updated_by = $user_id;
                    $schedulesmsoutbox->save();

                    Session::flash('success', 'SMS successfully scheduled');
                    return redirect()->route('scheduled-smsoutbox.index');

                }

            } 
        
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        //get details for this smsoutbox
        $smsoutbox = SmsOutbox::where('id', $id)
                 ->with('company')
                 ->first();
        
        return view('smsoutbox.show', compact('smsoutbox'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $group = Group::where('id', $id)
                 ->with('company')
                 ->first();

        $user = auth()->user();
        //if user is superadmin, show all companies, else show a user's companies
        if ($user->hasRole('superadministrator')){
            $companies = Company::all();
        } else {
            $companies = $user->company;
        }
        
        return view('smsoutbox.edit')->withGroup($group)->withCompanies($companies);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $user_id = auth()->user()->id;

        $this->validate($request, [
            'name' => 'required|max:255',
            'phone_number' => 'required|max:255',
            'company_id' => 'required|max:255'
        ]);

        $group = Group::findOrFail($id);
        $group->name = $request->name;
        $group->company_id = $request->company_id;
        $group->phone_number = $request->phone_number;
        $group->email = $request->email;
        $group->physical_address = $request->physical_address;
        $group->box = $request->box;
        $group->updated_by = $user_id;
        $group->save();

        Session::flash('success', 'Successfully updated group - ' . $group->name);
        return redirect()->route('smsoutbox.show', $group->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
