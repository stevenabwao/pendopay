<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //
    public function index(){
        $title = 'welcome to my transactions';
        // return view('pages.index', compact('title','subTitle'));
        return view('_web.my-transactions') -> with('title', $title);
    }
}
