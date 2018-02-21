<?php

namespace App\Classes;


use App\User;

class ZeroesOnAccountNumber
{
    //Method for adding zeroes on large account number
    private function addZeroes($data){
        $zero = "0";
        $len = 13 - strlen($data);
        $zero = str_repeat($zero, $len);
        $addedZeroes = $zero . $data;

        return $addedZeroes;
    }

    //Method return string array of concat account numbers
    public function concatAccountNumbers(array $accountSmall, array $accountLarge, array $accountMini){
        $concatArray = [];
        for($i = 0; $i < sizeof($accountSmall); $i++){
            $addedZeroesAccountLarge = $this->addZeroes($accountLarge[$i]);
            $concatArray[$i] = $accountSmall[$i] . $addedZeroesAccountLarge . $accountMini[$i];
        }
        return $concatArray;
    }

    public function getAccountsWithDash($id){
        $user = User::find($id);

        $accounts = $user->accounts;
        $accountArray = [];

        foreach($accounts as $account){
            $accountStringArray = str_split($account->account_no);
            $accountString = '';
            for($i = 0; $i < count($accountStringArray); $i++){
                if($i == 2){
                    $accountString = $accountString . $accountStringArray[$i] . '-';
                } elseif ($i == 15){
                    $accountString = $accountString . $accountStringArray[$i] . '-';
                } else {
                    $accountString = $accountString . $accountStringArray[$i];
                }
            }
            $accountArray[] = $accountString;
        }

        return $accountArray;
    }
}