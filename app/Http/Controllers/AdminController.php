<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Loan;
use App\Models\Member;
use App\Models\DpsAccount;
use App\Models\Transaction;
use App\Models\FixedDeposit;
use Illuminate\Http\Request;
use App\Models\IncomeExpense;
use App\Models\SavingsAccount;
use App\Models\SavingsCollection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        // LOAN
        $totalLoanDisbursed = Loan::sum('loan_amount');
        $totalLoanCollection = Transaction::where('transaction_type', 'credit')
                                ->whereNotNull('loan_id')
                                ->sum('loan_amount');
        $totalLoanPending = Loan::sum('total_amount') - $totalLoanCollection;

        // SAVINGS
        $totalSavingsBalance = SavingsAccount::sum('balance');
        $totalSavingsCollection = SavingsCollection::sum('amount');

        // FDR
        $totalFdrAmount = FixedDeposit::sum('deposit_amount');
        $totalFdrMature = FixedDeposit::where('status', 'withdrawn')->sum('mature_amount');
        $totalRunningFdr = FixedDeposit::where('status', 'running')->count();

        // DPS
        $totalDpsAccounts = DpsAccount::count();
        $totalDpsMature = DpsAccount::where('status', 'closed')->sum('mature_amount');

        // INCOME / EXPENSE
        $totalIncome = IncomeExpense::where('type', 'income')->sum('amount');
        $totalExpense = IncomeExpense::where('type', 'expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpense;

        // BASIC COUNTS
        $totalMembers = Member::count();
        $totalAreas = Area::count();

        return view('admin.dashboard', compact(
            'totalLoanDisbursed',
            'totalLoanCollection',
            'totalLoanPending',

            'totalSavingsBalance',
            'totalSavingsCollection',

            'totalFdrAmount',
            'totalFdrMature',
            'totalRunningFdr',

            'totalDpsAccounts',
            'totalDpsMature',

            'totalIncome',
            'totalExpense',
            'netBalance',

            'totalMembers',
            'totalAreas'
        ));
    }


    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
