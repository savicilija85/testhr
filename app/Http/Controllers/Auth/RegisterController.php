<?php

namespace App\Http\Controllers\Auth;

use App\Classes\JsonResponse;
use App\Rules\CryptedVerificationCodeValidation;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use Twilio;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    private $request;

    /**
     * RegisterController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest');
        $this->request = $request;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'required' => 'Polje :attribute je obavezno',
            'string' => 'Polje :attribute mora biti reč',
            'max' => 'Polje :attribute mora biti maksimalno :max karaktera',
            'unique' => 'Korisničko ime ili e-mail već postoji',
            'email' => 'Neispravan format e-mail adrese',
            'regex' => 'Neispravan format telefona, molimo unesite telefon u sledećem formatu: +38160123456 ili +381601234567',
            'min' => 'Polje :attribute mora biti minimalno :max karaktera',
            'confirmed' => 'Ponovljena šifra je neispravna',
            'digits' => 'Polje za bankovni račun mora da ima :digits cifara'

        ];
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|regex:/[\+]\d{3}\d{2}\d{6}\d?/',
            'password' => 'required|string|min:6|confirmed',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => bcrypt($data['password']),
            ]);

        return $user;
    }

    /**Get request data
     * @return array
     */
    private function getRequestData(){

        return $this->request->all();
    }

    /**
     * @param $data
     * @return int
     */
    private function sendVerificationCodeSms($phone){
        $verification_code = $this->generateRandomNumber();
        $message = 'Your verification code is: ' . $verification_code;
        try {
            Twilio::message($phone, $message);

            return $verification_code;
        } catch (Exception $e){
            return response()->json(JsonResponse::response('500', [], $e->getMessage()));
        }
    }

    /**
     * @return int
     */
    private function generateRandomNumber(){
        $verification_code = random_int(10000, 99999);

        return $verification_code;
    }

    public function registerUser(Request $request){
            if ($this->checkVerificationCode()) {
                try {

                    event(new Registered($user = $this->create($request->all())));
                    $this->guard()->login($user);
                    $this->registered($this->request, $user);
                    $data = [
                      'username' => $request->username,
                      'email' => $request->email,
                      'password' => $request->password,
                      'name' => $request->name,
                    ];

                    Mail::send('emails.send_user_credentials', $data, function ($message) use ($data) {
                        $message->from('cryptoplushr@gmail.com');
                        $message->to($data['email']);
                        $message->subject('Korisnički podaci -- Crypto Plus Exchange');
                    });


                } catch (QueryException $e){

                    $errorCode = $e->errorInfo[1];
                    if($errorCode == 1062){

                        return response()->json(JsonResponse::response('500', [], "Username or E-mail already exists"), 500);

                    }

                    return response()->json(JsonResponse::response('500', [], "Query error"), 500);

                } catch (\Exception $e) {

                    return response()->json(JsonResponse::response('500', [], $e->getMessage()), 500);
                }

                return response()->json(JsonResponse::response('200', [], 'User successfully added to database'), 200);

            } else {

                return response()->json(JsonResponse::response('400', [], 'Verification code error'), 400);

            }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showVerificationCodePage(Request $request){
        $validator = $this->validator($request->all());

        if($validator->fails()){
            $errors = $validator->errors();
            return response()->json(JsonResponse::response('400', [], $errors->first()), 400);
        }

        $verification_code = $this->sendVerificationCodeSms($request->phone);
        $data['verification_code'] = bcrypt($verification_code);

        return response()->json(JsonResponse::response('200', $data, 'success'));

    }


    public function checkVerificationCode(){
        $data = $this->getRequestData();
        $validator = Validator::make($data,[
            'user_verification_code' => ['required','digits:5', new CryptedVerificationCodeValidation($data)],
        ]);
        if($validator->fails()){
            return false;
        }

        return true;
    }

    /**
     * Resending verification code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resendVerificationCode(){
        $data = $this->getRequestData();
        $data = $this->sendVerificationCodeSms($data);

        return view('auth.smsVerify', compact('data'));
    }

    /** Add id card pictures
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function idPictures(){
        $data = $this->request->all();
        $validator = Validator::make($data,[
            'id_card_image_front' => 'required|mimes:jpg,jpeg,JPG,JPEG,png,PNG',
            'id_card_image_back' => 'required|mimes:jpg,jpeg,JPG,JPEG,png,PNG',
        ]);
        if($validator->fails()){
            return view('auth.idPictures', compact('data'))->withErrors($validator);
        }

        $idCardImageFront = $this->request->file('id_card_image_front');
        $idCardImageFrontFilename = $data['username'] . '-front-' . time() . '.' . $idCardImageFront->getClientOriginalExtension();
        $idCardImageFrontPath = 'uploads/id_cards/'. $data['username'] . '/';
        Storage::disk('ftp')->putFileAs($idCardImageFrontPath, $idCardImageFront, $idCardImageFrontFilename);


        $idCardImageBack = $this->request->file('id_card_image_back');
        $idCardImageBackFilename = $data['username'] . '-back-' . time() . '.' . $idCardImageBack->getClientOriginalExtension();
        $idCardImageBackPath = 'uploads/id_cards/'. $data['username'] . '/';
        Storage::disk('ftp')->putFileAs($idCardImageBackPath, $idCardImageBack, $idCardImageBackFilename);


        $data['id_card_image_front'] = $idCardImageFrontPath . $idCardImageFrontFilename;
        $data['id_card_image_back'] = $idCardImageBackPath . $idCardImageBackFilename;

        event(new Registered($user = $this->create($data)));

        $this->guard()->login($user);

        return $this->registered($this->request, $user)
            ?: redirect($this->redirectPath());
    }

}
