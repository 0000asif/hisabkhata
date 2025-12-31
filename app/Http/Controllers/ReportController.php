<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Installment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
     // 1. Loan Summary
    public function loanSummary()
    {
        $loans = Loan::with('member', 'area')->get();
        return view('admin.report.loan_summary', compact('loans'));
    }

    // 2. Installments Report
    public function installments(Request $request)
    {
        $query = Installment::with('loan', 'member');

        if ($request->date) {
            $query->whereDate('due_date', $request->date);
        }

        $installments = $query->orderBy('due_date', 'desc')->get();

        return view('admin.report.installments', compact('installments'));
    }

    // 3. Daily Collection Report
    public function dailyCollection(Request $request)
    {
        $date = $request->date ?? now()->format('Y-m-d');

        $transactions = Transaction::whereDate('date', $date)
            ->where('transaction_type', 'credit')
            ->with('member', 'loan')
            ->get();

        return view('admin.report.daily_collection', compact('transactions', 'date'));
    }

    // 4. Member-wise Report
    
    public function memberReport(Request $request)
    {
        $members = Member::all();

        $transactions = collect([]);
        $member = null;

        if ($request->member_id) {
            $member = Member::find($request->member_id);

            // Get all transactions for this member, include loan if exists
            $transactions = Transaction::where('member_id', $request->member_id)
                ->with('loan')
                ->orderBy('date', 'asc')
                ->get();
        }

        return view('admin.report.member_report', compact('members', 'transactions', 'member'));
    }

    // 5. Area-wise Report
    public function areaReport(Request $request)
    {
        $areas = Area::all();
        $members = collect([]);

        if ($request->area_id) {
            $members = Member::with('loans', 'transactions')
                ->where('area_id', $request->area_id)
                ->get();
        }

        return view('admin.report.area_report', compact('areas', 'members'));
    }

    // 6. Late Fee Report
    public function lateFee(Request $request)
    {
        $query = Installment::with(['member', 'loan']);

        if ($request->date) {
            $query->whereDate('due_date', $request->date);
        }

        $installments = $query->where('late_fee', '>', 0)->get();

        return view('admin.report.late_fee', compact('installments'));
    }

    // 7. Late Fee Collection History
    public function lateFeeCollection()
    {
        $latePayments = Transaction::where('note', 'LIKE', '%Late Fee%')
            ->with('member', 'loan')
            ->latest()
            ->get();

        return view('admin.report.late_fee_collection', compact('latePayments'));
    }
}
