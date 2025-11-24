<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Member;
use App\Models\DpsPlan;
use App\Models\DpsAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\DpsInstallment;
use Illuminate\Support\Facades\DB;

class DpsPlanController extends Controller
{
    // 🔵 SHOW ALL PLANS
    public function planIndex()
    {
        $plans = DpsPlan::all();
        return view('admin.dps.plan.index', compact('plans'));
    }

    // 🔵 PLAN CREATE FORM
    public function planCreate()
    {
        return view('admin.dps.plan.create');
    }

    // 🔵 PLAN STORE
    public function planStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'duration_months' => 'required|numeric|min:1',
            'monthly_deposit' => 'required|numeric|min:1',
            'interest_rate' => 'required|numeric|min:0',
        ]);
        dd($request->all());

        DpsPlan::create($request->all());
        return back()->with('success', 'DPS প্লান যুক্ত হয়েছে');
    }



    // 🔵 ACCOUNT CREATE FORM
    public function accountCreate()
    {
        $members = Member::all();
        $plans = DpsPlan::all();
        return view('admin.dps.account.create', compact('members', 'plans'));
    }

    // 🔵 STORE DPS ACCOUNT (Auto Mature Calculation + Installment Create)
    public function accountStore(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'plan_id' => 'required',
            'start_date' => 'required|date',
        ]);

        $plan = DpsPlan::findOrFail($request->plan_id);

        $start = Carbon::parse($request->start_date);

        $total = $plan->monthly_deposit * $plan->duration_months;
        $interest = ($total * $plan->interest_rate / 100);
        $mature = $total + $interest;

        $matureDate = $start->clone()->addMonths($plan->duration_months);

        DB::beginTransaction();

        try {

            $dps = DpsAccount::create([
                'start_date' => $start,
                'member_id' => $request->member_id,
                'plan_id' => $plan->id,
                'monthly_deposit' => $plan->monthly_deposit,
                'duration_months' => $plan->duration_months,
                'interest_rate' => $plan->interest_rate,
                'total_deposit' => $total,
                'mature_amount' => $mature,
                'mature_date' => $matureDate,
                'status' => 'running',
            ]);

            // AUTO INSTALLMENT GENERATE
            for ($i = 1; $i <= $plan->duration_months; $i++) {
                DpsInstallment::create([
                    'dps_id' => $dps->id,
                    'due_date' => $start->clone()->addMonths($i),
                    'amount' => $plan->monthly_deposit,
                    'status' => 'pending',
                ]);
            }

            DB::commit();
            return redirect()->route('dps.account.index')->with('success', 'DPS তৈরি হয়েছে');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }


    // 🔵 DPS ACCOUNT LIST
    public function accountIndex()
    {
        $dps = DpsAccount::with('member')->latest()->get();
        return view('admin.dps.account.index', compact('dps'));
    }


    // 🔵 DPS DETAILS PAGE
    public function accountShow($id)
    {
        $dps = DpsAccount::with(['member', 'installments'])->findOrFail($id);
        return view('admin.dps.account.show', compact('dps'));
    }


    // 🔵 PAY INSTALLMENT
    public function payInstallment(Request $request, $id)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);

        $ins = DpsInstallment::findOrFail($id);
        dd($ins);
        $amount = $request->amount;

        DB::beginTransaction();

        try {

            $ins->paid_amount = $amount;
            $ins->status = 'paid';
            $ins->save();

            // MEMBER CREDIT
            Transaction::create([
                'date' => date('Y-m-d'),
                'member_id' => $ins->dps->member_id,
                'dps_id' => $ins->dps_id,
                'amount' => $amount,
                'transaction_type' => 'credit',
                'type' => 'member',
                'note' => 'DPS Installment Deposit',
            ]);

            // ADMIN DEBIT
            $admin = User::where('type', 'admin')->first();
            Transaction::create([
                'date' => date('Y-m-d'),
                'user_id' => $admin->id,
                'dps_id' => $ins->dps_id,
                'amount' => $amount,
                'transaction_type' => 'debit',
                'type' => 'admin',
                'note' => 'DPS Installment Received',
            ]);

            DB::commit();

            return back()->with('success', 'Installment Paid Successfully');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }


    // 🔵 DPS WITHDRAW
    public function withdraw($id)
    {
        $dps = DpsAccount::findOrFail($id);

        if ($dps->status == 'closed') {
            return back()->with('failed', 'Already Withdrawn');
        }

        DB::beginTransaction();

        try {

            $dps->status = 'closed';
            $dps->save();

            $admin = User::where('type', 'admin')->first();

            // MEMBER CREDIT
            Transaction::create([
                'date' => date('Y-m-d'),
                'member_id' => $dps->member_id,
                'dps_id' => $dps->id,
                'amount' => $dps->mature_amount,
                'transaction_type' => 'credit',
                'type' => 'member',
                'note' => 'DPS Withdraw Payment',
            ]);

            // ADMIN DEBIT
            Transaction::create([
                'date' => date('Y-m-d'),
                'user_id' => $admin->id,
                'dps_id' => $dps->id,
                'amount' => $dps->mature_amount,
                'transaction_type' => 'debit',
                'type' => 'admin',
                'note' => 'DPS Withdraw Paid',
            ]);

            DB::commit();

            return back()->with('success', 'DPS Withdraw Successfully');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }
}
