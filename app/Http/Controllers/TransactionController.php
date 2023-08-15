<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{


    public function createDeposit()  {
        return view('create-deposit');
    }



    public function deposit(Request $request) {

        $request->validate([
            'amount'=>'required',
        ]);
      
        // dd($request);
        $userId = auth()->user()->id;
        $user = User::findOrFail($userId);
        
        $user->balance += $request->amount;
        $user->save();


        Transaction::create([
            'user_id'=>$user->id,
            'transaction_type'=> 'deposit',
            'amount'=>  $request->amount,
            'fee'=> 0,
            'date'=> now(),
        ]);

        return redirect()->back();
    }



    // For withdrawing 

    public function createWithdraw() {
        return view('withdraw');
    }



    public function withdraw(Request $request)  {

        $request->validate([
            'amount'=>'required',
        ]);
        // dd($request);

        $userId = auth()->user()->id;
        $user = User::findOrFail($userId);
        

        if ($user->account_type == 'Individual'){
            $isFriday = now()->dayOfWeek == 5;
            $remaining = $request->amount - 1000;
            $isFirst5K = $user->transactions()->where('transaction_type','withdraw')->whereMonth('created_at', Carbon::now()->month)->sum('amount') + $request->amount <= 5000;

            if($isFriday || $request->amount <= 1000 || $isFirst5K) {
                $withdrawFee = 0;
            }
            else {
                $withdrawFee = $remaining * 0.015;
            }
        
        }
        elseif ( $user->account_type == 'Business')  {
            $total = $user->transactions()->where('transaction_type','withdraw')->sum('amount');
            if ($total +$request->amount >= 50000) {
                $withdrawFee = $request->amount * 0.015;
            }
            else{
                $withdrawFee = $request->amount * 0.025;
            }
        }
        
        $user->balance -= ($request->amount + $withdrawFee);
        $user->save();


        Transaction::create([
            'user_id'=>$user->id,
            'transaction_type'=>'withdraw',
            'amount'=>$request->amount,
            'fee'=>$withdrawFee,
            'date'=>now()
        ]);

        return redirect()->back();
      
        
    }



    public function allTransactions() {

        $allTransactions = Transaction::where('user_id',auth()->user()->id)->get();
        return view('transactions',compact('allTransactions'));
    }




    public function currentBalance()
    {
        $user = auth()->user();
        return view('balance',compact('user'));
    }



    public function depositedTransaction(){
      $depositeTransactions = Transaction::where('user_id',auth()->user()->id)->where('transaction_type','deposit')->get();
      return view('deposit-transactions',compact('depositeTransactions'));
    }


    public function withdrawalTransaction()
    {
        $withdrawalTransaction = Transaction::where('user_id',auth()->user()->id)->where('transaction_type','withdraw')->get();
        return view('withdraw-transactions',compact('withdrawalTransaction'));
    }

}
