<?php

namespace App\Http\Controllers\Api\Sms;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmsController extends BaseController
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * check sms balance
     *
     * @return \Illuminate\Http\Response
     */
    public function getBulkSMSData($username)
    {
        //$query = "SELECT sms_balance FROM broadman.users WHERE username = '$username' and (passwd=md5('$password') OR passwd='$password')";
            
        $data = DB::connection('mysql2')
                ->table('users')
                ->select('*')
                ->where('username', $username)
                ->first();

        dd($data);
            
            /*$response["error"] = false;
            $response["message"] = SUCCESS_MESSAGE;
            $response["balance"] = $balance;
            $response["date"] = $this->adjustDate("Y-m-d H:i:s T: ", time());
            $response["src_ip"] = $this->get_ip(); */
                
            
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
