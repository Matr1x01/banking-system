<?php

namespace App\Http\Controllers;

use App\Helper\JsonResponder;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\WithdrawalRequest;
use App\Services\TransactionService;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    //constructor with TrancactionService
    public function __construct(public TransactionService $transactionService)
    {
    }
    public function index()
    {
        $response = $this->transactionService->index(); 
        return JsonResponder::respond('User transactions retrieved successfully', Response::HTTP_OK, $response);
    }

    public function getDeposits()
    {
        $response = $this->transactionService->getDeposits();
        return JsonResponder::respond('User deposit retrieved successfully', Response::HTTP_OK, $response);
    }

    public function deposit(DepositRequest $request){
        $response=$this->transactionService->deposit($request->user_id,$request->amount);
        return JsonResponder::respond('Deposit successful', Response::HTTP_OK, []);
    }
 
    public function getWithdrawls()
    {
        $response = $this->transactionService->getWithdrawls();
        return JsonResponder::respond('User withdrawls retrieved successfully', Response::HTTP_OK, $response);
    }

    public function withdraw(WithdrawalRequest $request)
    {
        $response = $this->transactionService->withdraw($request->user_id,$request->amount);
        return JsonResponder::respond('Withdraw successful', Response::HTTP_OK, []);
    }
    
}
