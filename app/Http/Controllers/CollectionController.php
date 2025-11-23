<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\Transaction;
use App\Models\Loan;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CollectionController extends Controller
{


    public function allMembers()
    {
        // Load all active loans with their members
        $loans = Loan::with(['member', 'installments'])->get();

        return view('admin.collection.all', compact('loans'));
    }


    // =============================
    // DAILY COLLECTION PAGE (SELECT AREA + DATE)
    // =============================
    public function index()
    {
        $areas = \App\Models\Area::all();
        return view('admin.collection.index', compact('areas'));
    }

    // =============================
    // LOAD INSTALLMENTS FOR SELECTED DATE + AREA
    // =============================
    public function load(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'area_id' => 'required'
        ]);

        $installments = Installment::with('member', 'loan')
            ->whereDate('due_date', $request->date)
            ->whereHas('member', function ($q) use ($request) {
                $q->where('area_id', $request->area_id);
            })
            ->get();

        return view('admin.collection.list', compact('installments'));
    }

    // =============================
    // PAY INSTALLMENT
    // =============================
    public function pay(Request $request, $id)
    {
        $installment = Installment::with('loan', 'member')->findOrFail($id);

        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $payAmount = $request->amount;

        if ($payAmount > $installment->remaining_amount) {
            return back()->with('error', 'Amount cannot exceed remaining amount');
        }

        try {
            DB::beginTransaction();

            // Update installment
            $installment->paid_amount += $payAmount;
            $installment->remaining_amount -= $payAmount;

            if ($installment->remaining_amount <= 0) {
                $installment->status = 'paid';
            } else {
                $installment->status = 'partial';
            }

            $installment->save();

            // Transactions
            $admin = User::where('type', 'admin')->first();

            // MEMBER CREDIT (Because member is paying back)
            Transaction::create([
                'date' => now(),
                'loan_id' => $installment->loan_id,
                'member_id' => $installment->member_id,
                'loan_amount' => $payAmount,
                'transaction_type' => 'credit',
                'type' => 'member',
                'note' => 'Installment Payment'
            ]);

            // ADMIN DEBIT (Admin receiving money)
            Transaction::create([
                'date' => now(),
                'loan_id' => $installment->loan_id,
                'user_id' => $admin->id,
                'loan_amount
                ' => $payAmount,
                'transaction_type' => 'debit',
                'type' => 'admin',
                'note' => 'Installment Received from Member'
            ]);

            DB::commit();
            return redirect()->route('collection.index')->with('success', 'Installment Paid Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return  redirect()->route('collection.index')->with('failed', $e->getMessage());
        }
    }
}
