<?php
 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/users',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::group([
    // 'middleware' => ['auth:sanctum']
],function(){ 
    Route::get('/logout',[AuthController::class,'logout']);
    Route::get('/',[TransactionController::class,'index']);
    Route::get('/deposit',[TransactionController::class,'getDeposits']);
    Route::post('/deposit',[TransactionController::class,'deposits']);
    Route::get('/withdrawls',[TransactionController::class,'getWithdrawls']);
    Route::post('/withdrawls',[TransactionController::class,'withdrawls']);
});
