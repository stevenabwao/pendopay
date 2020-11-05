<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //
    public function index()
    {  
        return view('_web.my-transactions');
    }
    public function create()
    {  
        return view('_web.new-transaction');
    }
}
