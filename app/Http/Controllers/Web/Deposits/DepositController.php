<?php

namespace App\Http\Controllers\Web\Deposits;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    //
    public function create()
    {
        return view('_web.deposit.create');
    }
}
