<?php

namespace App\Http\Controllers\Admin;

use App\Classes\OrderFunctions;
use App\CryptoCurrency;
use App\Http\Controllers\Controller;
use App\Order;
use App\Provision;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use PDF;

class OrderController extends Controller
{
    private $orderFunctions;

    public function __construct(OrderFunctions $orderFunctions)
    {
        $this->middleware('auth:admin');
        $this->orderFunctions = $orderFunctions;
    }

    private function sendSellMailWithPdf($data){
        $pdf = PDF::loadView('pdf.sell_bill', $data);

        Mail::send('emails.sell_user_atachment', $data, function($message) use ($data, $pdf){
            $message->from('cryptoplushr@gmail.com');
            $message->to($data['email']);
            $message->subject('Potvrda prodaje - Crypto Plus DOO');
            $message->attachData($pdf->output(), 'prodaja_'. $data['currency_short_name'].'.pdf');
        });
    }

    private function sellData($order){
        $user = User::find($order->user_id);
        $currency = CryptoCurrency::where('short_name', $order->currency)->first();
        $data = [
            'account_number' => $order->account_number,
            'currency_name' => $currency->name,
            'currency_short_name' => $order->currency,
            'price' => round(($order->sum / $order->quantity), 2),
            'sum' => $order->sum,
            'provision' => $order->provision,
            'amount' => $order->amount,
            'quantity' => $order->quantity,
            'name' => $user->name,
            'address' => $order->address,
            'date' => date("d.m.Y"),
            'email' => $user->email
        ];
        return $data;
    }

    private function sendBuyEmailWithPdf($data){
        $pdf = PDF::loadView('pdf.buy_bill', $data);

        Mail::send('emails.buy_user_atachment', $data, function($message) use ($data, $pdf){
            $message->from('cryptoplushr@gmail.com');
            $message->to($data['email']);
            $message->subject('Potvrda kupovine - Crypto Plus DOO');
            $message->attachData($pdf->output(), 'kupovina_'. $data['currency_short_name'].'.pdf');
        });
    }

    private function buyData($order){
        $user = User::find($order->user_id);
        $currency = CryptoCurrency::where('short_name', $order->currency)->first();
        $data = [
            'account_number' => $order->account_number,
            'currency_name' => $currency->name,
            'currency_short_name' => $order->currency,
            'price' => round($order->sum / $order->quantity, 2),
            'sum' => $order->sum,
            'provision' => $order->provision,
            'amount' => $order->amount,
            'quantity' => $order->quantity,
            'name' => $user->name,
            'address' => $order->address,
            'date' => date("d.m.Y"),
            'email' => $user->email
        ];
        return $data;
    }

    public function showOrders(){
        $orders = Order::orderBy('id', 'desc')->paginate(10);
        return view('admin.orders', compact('orders'));
    }

    public function updateOrder(Request $request, $id){
        $order = Order::find($id);
        $provision = Provision::find(1);

        $order->quantity = $request->quantity;
        $order->sum = $request->sum;
        $order->provision = $this->orderFunctions->calculateProvisionForAdminPanel($order->sum, $provision, $order->currency,$order->buy_sell);
        $order->pdv = $this->orderFunctions->calculatePdv($order->provision);
        $order->amount = $order->sum - $order->provision;
        $order->account_number = $request->account_number;
        $order->save();

        Session::flash('success', "Order $order->id successfully updated");

        return redirect('admin/orders');
    }

    public function updateOrderSuccess($id){
        $order = Order::find($id);
        if($order->buy_sell == 'Prodaja'){
            $data = $this->sellData($order);
            $this->sendSellMailWithPdf($data);

            $order->success = (!$order->success);
            $order->save();
            Session::flash('success', "Order $order->id successfully updated");
        } elseif ($order->buy_sell == 'Kupovina'){
            $data = $this->buyData($order);
            $this->sendBuyEmailWithPdf($data);

            $order->success = (!$order->success);

            $order->save();
            Session::flash('success', "Order $order->id successfully updated");
        }

        return redirect('admin/orders');
    }

    public function deleteOrder($id){
        $order = Order::find($id);

        $order->destroy($id);

        Session::flash('success', "$order->id successfully deleted");

        return redirect('admin/orders');
    }
}
