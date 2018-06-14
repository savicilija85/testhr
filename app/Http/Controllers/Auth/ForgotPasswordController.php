<?php

namespace App\Http\Controllers\Auth;

use App\Classes\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function sendResetLinkResponse()
    {
        return response()->json(JsonResponse::response('200', [], 'success'), 200);
    }


    protected function sendResetLinkFailedResponse()
    {
        return response()->json(JsonResponse::response('500', [], 'error'), 200);
    }


    public function sendResetLinkEmail(Request $request)
    {
        $messages = [
            'required' => 'Polje :attribute je obavezno',
            'email' => 'Neispravan format e-mail adrese',
            'exists' => 'E-mail ne postoji'
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], $messages);

        if($validator->fails()){
            $errors = $validator->errors();
            return response()->json(JsonResponse::response('400',[] , $errors->first()), 400);
        }

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse()
            : $this->sendResetLinkFailedResponse();
    }
}
