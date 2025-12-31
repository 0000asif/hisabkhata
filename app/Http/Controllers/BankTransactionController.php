<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Models\BankTransaction;
use App\Http\Controllers\Controller;

class BankTransactionController extends Controller
{
    
     public function create()
    {
        $accounts = BankAccount::where('status', 1)->get();
        return view('admin.bank.transaction.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_account_id' => 'required',
            'type' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required',
        ]);

        BankTransaction::create([
            'bank_account_id' => $request->bank_account_id,
            'type' => $request->type,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Transaction added successfully');
    }

    public function index()
    {
        $transactions = BankTransaction::with('account')->latest()->get();
        return view('admin.bank.transaction.index', compact('transactions'));
    }

    public function transferForm()
    {
        $accounts = BankAccount::all();
        return view('admin.bank.transfer', compact('accounts'));
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'from_account_id' => 'required',
            'to_account_id' => 'required|different:from_account_id',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required',
        ]);

        // WITHDRAW from source
        BankTransaction::create([
            'bank_account_id' => $request->from_account_id,
            'date' => $request->date,
            'type' => 'withdraw',
            'amount' => $request->amount,
            'description' => 'Bank Transfer Out',
            'user_id' => auth()->id(),
        ]);

        // DEPOSIT into destination
        BankTransaction::create([
            'bank_account_id' => $request->to_account_id,
            'date' => $request->date,
            'type' => 'deposit',
            'amount' => $request->amount,
            'description' => 'Bank Transfer In',
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Bank transfer completed successfully');
    }

}
