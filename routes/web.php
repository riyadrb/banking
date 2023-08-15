<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



Route::middleware('auth')->group( function(){
    Route::get('/deposit',[TransactionController::class,'createDeposit'])->name('create.deposit');
    Route::post('/deposit',[TransactionController::class,'deposit'])->name('store.deposit');

    Route::get('/withdraw',[TransactionController::class,'createWithdraw'])->name('create.withdraw');
    Route::post('/withdraw',[TransactionController::class,'withdraw'])->name('withdraw');

    Route::get('/all-transactions',[TransactionController::class,'allTransactions'])->name('allTransactions');
    Route::get('/current-balance',[TransactionController::class,'currentBalance'])->name('currentBalance');

    Route::get('/deposited-transactions',[TransactionController::class,'depositedTransaction'])->name('depositedTransaction');
    Route::get('/withdrawal-transactions',[TransactionController::class,'withdrawalTransaction'])->name('withdrawalTransaction');

});
