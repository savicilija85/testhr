<?php

namespace App\Http\Controllers;

use App\Classes\JsonResponse;
use App\Classes\OrderFunctions;
use App\Classes\ZeroesOnAccountNumber;
use App\CryptoCurrency;
use App\User;
use App\Http\Controllers\Auth\LoginController;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BuySellController extends Controller
{
    private $orderFunctions;
    private $authenticateUser;
    private $zeroesOnAccountNumber;

    public function __construct(OrderFunctions $orderFunctions, LoginController $authenticateUser, ZeroesOnAccountNumber $zeroesOnAccountNumber)
    {
        //$this->middleware('auth');
        $this->middleware('auth.jwt');
        $this->orderFunctions = $orderFunctions;
        $this->authenticateUser = $authenticateUser;
        $this->zeroesOnAccountNumber = $zeroesOnAccountNumber;
    }

    public function showBuySell(){
        $currency = CryptoCurrency::get()->pluck('short_name','id');
        return view('user.buysell', compact('currency'));
    }


    /** User data for buy transaction
     * @param array $requestData
     * @param array $user
     * @return array
     */
    private function buyData($requestData = [], $user = []){
        $data = [
            'name' => $user['data'][0]['user']['name'],
            'email' => $user['data'][0]['user']['email'],
            'phone' => $user['data'][0]['user']['phone'],
            'address' => $requestData['address'],
            'buy_sell' => $requestData['buy_sell'],
            'quantity' => $requestData['quantity'],
            'currency' => $requestData['currency'],
            'outputCurrencyAmount' => $requestData['outputCurrencyAmount'],
            'walletAddress' => $requestData['walletAddress'],
        ];

        return $data;
    }

    /** Validation for buy transaction
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    private function buyValidator($data = []){

        $validator = Validator::make($data, [
            'address' => 'required|string',
            'quantity' => 'required|numeric',
            'currency' => 'required|string',
            'outputCurrencyAmount' => 'required|numeric',
            'walletAddress' => 'required|string'
        ]);

        return $validator;
    }

    /** Sending emails for buy transaction
     * @param array $data
     */
    private function buySendEmails($data = []){
        Mail::send('emails.buy_company', $data, function ($message) use ($data) {
            $message->from('cryptoplusrs@gmail.com');
            $message->to('cryptoplusrs@gmail.com');
            $message->subject($data['buy_sell'] . ' ' . $data['name']);
        });

        Mail::send('emails.buy_user', $data, function($message) use ($data){
            $message->from('cryptoplusrs@gmail.com');
            $message->to($data['email']);
            $message->subject('Crypto Plus - Detalji kupovine');
        });
    }

    /** User data for sell transaction
     * @param array $requestData
     * @param array $user
     * @return array|\Illuminate\Http\JsonResponse
     */
    private function sellData($requestData = [], $user = []){
        try {

            $wallet['wallet'] = Wallet::where('currency', $requestData['currency'])->value('wallet');
            $wallet['destination_tag'] = Wallet::where('currency', $requestData['currency'])->value('destination_tag');

        } catch (\Exception $e){

            return response()->json(JsonResponse::response('error', [], $e->getMessage()), 500);
        }

        $data = [
            'name' => $user['data'][0]['user']['name'],
            'email' => $user['data'][0]['user']['email'],
            'phone' => $user['data'][0]['user']['phone'],
            'address' => $requestData['address'],
            'buy_sell' => $requestData['buy_sell'],
            'quantity' => $requestData['quantity'],
            'currency' => $requestData['currency'],
            'outputCurrencyAmount' => $requestData['outputCurrencyAmount'],
            'bankAccount' => $requestData['bankAccount'],
            'wallet' => $wallet['wallet'],
            'destination_tag' => $wallet['destination_tag'],
        ];

        return $data;
    }

    /** Validation for sell transaction
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    private function sellValidator($data = []){
        $validator = Validator::make($data, [
            'address' => 'required|string',
            'quantity' => 'required|numeric',
            'currency' => 'required|string',
            'outputCurrencyAmount' => 'required|numeric',
            //'bankAccount' => 'required|regex:/\d{3}[\-]\d{13}[\-]\d{2}/'
        ]);

        return $validator;
    }

    /** Sending emails for sell transaction
     * @param array $data
     */
    private function sellSendEmails($data = []){
        Mail::send('emails.sell_company', $data, function($message) use ($data){
            $message->from('cryptoplusrs@gmail.com');
            $message->to('cryptoplusrs@gmail.com');
            $message->subject($data['buy_sell'] . ' ' . $data['name']);
        });

        Mail::send('emails.sell_user', $data, function($message) use ($data){
            $message->from('cryptoplusrs@gmail.com');
            $message->to($data['email']);
            $message->subject('Crypto Plus - Detalji prodaje');
        });
    }

    /** Saving orders to database and sending mails to users and company
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveOrderTest(Request $request){
        $user = $this->authenticateUser->getAuthenticatedUser();
        $user = $user->getData(true);
        $validationData = $request->all();
        if($request->buy_sell == 'Kupovina') {

            $validator = $this->buyValidator($validationData);

            if($validator->fails()){
                $errors = $validator->errors();
                return response()->json(JsonResponse::response('400',[] , $errors->first()), 400);
            }

            $data = $this->buyData($validationData, $user);

            $this->buySendEmails($data);

            return response()->json(JsonResponse::response('success', [], 'Order successful'), 200);

        } else if($request->buy_sell == 'Prodaja'){

            $validator = $this->sellValidator($validationData);

            if($validator->fails()){
                $errors = $validator->errors();
                return response()->json(JsonResponse::response('400',[] , $errors->first()), 400);
            }

            $data = $this->sellData($validationData, $user);

            $this->sellSendEmails($data);

            return response()->json(JsonResponse::response('success', ['wallet' => ['wallet' => $data['wallet'], 'destination_tag' => $data['destination_tag']]], 'Order successful'), 200);
        }

        return response()->json(JsonResponse::response('invalidrequest', [], 'Invalid request'), 400);
    }


    /** Getting authenticated user accounts in format 123-1234567890123-12
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAccounts(){
        $user = $this->authenticateUser->getAuthenticatedUser();
        $user = $user->getData(true);
        $data = $this->zeroesOnAccountNumber->getAccountsWithDash($user['data'][0]['user']['id']);

        return response()->json(JsonResponse::response('success', $data, 'The accounts have been successfully submitted'), 200);

    }

    /** Getting name of authenticated user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getName(){
        $user = $this->authenticateUser->getAuthenticatedUser();
        $user = $user->getData(true);
        $data['name'] = $user['data'][0]['user']['name'];

        return response()->json(JsonResponse::response('success', $data, 'User name have been successfully submitted'), 200);
    }



    /*public function saveOrder(Request $request){
        $order = new Order();
        $data = $request->all();
        //$user = Auth::user();
        $user = $this->authenticateUser->getAuthenticatedUser();
        $user = $user->getData(true);
        //dd($user);
        $currency = $data['currency'];
        if($currency == 'BTC'){
            $currency = 'XXBT';
        } else {//if($currency[0] == 'X') {
            $currency = 'X' . $currency;//[substr($currency, 1)];
        }

        $provision = Provision::find(1);

        $order->user_id = $user['data'][0]['user']['id'];
        $order->buy_sell = $data['buy_sell'];
        $order->quantity = $data['quantity'];
        $order->currency = $currency;
        $order->sum = $data['quantity'] * 100; //Umesto 100 bice cena kriptovalute
        $order->provision = $this->orderFunctions->calculateProvision($order->sum,$provision,$currency,$order->buy_sell);
        $order->pdv = $this->orderFunctions->calculatePdv($order->provision);
        $order->amount = $order->sum - $order->provision;
        $order->success = false;

        $order->save();

        return response()->json(JsonResponse::response('success', [], 'Order successfull'),200);
    }*/
}
