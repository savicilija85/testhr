<?php

namespace App\Http\Controllers\Admin;

use App\CryptoCurrency;
use App\Http\Controllers\Controller;
use App\Provision;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Payward\KrakenAPI;

class CryptoCurrencyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showCurrencies(){
        $kraken = new KrakenAPI(null, null);

        $priceEur = $kraken->QueryPublic('Assets');
        $currencies = CryptoCurrency::all();
        $cryptoCurrencies = $priceEur['result'];

        return view('admin.currencies', compact('currencies','cryptoCurrencies'));
    }

    public function createCryptoCurrency(Request $request){

        $currency = new CryptoCurrency();
        $kraken = new KrakenAPI(null, null);

        $currency->name = $request->name;
        $currency->short_name = $request->short_name;

        $priceEur = $kraken->QueryPublic('Assets');

        $currencies = array_keys($priceEur['result']);

        if(in_array($request->short_name, $currencies)) {

            Schema::table('provisions', function (Blueprint $table) use ($request) {
                $table->double($request->short_name . 'buy', 5, 2)->default('0.00');
                $table->double($request->short_name . 'sell', 5, 2)->default('0.00');
            });

            $currency->save();

            Session::flash('success', 'Successfully added new crypto currency');

            return \Redirect::to('admin/currencies');

        } else {

            Session::flash('error', 'Currency does not exists');
            return \Redirect::to('admin/currencies');

        }
    }

    public function deleteCryptoCurrency($id){

        $currency = CryptoCurrency::find($id);

        Schema::table('provisions', function (Blueprint $table) use ($currency) {
            $table->dropColumn([$currency->short_name . 'buy', $currency->short_name . 'sell']);
        });

        $currency->destroy($id);

        Session::flash('success', "Successfully deleted $currency->name crypto currency");

        return \Redirect::to('admin/currencies');
    }
}
