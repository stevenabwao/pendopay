<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;


class BaseController extends Controller
{

    use ValidatesRequests;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            // dd("constructor == ", $this->user);

            return $next($request);
        });
    }
    */
    public function success($message)
    {
        return [
            'status_code' => 200,
            'message' => $message
        ];
    }

}
