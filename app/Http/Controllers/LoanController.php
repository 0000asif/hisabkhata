<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Loan;
use App\Models\User;
use App\Models\Staff;
use App\Models\Member;
use App\Models\Installment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::with('member', 'area', 'user')
            ->latest()
            ->paginate(20);

        return view('admin.loan.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::all();
        $members = Member::all();
        $staffs = Staff::with('position')->get();
        return view('admin.loan.create', compact('areas', 'members', 'staffs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'date'              => 'required|date',
            'user_id'           => 'required',
            'area_id'           => 'required',
            'member_id'         => 'required',
            'loan_amount'       => 'required|numeric',
            'interest_type'     => 'required',
            'interest'          => 'nullable|numeric',
            'installment_type'  => 'required',
            'loan_count'        => 'required|numeric',
        ]);

        // Convert date
        $date = date("Y-m-d", strtotime($request->date));

        try {

            DB::beginTransaction();  // 🔥 Start Transaction

            // ---------- CALCULATION ----------
            $loanAmount    = $request->loan_amount;
            $interestType  = $request->interest_type;
            $interest      = $request->interest ?? 0;

            if ($interestType == 'percent') {
                $totalAmount = $loanAmount + ($loanAmount * $interest / 100);
            } else {
                $totalAmount = $loanAmount + $interest;
            }

            $singleLoanAmount = $totalAmount / $request->loan_count;

            // ---------- LOAN CREATE ----------
            $loan = Loan::create([
                'date'                 => $date,
                'user_id'              => $request->user_id,
                'area_id'              => $request->area_id,
                'member_id'            => $request->member_id,
                'loan_amount'          => $loanAmount,
                'interest_type'        => $interestType,
                'interest'             => $interest,
                'total_amount'         => $totalAmount,
                'installment_type'     => $request->installment_type,
                'loan_count'           => $request->loan_count,
                'single_loan_amount'   => $singleLoanAmount,
                'note'                 => $request->note,
            ]);

            // CREATE DISBURSEMENT TRANSACTIONS
            $admin = User::where('type', 'admin')->first();

            // Member Debit
            Transaction::create([
                'date' => $date,
                'loan_id' => $loan->id,
                'member_id' => $request->member_id,
                'loan_amount' => $loanAmount,
                'single_loan_amount'  => $singleLoanAmount,
                'transaction_type' => 'debit',
                'type' => 'member',
                'note' => 'Loan Disbursement',
                'balance' => 0, // You can calculate here later
            ]);

            // Admin Credit
            Transaction::create([
                'date' => $date,
                'loan_id' => $loan->id,
                'user_id' => $admin->id,
                'loan_amount' => $loanAmount,
                'single_loan_amount'  => $singleLoanAmount,
                'transaction_type' => 'credit',
                'type' => 'admin',
                'note' => 'Loan Disbursement',
                'balance' => 0,
            ]);



            // CREATE INSTALLMENTS
            $start = Carbon::parse($date);

            for ($i = 1; $i <= $request->loan_count; $i++) {

                $due = match ($request->installment_type) {
                    'daily' => $start->copy()->addDays($i),
                    'weekly' => $start->copy()->addWeeks($i),
                    'fortnightly' => $start->copy()->addWeeks($i * 2),
                    'monthly' => $start->copy()->addMonths($i),
                    '6month' => $start->copy()->addMonths($i * 6),
                };

                Installment::create([
                    'loan_id' => $loan->id,
                    'member_id' => $loan->member_id,
                    'due_date' => $due,
                    'amount' => $singleLoanAmount,
                    'remaining_amount' => $singleLoanAmount,
                    'status' => 'pending',
                ]);
            }


            DB::commit();   // 🔥 Commit All Queries

            return redirect()->route('loan.index')->with('success', 'লোন সফলভাবে যুক্ত হয়েছে!');
        } catch (\Exception $e) {

            DB::rollBack(); // 🔥 Rollback if error occurs

            return back()->with('failed', 'কিছু সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        //
    }

    public function details($id)
    {
        $loan = Loan::with(['member', 'user', 'area', 'installments'])->findOrFail($id);

        return view('admin.loan.details', compact('loan'));
    }

    public function installments($id)
    {
        $loan = Loan::with('member', 'installments')->findOrFail($id);
        return view('admin.loan.installments', compact('loan'));
    }


    public function payInstallment(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        try {
            DB::beginTransaction();

            $install = Installment::findOrFail($id);
            $pay = $request->amount;

            // Update installment
            $install->paid_amount += $pay;
            $install->remaining_amount = $install->amount - $install->paid_amount;

            if ($install->remaining_amount <= 0) {
                $install->status = 'paid';
            } else {
                $install->status = 'partial';
            }

            $install->save();

            // Member -> Credit
            $memberTrans = Transaction::create([
                'date' => date('Y-m-d'),
                'loan_id' => $install->loan_id,
                'member_id' => $install->member_id,
                'amount' => $pay,
                'transaction_type' => 'credit',
                'type' => 'member',
                'note' => 'Installment Payment',
            ]);

            // Admin -> Debit
            $admin = User::where('type', 'admin')->first();
            Transaction::create([
                'date' => date('Y-m-d'),
                'loan_id' => $install->loan_id,
                'user_id' => $admin->id,
                'amount' => $pay,
                'transaction_type' => 'debit',
                'type' => 'admin',
                'note' => 'Installment Received',
            ]);

            // Link installment
            $install->update(['transaction_id' => $memberTrans->id]);

            DB::commit();

            return back()->with('success', 'Installment Payment Successful');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function print()
{
    $loans = Loan::with('member')->get();
    return view('admin.report.print', compact('loans'));
}

}
