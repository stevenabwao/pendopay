<?php

namespace App\Http\Controllers\Web\TransferFund;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransferFundController extends Controller
{
    //

    public function create()
    {
        return view('_web.transfer.create');
    }
}
