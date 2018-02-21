<?php
/**
 * Created by PhpStorm.
 * User: webup07
 * Date: 18.1.18.
 * Time: 10.43
 */

namespace App\Classes;


class OrderFunctions
{
    public function calculateProvision($sum, $provision, $currency, $buy_sell){
        if($buy_sell == 'Kupovina'){
            $buy_sell = 'buy';
        } else {
            $buy_sell = 'sell';
        }

        $provision = $sum * ($provision->{$currency/*->short_name*/ . $buy_sell} / 100);

        return $provision;
    }

    public function calculatePdv($provision){
        $pdv = ($provision * 20) / 120;
        return $pdv;
    }

    public function calculateProvisionForAdminPanel($sum, $provision, $currency, $buy_sell){
        if($buy_sell == 'Kupovina'){
            $buy_sell = 'buy';
        } else {
            $buy_sell = 'sell';
        }

        $provision = $sum * ($provision->{$currency . $buy_sell} / 100);

        return $provision;
    }
}