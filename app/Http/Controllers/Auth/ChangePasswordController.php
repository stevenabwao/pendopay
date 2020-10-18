<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{

    /**** start change password route ****/
    public function changepass()
    {
        $user = auth()->user();
        return view('auth.changepass', compact('user'));
    }

    public function changepassStore()
    {
        return view('auth.changepass');
    }
    /**** end change password route ****/
    


}
