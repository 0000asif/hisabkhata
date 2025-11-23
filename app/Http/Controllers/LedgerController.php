<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\Request;

class LedgerController extends Controller
{
    public function memberLedgerIndex()
    {
        $members = Member::all();
        return view('admin.ledger.member_index', compact('members'));
    }

    // Show ledger for selected member
    public function memberLedger($id)
    {
        $member = Member::findOrFail($id);

        $transactions = Transaction::where('member_id', $id)
            ->with('loan')
            ->where('loan_id', '!=', null)
            ->orderBy('date', 'asc')
            ->get();



        // Calculate running balance
        $balance = 0;
        foreach ($transactions as $t) {
            if ($t->transaction_type == 'debit') $balance += $t->amount;
            else $balance -= $t->amount;
            $t->running_balance = $balance;
        }

        return view('admin.ledger.member', compact('member', 'transactions'));
    }

    public function loanLedger(Request $request)
    {
        $loans = Loan::with('member', 'installments')->get();

        return view('admin.ledger.loan', compact('loans'));
    }
}
