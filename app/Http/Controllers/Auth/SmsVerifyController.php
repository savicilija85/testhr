<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SmsVerifyController extends Controller
{

    /**
     * SmsVerify constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showSmsVerifyPage(){

        return view('auth.smsVerify');

    }
}
