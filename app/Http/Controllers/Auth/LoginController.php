<?php

namespace App\Http\Controllers\Auth;

use App\Classes\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    public function login(Request $request){

        $userData = $request->only('email', 'password');

        $validator = Validator::make($userData,[
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|'
        ]);

        if($validator->fails()){
            return response()->json(JsonResponse::response('invalidrequest', ['validation_errors' => $validator->messages()], 'Validation error'),400);
        }

        try {

            if (!$token = JWTAuth::attempt($userData)) {
                return response()->json(JsonResponse::response('error', [], 'Invalid email or password'), 401);
            }

        } catch (JWTException $e){
            return response()->json(JsonResponse::response('error', [], 'Error creating token'), 401);
        }

        return response()->json(JsonResponse::response('success', ['token' => $token], 'Successfully logged in'), 200);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(JsonResponse::response('error',[],'User not found'), 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(JsonResponse::response('error',[],'Token expired'), $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(JsonResponse::response('error',[],'Token invalid'), $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(JsonResponse::response('error',[],'Token absent'), $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(JsonResponse::response('success',[compact('user')],'User exists'), 200);
    }

public function refresh(){
        return view('index');
    }

}
