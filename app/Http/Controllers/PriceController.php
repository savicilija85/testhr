<?php

namespace App\Http\Controllers;

use App\Classes\JsonResponse;
use Illuminate\Http\Request;
use Payward\KrakenAPI;
use Payward\KrakenAPIException;

class PriceController extends Controller
{
    private static $api_id = '7cb91d1355cd7b0af4597f7062572b4c';

    public function getPrice(){
        try {
            $kraken = new KrakenAPI(null, null);

            $priceEur = $kraken->QueryPublic('Ticker', ['pair' => 'XRPEUR,ETHEUR,XBTEUR,LTCEUR']);
        } catch (KrakenAPIException $e){
            return response()->json(JsonResponse::response('503', [], $e->getMessage()));
        }
        $url = 'https://api.kursna-lista.info/'.self::$api_id.'/konvertor/eur/hrk/1';
        $content = file_get_contents($url);

        $data = json_decode($content, true);
        $eur = $data['result']['value'];

        $resRsd['sell']['BTC'] = $eur * ($priceEur['result']['XXBTZEUR']['c'][0] * 0.96);
        $resRsd['sell']['ETH'] = $eur * ($priceEur['result']['XETHZEUR']['c'][0] * 0.96);
        $resRsd['sell']['LTC'] = $eur * ($priceEur['result']['XLTCZEUR']['c'][0] * 0.95);
        $resRsd['sell']['XRP'] = $eur * ($priceEur['result']['XXRPZEUR']['c'][0] * 0.95);

        $resRsd['buy']['BTC'] = $eur * ($priceEur['result']['XXBTZEUR']['c'][0] * 1.04);
        $resRsd['buy']['ETH'] = $eur * ($priceEur['result']['XETHZEUR']['c'][0] * 1.04);
        $resRsd['buy']['LTC'] = $eur * ($priceEur['result']['XLTCZEUR']['c'][0] * 1.05);
        $resRsd['buy']['XRP'] = $eur * ($priceEur['result']['XXRPZEUR']['c'][0] * 1.05);


        return response()->json(JsonResponse::response('200',$resRsd,'success'));
    }

    public function showPrice(){
        return view('index');
    }
}
