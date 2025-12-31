<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Models\BankTransaction;
use App\Http\Controllers\Controller;

class BankAccountController extends Controller
{
    
    
    public function index()
    {
        $banks = BankAccount::latest()->get();
        return view('admin.bank.index', compact('banks'));
    }

    public function create()
    {
        return view('admin.bank.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required',
            'branch_name' => 'required',
            'account_name' => 'required',
            'account_type' => 'required',
            'account_number' => 'required|unique:bank_accounts',
        ]);

        BankAccount::create([
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'account_name' => $request->account_name,
            'account_type' => $request->account_type,
            'account_number' => $request->account_number,
            'opening_balance' => $request->opening_balance ?? 0,
            'status' => $request->status,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('bank.index')->with('success', 'Bank created successfully');
    }

    public function edit($id)
    {
        $bank = BankAccount::findOrFail($id);
        return view('admin.bank.edit', compact('bank'));
    }

    public function update(Request $request, $id)
    {
        $bank = BankAccount::findOrFail($id);

        $bank->update($request->all());

        return redirect()->route('bank.index')->with('success', 'Bank updated successfully');
    }

    public function destroy($id)
    {
        BankAccount::findOrFail($id)->delete();
        return back()->with('success', 'Bank deleted successfully');
    }

    // BANK REPORT
    public function bankReport(Request $request)
    {
        $accounts = BankAccount::orderBy('bank_name')->get();

        $bank_account_id = $request->bank_account_id;
        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');

        $selectedAccount = null;
        $previous_balance = 0;
        $transactions = collect();

        if ($bank_account_id) {
            $selectedAccount = BankAccount::findOrFail($bank_account_id);

            $deposits_before = BankTransaction::where('bank_account_id', $bank_account_id)
                ->where('date', '<', $start_date)
                ->where('type', 'deposit')->sum('amount');

            $withdraw_before = BankTransaction::where('bank_account_id', $bank_account_id)
                ->where('date', '<', $start_date)
                ->where('type', 'withdraw')->sum('amount');

            $previous_balance = ($selectedAccount->opening_balance + $deposits_before) - $withdraw_before;

            $transactions = BankTransaction::with('account')
                ->where('bank_account_id', $bank_account_id)
                ->whereBetween('date', [$start_date, $end_date])
                ->orderBy('date')
                ->get();
        }

        $total_deposit = $transactions->where('type', 'deposit')->sum('amount');
        $total_withdraw = $transactions->where('type', 'withdraw')->sum('amount');
        $ending_balance = $previous_balance + $total_deposit - $total_withdraw;

        return view('admin.bank.report', compact(
            'accounts',
            'bank_account_id',
            'transactions',
            'previous_balance',
            'total_deposit',
            'total_withdraw',
            'ending_balance',
            'selectedAccount',
            'start_date',
            'end_date'
        ));
    }

}
