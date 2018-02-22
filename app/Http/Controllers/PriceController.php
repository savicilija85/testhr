<?php

namespace App\Http\Controllers;

use App\Classes\JsonResponse;
use App\CryptoCurrency;
use Illuminate\Http\Request;
use Payward\KrakenAPI;
use Payward\KrakenAPIException;

class PriceController extends Controller
{
    private static $api_id = '7cb91d1355cd7b0af4597f7062572b4c';

    private function getShortNameCurrencies(){
        $currencies = CryptoCurrency::all();
        $shortNames = "";
        $i = 0;
        $len = count($currencies);
        foreach($currencies as $currency){
            if($i == $len-1) {
                if($currency->short_name[0] == 'X') {
                    $shortNames = $shortNames . substr($currency->short_name, 1) . "EUR";
                } else {
                    $shortNames = $shortNames . $currency->short_name . "EUR";
                }
                } else {

                if($currency->short_name[0] == 'X') {
                    $shortNames = $shortNames . substr($currency->short_name, 1) . "EUR" . ",";
                } else {
                    $shortNames = $shortNames . $currency->short_name . "EUR" . ",";
                }
            }
            $i++;
        }
        return $shortNames;
    }

    private function resultCurrencyString(){
        $currencies = CryptoCurrency::all();
        $shortNames = "";
        $i = 0;
        $len = count($currencies);
        foreach($currencies as $currency){
            if($i == $len-1) {
                $shortNames = $shortNames .  $currency->short_name;
            } else {
                $shortNames = $shortNames . $currency->short_name . ",";
            }
            $i++;
        }
        $string = explode(',', $shortNames);
        return $string;
    }

    public function getPrice(){
        try {
            $kraken = new KrakenAPI(null, null);

            $priceEur = $kraken->QueryPublic('Ticker', ['pair' => $this->getShortNameCurrencies()/*'XRPEUR,ETHEUR,XBTEUR,LTCEUR'*/]);

        } catch (KrakenAPIException $e){

            return response()->json(JsonResponse::response('503', [], $e->getMessage()));

        }

        $url = 'https://api.kursna-lista.info/'.self::$api_id.'/kursna_lista/json';
        $content = file_get_contents($url);

        $data = json_decode($content, true);
        $eur = $data['result']['eur']['sre'];
        //Ovde umesto 0.05 uvesti proviziju iz baze za odredjenu kriptovalutu
        foreach ($this->resultCurrencyString() as $currency){
            if($currency == 'XXBT'){
                $currencies = CryptoCurrency::where('short_name', $currency)->first();
                $resRsd['sell']['BTC']['price'] = $eur * ($priceEur['result'][$currency . 'ZEUR']['c'][0] * 0.95);
                $resRsd['sell']['BTC']['name'] = $currencies->name;
                $resRsd['sell']['BTC']['min'] = $currencies->min_sell;
                $resRsd['buy']['BTC']['price'] = $eur * ($priceEur['result'][$currency . 'ZEUR']['c'][0] * 1.05);
                $resRsd['buy']['BTC']['name'] = $currencies->name;
                $resRsd['buy']['BTC']['min'] = $currencies->min_buy;
            } elseif($currency[0] == 'X') {
                $currencies = CryptoCurrency::where('short_name', $currency)->first();
                $resRsd['sell'][substr($currency, 1)]['price'] = $eur * ($priceEur['result'][$currency . 'ZEUR']['c'][0] * 0.95);
                $resRsd['sell'][substr($currency, 1)]['name'] = $currencies->name;
                $resRsd['sell'][substr($currency, 1)]['min'] = $currencies->min_sell;
                $resRsd['buy'][substr($currency, 1)]['price'] = $eur * ($priceEur['result'][$currency . 'ZEUR']['c'][0] * 1.05);
                $resRsd['buy'][substr($currency, 1)]['name'] = $currencies->name;
                $resRsd['buy'][substr($currency, 1)]['min'] = $currencies->min_buy;
            } else {
                $currencies = CryptoCurrency::where('short_name', $currency)->first();
                $resRsd['sell'][$currency]['price'] = $eur * ($priceEur['result'][$currency . 'EUR']['c'][0] * 0.95);
                $resRsd['sell'][$currency]['name'] = $currencies->name;
                $resRsd['sell'][$currency]['min'] = $currencies->min_sell;
                $resRsd['buy'][$currency]['price'] = $eur * ($priceEur['result'][$currency . 'EUR']['c'][0] * 1.05);
                $resRsd['buy'][$currency]['name'] = $currencies->name;
                $resRsd['buy'][$currency]['min'] = $currencies->min_buy;
            }
        }

        return response()->json(JsonResponse::response('200',$resRsd,'success'));
    }

    public function showPrice(){
        return view('index');
    }
}
