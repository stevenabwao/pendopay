<?php
namespace App\Http\Controllers\Api\MpesaPaybills;

use App\Http\Controllers\BaseController;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Session;

class ApiMpesaPaybillsController extends BaseController
{

    /**
     * Display the main company paybill.
     */
    public function getMainPaybill($company_id)
    {

        //get the data
        $result = getMainSingleCompanyPaybill($company_id);
        $result = json_decode($result);
        //dd($result->data);

        return show_success($result->data);

    }

}
