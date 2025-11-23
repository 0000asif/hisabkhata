<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalLoan = Loan::sum('loan_amount');
        $totalCollection = Transaction::where('transaction_type', 'credit')->sum('loan_amount');
        $totalPending = Loan::sum('total_amount') - $totalCollection;

        return view('admin.dashboard', compact('totalLoan', 'totalCollection', 'totalPending'));
    }
}
