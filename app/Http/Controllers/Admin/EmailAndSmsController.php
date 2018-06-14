<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use Twilio;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class EmailAndSmsController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'admin/email_sms';

    /**
     * Create a new controller instance.
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showEmailSms(){
        return view('admin.email_sms');
    }

    public function sendEmail(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required:email',
            'title' => 'required:string',
            'body' => 'required:string'
            ]);

        if($validator->fails()){
            $errors = $validator->errors();
            Session::flash('error', $errors->first());
            return redirect('admin/email_sms');
        }

        try {
            $data = [
                'email' => $request->email,
                'title' => $request->title,
                'body' => $request->bodyAdded ,
            ];

            Mail::send('emails.send_custom_email', $data, function ($message) use ($data) {
                $message->from('cryptoplushr@gmail.com');
                $message->to($data['email']);
                $message->subject($data['title']);
            });

            Session::flash('success', 'Email je uspešno poslan');

            return redirect('admin/email_sms');
        } catch (\Exception $e){
            Session::flash('error', 'Greška prilikom slanja e-maila: ' .$e->getMessage());

            return redirect('admin/email_sms');
        }
    }

    public function sendSms(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/[\+]\d{3}\d{2}\d{6}\d?/',
            'message' => 'required|string'
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            Session::flash('error', $errors->first());
            return redirect('admin/email_sms');
        }

        try{
            Twilio::message($request->phone, $request->message);
            Session::flash('success', 'SMS je uspešno poslan');

            return redirect('admin/email_sms');
        } catch (\Exception $e){
            Session::flash('error', 'Greška prilikom slanja SMS-a: ' . $e->getMessage());

            return redirect('admin/email_sms');
        }
    }
}
