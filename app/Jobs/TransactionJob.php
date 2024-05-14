<?php

namespace App\Jobs;

use App\Enum\TransactionType;
use App\Models\Transactions;
use App\Models\User;

class TransactionJob
{
    public function __construct()
    {
        
    }

    public function getUserDeposits($user_id)
    {
        return Transactions::query()
            ->where('user_id',$user_id)
            ->where('transaction_type',TransactionType::DEPOSIT)
            ->get();
    }

    public function getUserById($user_id){
        return User::query()->where('id',$user_id);
    }

    public function updateUserBalance($user_id,$balance){
        return User::query()
            ->where('id',$user_id)
            ->update(['balance'=>$balance]);
    }
    public function insertDeposit($user_id,$amount){
        return Transactions::query()
            ->insert([
                'user_id'=>$user_id,
                'amount'=>$amount,
                'transaction_type'=>TransactionType::DEPOSIT
            ]);
    }

    public function getUserWithdrawls($user_id)
    {
        return Transactions::query()
            ->where('user_id',$user_id)
            ->where('transaction_type',TransactionType::WITHDRAWAL)
            ->get();
    }

    public function insertWithdrawal($user_id,$amount){
        return Transactions::query()
            ->insert([
                'user_id'=>$user_id,
                'amount'=>$amount,
                'transaction_type'=>TransactionType::WITHDRAWAL
            ]);
    }

    public function getMonthlyWithdrawnAmount($user_id){
        return Transactions::query()
            ->where('user_id',$user_id)
            ->where('transaction_type',TransactionType::WITHDRAWAL)
            ->whereMonth('date',date('m'))
            ->sum('amount');
    }
    
    public function getTotalWithdrawnAmount($user_id){
        return Transactions::query()
            ->where('user_id',$user_id)
            ->where('transaction_type',TransactionType::WITHDRAWAL)
            ->sum('amount');
    }
}