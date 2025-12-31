<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\Transaction;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CollectionController extends Controller
{
    // ALL LOAN COLLECTION PAGE
    public function allMembers()
    {
        $loans = Loan::with(['member', 'installments'])->get();
        return view('admin.collection.all', compact('loans'));
    }

    // DAILY COLLECTION SELECT PAGE
    public function index()
    {
        $areas = Area::all();
        return view('admin.collection.index', compact('areas'));
    }

    // DAILY COLLECTION LOAD LIST
    public function load(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'area_id' => 'required'
        ]);

        $installments = Installment::with(['loan', 'member'])
            ->whereDate('due_date', $request->date)
            ->whereHas('member', fn($q) => $q->where('area_id', $request->area_id))
            ->get();

        return view('admin.collection.list', compact('installments'));
    }


    // INSTALLMENT PAYMENT

    public function pay(Request $request, $id)
{
    $request->validate([
        'amount' => 'required|numeric|min:1'
    ]);

    $install = Installment::with('loan')->findOrFail($id);
    $loan = $install->loan;

    $payAmount = $request->amount;
    $today = now()->startOfDay();

    DB::beginTransaction();

    try {

        // -----------------------------------------------
        // 1️⃣ AUTO CALCULATE LATE FEE
        // -----------------------------------------------
        if ($today->gt($install->due_date) && $install->status != 'paid') {

            $daysLate = $install->due_date->diffInDays($today);

            $lateFee = $daysLate * 10; // ⭐ per day charge

            // New late fee added
            $install->late_fee = $lateFee;

            // Update loan total late fee
            $loan->total_late_fee += $lateFee;

            $loan->save();
        }

        // -----------------------------------------------
        // 2️⃣ PAYMENT PRIORITY: Late Fee → Installment Amount
        // -----------------------------------------------
        $remainingPay = $payAmount;

        // ➊ First Pay Late Fee
        if ($install->late_fee > $install->late_fee_paid) {

            $lateFeeDue = $install->late_fee - $install->late_fee_paid;

            $lateFeePay = min($remainingPay, $lateFeeDue);

            $install->late_fee_paid += $lateFeePay;
            $loan->paid_late_fee += $lateFeePay;

            $remainingPay -= $lateFeePay;

            // TRANSACTION for Late Fee
            Transaction::create([
                'date' => now(),
                'loan_id' => $loan->id,
                'member_id' => $install->member_id,
                'loan_amount' => $lateFeePay,
                'transaction_type' => 'credit',
                'type' => 'member',
                'note' => 'Late Fee Paid'
            ]);
        }

        // ➋ Then Pay Installment
        if ($remainingPay > 0) {

            $installPay = min($remainingPay, $install->remaining_amount);

            $install->paid_amount += $installPay;
            $install->remaining_amount -= $installPay;

            $loan->paid_total += $installPay;
            $loan->remaining_total = $loan->total_amount - $loan->paid_total;

            $remainingPay -= $installPay;

            // TRANSACTION for Installment
            Transaction::create([
                'date' => now(),
                'loan_id' => $loan->id,
                'member_id' => $install->member_id,
                'loan_amount' => $installPay,
                'transaction_type' => 'credit',
                'type' => 'member',
                'note' => 'Installment Payment'
            ]);
        }

        // -----------------------------------------------
        // 3️⃣ UPDATE INSTALLMENT STATUS   
        // -----------------------------------------------
        if ($install->remaining_amount <= 0 && 
            $install->late_fee == $install->late_fee_paid) {

            $install->status = 'paid';

        } elseif ($install->paid_amount > 0 || $install->late_fee_paid > 0) {

            $install->status = 'partial';
        }

        $install->save();
        $loan->save();

        DB::commit();

        return redirect()->route('collection.all')->with('success', 'Payment Applied Successfully');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('failed', $e->getMessage());
    }
}





    // public function pay(Request $request, $id)
    // {
    //     $installment = Installment::with(['loan', 'member'])->findOrFail($id);

    //     $request->validate([
    //         'amount' => 'required|numeric|min:1'
    //     ]);

    //     $payAmount = $request->amount;

    //     if ($payAmount > $installment->remaining_amount) {
    //         return back()->with('error', 'Amount cannot exceed remaining amount');
    //     }

    //     try {
    //         DB::beginTransaction();

    //         // ===== LATE FEE CHECK =====
    //         $today = Carbon::today();
    //         $dueDate = Carbon::parse($installment->due_date);

    //         $lateFee = 0;
    //         if ($today->gt($dueDate) && $installment->status !== 'paid') {
    //             $daysLate = $dueDate->diffInDays($today);
    //             $lateFee = $daysLate * 10; // you can change rate here

    //             $installment->late_fee += $lateFee;
    //             $installment->remaining_amount += $lateFee;
    //             $installment->is_late = true;
    //         }

    //         // ===== APPLY PAYMENT =====
    //         $installment->paid_amount += $payAmount;
    //         $installment->remaining_amount = 
    //             ($installment->amount + $installment->late_fee) - $installment->paid_amount;

    //         if ($installment->remaining_amount <= 0) {
    //             $installment->status = 'paid';
    //         } elseif ($installment->paid_amount > 0) {
    //             $installment->status = 'partial';
    //         }

    //         $installment->save();

    //         // TRANSACTIONS
    //         $admin = User::where('type', 'admin')->first();

    //         Transaction::create([
    //             'date' => $today,
    //             'loan_id' => $installment->loan_id,
    //             'member_id' => $installment->member_id,
    //             'amount' => $payAmount,
    //             'late_fee' => $lateFee,
    //             'transaction_type' => 'credit',
    //             'type' => 'member',
    //             'note' => $lateFee > 0 
    //                 ? "Late Installment Payment (Fee: $lateFee)" 
    //                 : "Installment Payment",
    //         ]);

    //         Transaction::create([
    //             'date' => $today,
    //             'loan_id' => $installment->loan_id,
    //             'user_id' => $admin->id,
    //             'amount' => $payAmount,
    //             'late_fee' => $lateFee,
    //             'transaction_type' => 'debit',
    //             'type' => 'admin',
    //             'note' => $lateFee > 0 
    //                 ? "Late Installment Received (Fee: $lateFee)" 
    //                 : "Installment Received",
    //         ]);

    //         DB::commit();
    //         return back()->with('success', 'Installment Paid Successfully');

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return back()->with('failed', $e->getMessage());
    //     }
    // }
}
