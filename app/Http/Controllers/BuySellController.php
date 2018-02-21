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

    public function saveOrderTest(Request $request){
        $user = $this->authenticateUser->getAuthenticatedUser();
        $user = $user->getData(true);

        if($request->buy_sell == 'Kupovina') {

            $validator = Validator::make($request->all(), [
               'address' => 'required|string',
               'quantity' => 'required|numeric',
               'currency' => 'required|string',
               'outputCurrencyAmount' => 'required|numeric',
               'walletAddress' => 'required|string'
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                return response()->json(JsonResponse::response('400', $validator->messages(), $errors->first()/*'Validation error'*/), 400);
            }

            $data = [
                'name' => $user['data'][0]['user']['name'],
                'email' => $user['data'][0]['user']['email'],
                'phone' => $user['data'][0]['user']['phone'],
                'address' => $request->address,
                'buy_sell' => 'Kupnja',
                'quantity' => $request->quantity,
                'currency' => $request->currency,
                'outputCurrencyAmount' => $request->outputCurrencyAmount,
                'walletAddress' => $request->walletAddress
            ];

            Mail::send('emails.buy_company', $data, function ($message) use ($data, $request, $user) {
                $message->from('cryptoplushr@gmail.com');
                $message->to('cryptoplushr@gmail.com');
                $message->subject($request->buy_sell . ' ' . $user['data'][0]['user']['name']);
            });

            Mail::send('emails.buy_user', $data, function($message) use ($data, $request, $user){
               $message->from('cryptoplushr@gmail.com');
               $message->to($data['email']);
               $message->subject('Crypto Plus - Detalji kupnje');
            });

            return response()->json(JsonResponse::response('success', [], 'Order successful'), 200);

        } else if($request->buy_sell == 'Prodaja'){

            $validator = Validator::make($request->all(), [
                'address' => 'required|string',
                'quantity' => 'required|numeric',
                'currency' => 'required|string',
                'outputCurrencyAmount' => 'required|numeric',
                'bankAccount' => 'required'
            ]);

            if($validator->fails()){
                $errors = $validator->errors();
                return response()->json(JsonResponse::response('400', $validator->messages(), $errors->first()/*'Validation error'*/), 400);
            }

            try {

                $wallet['wallet'] = Wallet::where('currency', $request->currency)->value('wallet');
                $wallet['destination_tag'] = Wallet::where('currency', $request->currency)->value('destination_tag');

            } catch (\Exception $e){

                return response()->json(JsonResponse::response('error', [], $e->getMessage()), 500);
            }

            $data = [
                'name' => $user['data'][0]['user']['name'],
                'email' => $user['data'][0]['user']['email'],
                'phone' => $user['data'][0]['user']['phone'],
                'address' => $request->address,
                'buy_sell' => $request->buy_sell,
                'quantity' => $request->quantity,
                'currency' => $request->currency,
                'outputCurrencyAmount' => $request->outputCurrencyAmount,
                'bankAccount' => $request->bankAccount,
                'wallet' => $wallet['wallet'],
                'destination_tag' => $wallet['destination_tag'],
            ];

            Mail::send('emails.sell_company', $data, function($message) use ($data, $request, $user){
                $message->from('cryptoplushr@gmail.com');
                $message->to('cryptoplushr@gmail.com');
                $message->subject($request->buy_sell . ' ' . $user['data'][0]['user']['name']);
            });

            Mail::send('emails.sell_user', $data, function($message) use ($data, $request, $user){
                $message->from('cryptoplushr@gmail.com');
                $message->to($data['email']);
                $message->subject('Crypto Plus - Detalji prodaje');
            });

            return response()->json(JsonResponse::response('success', ['wallet' => $wallet], 'Order successful'), 200);
        }

        return response()->json(JsonResponse::response('invalidrequest', [], 'Invalid request'), 400);
    }


    /*
     * Method for getting user accounts
     */
    public function getAccounts(){
        $user = $this->authenticateUser->getAuthenticatedUser();
        $user = $user->getData(true);
        $data = $this->zeroesOnAccountNumber->getAccountsWithDash($user['data'][0]['user']['id']);

        return response()->json(JsonResponse::response('success', $data, 'The accounts have been successfully submitted'), 200);

    }
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
