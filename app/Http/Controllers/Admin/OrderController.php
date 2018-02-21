<?php

namespace App\Http\Controllers\Admin;

use App\Classes\OrderFunctions;
use App\Http\Controllers\Controller;
use App\Order;
use App\Provision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    private $orderFunctions;

    public function __construct(OrderFunctions $orderFunctions)
    {
        $this->middleware('auth:admin');
        $this->orderFunctions = $orderFunctions;
    }

    public function showOrders(){
        $orders = Order::paginate(10);
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

        $order->save();

        Session::flash('success', "Order $order->id successfully updated");

        return redirect('admin/orders');
    }

    public function updateOrderSuccess($id){
        $order = Order::find($id);

        $order->success = (!$order->success);

        $order->save();

        Session::flash('success', "Order $order->id successfully updated");

        return redirect('admin/orders');
    }

    public function deleteOrder($id){
        $order = Order::find($id);

        $order->destroy($id);

        Session::flash('success', "$order->id successfully deleted");

        return redirect('admin/orders');
    }
}
