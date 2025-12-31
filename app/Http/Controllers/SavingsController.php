<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\SavingsAccount;
use App\Models\SavingsCollection;
use App\Models\SavingsTransaction;
use Illuminate\Support\Facades\DB;

class SavingsController extends Controller
{
    public function index()
    {
        $accounts = SavingsAccount::with('member')->get();

        return view('admin.savings.index', compact('accounts'));
    }

    public function collectForm()
    {
        $members = Member::all();

        return view('admin.savings.collect', compact('members'));
    }

    public function transactions($id)
    {
        // Load savings account with member + transactions
        $account = SavingsAccount::with(['member', 'transactions' => function ($q) {
            $q->orderBy('date', 'desc')->orderBy('id', 'desc');
        }])->findOrFail($id);

        return view('admin.savings.transactions', compact('account'));
    }


    public function collect(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'amount'    => 'required|numeric|min:1',
            'date'      => 'required|date'
        ]);

        DB::beginTransaction();

        try {
            $account = SavingsAccount::firstOrCreate([
                'member_id' => $request->member_id
            ]);

            // New balance
            $newBalance = $account->balance + $request->amount;

            // Create transaction
            SavingsTransaction::create([
                'savings_account_id' => $account->id,
                'date'               => $request->date,
                'transaction_type'   => 'deposit',
                'amount'             => $request->amount,
                'balance_after'      => $newBalance,
                'note'               => 'Daily Deposit'
            ]);

            // Update account balance
            $account->update(['balance' => $newBalance]);

            // Record daily collection
            SavingsCollection::create([
                'user_id'   => auth()->id(),
                'member_id' => $request->member_id,
                'date'      => $request->date,
                'amount'    => $request->amount
            ]);

            DB::commit();

            return back()->with('success', 'Savings Collected Successfully');
        } catch (\Exception $e) {

            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function withdraw(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'date'   => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            $account = SavingsAccount::findOrFail($id);

            if ($account->balance < $request->amount) {
                return back()->with('error', 'Insufficient Savings Balance');
            }

            $newBalance = $account->balance - $request->amount;

            SavingsTransaction::create([
                'savings_account_id' => $id,
                'date'               => $request->date,
                'transaction_type'   => 'withdraw',
                'amount'             => $request->amount,
                'balance_after'      => $newBalance,
                'note'               => 'Savings Withdraw'
            ]);

            $account->update(['balance' => $newBalance]);

            DB::commit();

            return back()->with('success', 'Withdraw Successful');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }



    public function reportForm()
{
    $members = Member::all();
    return view('admin.savings.report', compact('members'));
}

public function report(Request $request)
{
    $query = SavingsTransaction::with('account.member');

    // Filter by Member
    if ($request->member_id) {
        $query->whereHas('account', function ($q) use ($request) {
            $q->where('member_id', $request->member_id);
        });
    }

    // Filter by date range
    if ($request->from) {
        $query->whereDate('date', '>=', $request->from);
    }

    if ($request->to) {
        $query->whereDate('date', '<=', $request->to);
    }

    $transactions = $query->orderBy('date', 'asc')->get();

    // Calculate totals
    $totalDeposit = $transactions->where('transaction_type', 'deposit')->sum('amount');
    $totalWithdraw = $transactions->where('transaction_type', 'withdraw')->sum('amount');

    return view('admin.savings.report', compact(
        'transactions',
        'totalDeposit',
        'totalWithdraw'
    ) + ['members' => Member::all()]);
}

}
