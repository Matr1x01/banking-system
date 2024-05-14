<?php

namespace App\Services;

use App\Enum\UserType;
use App\Jobs\TransactionJob;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
class TransactionService
{
    public function __construct(public TransactionJob $transactionJob)
    { 
    }

    public function index()
    {
        $user=auth()->user();
        return [
            'balance' => $user->balance,
            'transactions' => $user->transactions
        ];
    }

    public function transactionJob()
    {
        // Perform any necessary initialization or setup for the transaction job
    }

    public function getDeposits()
    {
        $deposit = $this->transactionJob->getUserDeposits(auth()->user()->id);
        return [
            'deposit_transactions'=>$deposit
        ];
    }

    public function deposit($user_id,$amount){
        $user=$this->transactionJob->getUserById($user_id);
        $this->transactionJob->insertDeposit($user_id,$amount);
        $balance=$user->balance+$amount;
        $this->transactionJob->updateUserBalance($user_id,$balance);

        return [
            'balance'=>$balance
        ];
    }
 
    public function getWithdrawls()
    {
        $withdrawls = $this->transactionJob->getUserWithdrawls(auth()->user()->id);
        return [
            'withdrawl_transactions'=>$withdrawls
        ];
    }

    public function withdraw($user_id, $amount)
{
    $user = $this->transactionJob->getUserById($user_id);
    $today = Carbon::now();  
    $dayOfWeek = $today->format('l');  

    if ($user->balance < $amount) {
        return [
            'message' => 'Insufficient balance',
            'status' => Response::HTTP_BAD_REQUEST,
            'data' => ['balance' => $user->balance]
        ];
    }

    $withdrawalRate = 0; 
    $freeWithdrawalLimit = 1000;
    $monthlyFreeLimit = 5000;
    $monthlyWithdrawnAmount = $this->transactionJob->getMonthlyWithdrawnAmount($user_id);

    if ($user->account_type == UserType::INDIVIDUAL){
        $withdrawalRate=0.015;
    }else if ($user->account_type == UserType::BUSINESS){
        $totalWithdrawnAmount = $this->transactionJob->getTotalWithdrawnAmount($user_id);
        if ($totalWithdrawnAmount > 50000) {
            $withdrawalRate = 0.015; 
        } else {
            $withdrawalRate = 0.025;
        }
    }
    if ($dayOfWeek == 'Friday') {
        $withdrawalRate = 0;
    }
    if ($monthlyWithdrawnAmount < $monthlyFreeLimit) {
        $withdrawalRate = 0;
    }

    $deduction = $amount > $freeWithdrawalLimit ? $amount + ($withdrawalRate * ($amount - $freeWithdrawalLimit)) : $amount;  

    if ($user->balance < $deduction) {
        return [
            'message' => 'Insufficient balance after applying withdrawal rate',
            'status' => Response::HTTP_BAD_REQUEST,
            'data' => ['balance' => $user->balance]
        ];
    }

    $balance = $user->balance - $deduction;
    $this->transactionJob->updateUserBalance($user_id, $balance);
    $this->transactionJob->insertWithdrawal($user_id, $amount);

    return [
        'balance' => $balance
    ];
}

}