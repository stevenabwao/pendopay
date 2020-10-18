<?php

namespace App\Entities;


use App\Entities\Company;
use App\User;
use Illuminate\Database\Eloquent\Model;

class MpesaIncoming
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'date_stamp', 'trans_type', 'trans_id', 'trans_time', 'orig', 'ip', 'trans_amount', 'biz_no', 'bill_ref', 'invoice_no', 'org_bal', 'trans_id3', 'msisdn', 'first_name', 'middle_name', 'last_name', 'acc_name', 'src_ip', 'src_host', 'raw_payload'
    ];

    /*protected $url = "http://myapi.com/users/"

    protected $id;
    protected $name; */

    /*public function show()
    {
        $data = json_encode(array(
            'id' => $this->id,
            'name' => $this->name,
        ))

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));                       
        curl_setopt($ch, CURLOPT_PUT, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        return true;
    }*/

}
