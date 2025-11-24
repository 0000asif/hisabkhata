<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\User;
use App\Models\FdRate;
use App\Models\Member;
use App\Models\FixedDeposit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\FixedDepositTransaction;

class FixedDepositController extends Controller
{
    public function index()
    {
        $fds = FixedDeposit::with('member', 'area', 'user')->latest()->get();
        $areas = Area::get();
        return view('admin.fd.index', compact('fds', 'areas'));
    }

    public function create()
    {
        $members = Member::all();
        $areas = Area::all();
        return view('admin.fd.form', compact('members', 'areas'));
    }

    public function show($id)
    {
        $fd = FixedDeposit::find($id);
        return view('admin.fd.details', compact('fd'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'area_id' => 'required',
            'date' => 'required|date',
            'deposit_amount' => 'required|numeric|min:1',
            'duration_months' => 'required|numeric|min:1',
        ]);

        try {
            DB::beginTransaction();

            $date = Carbon::parse($request->date);

            // AUTO RATE BASED ON MONTHS
            $rate = FdRate::where('min_months', '<=', $request->duration_months)
                ->where('max_months', '>=', $request->duration_months)
                ->first()
                ->rate ?? 0;

            $fdAmount = $request->deposit_amount;

            $interestAmount = ($fdAmount * $rate / 100) * ($request->duration_months / 12);
            $matureAmount = $fdAmount + $interestAmount;

            $matureDate = $date->copy()->addMonths($request->duration_months);

            $fd = FixedDeposit::create([
                'date' => $date,
                'member_id' => $request->member_id,
                'user_id' => auth()->user()->id,
                'area_id' => $request->area_id,
                'deposit_amount' => $fdAmount,
                'interest_rate' => $rate,
                'duration_months' => $request->duration_months,
                'mature_amount' => $matureAmount,
                'mature_date' => $matureDate,
                'status' => 'running',
                'note' => $request->note
            ]);

            // FD Transaction (Opening)
            $admin = User::where('type', 'admin')->first();

            FixedDepositTransaction::create([
                'date' => $date,
                'fd_id' => $fd->id,
                'member_id' => $request->member_id,
                'amount' => $fdAmount,
                'transaction_type' => 'debit',
                'type' => 'member',
                'note' => 'FD Opening'
            ]);

            FixedDepositTransaction::create([
                'date' => $date,
                'fd_id' => $fd->id,
                'user_id' => $admin->id,
                'amount' => $fdAmount,
                'transaction_type' => 'credit',
                'type' => 'admin',
                'note' => 'FD Received'
            ]);

            DB::commit();
            return redirect()->route('fd.index')->with('success', 'FD Created Successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function details($id)
    {
        $fd = FixedDeposit::with('member', 'transactions')->findOrFail($id);
        return view('admin.fd.details', compact('fd'));
    }

    // FD Withdraw 
    public function withdraw(Request $request, $id)
    {
        $request->validate([
            'withdraw_type' => 'required', // mature / early
        ]);

        try {
            DB::beginTransaction();

            $fd = FixedDeposit::findOrFail($id);
            $today = Carbon::today();

            // Check if already withdrawn
            if ($fd->status == 'withdrawn') {
                return back()->with('failed', 'Already Withdrawn.');
            }

            $admin = User::where('type', 'admin')->first();

            // Mature Withdraw
            if ($request->withdraw_type == 'mature') {
                if ($today < $fd->mature_date) {
                    return back()->with('failed', 'FD not matured yet.');
                }

                $withdrawAmount = $fd->mature_amount;
                $fd->status = 'withdrawn';
            }

            // Early Withdraw (Penalty)
            else {
                // Penalty 2% (আপনার মতো পরিবর্তন করতে পারবেন)
                $penalty = ($fd->deposit_amount * 2) / 100;
                $withdrawAmount = $fd->deposit_amount - $penalty;

                $fd->status = 'withdrawn';
            }

            $fd->save();

            // Admin → Debit (paying money)
            FixedDepositTransaction::create([
                'date' => $today,
                'fd_id' => $fd->id,
                'user_id' => $admin->id,
                'amount' => $withdrawAmount,
                'transaction_type' => 'debit',
                'type' => 'admin',
                'note' => 'FD Withdraw'
            ]);

            // Member → Credit (receiving money)
            FixedDepositTransaction::create([
                'date' => $today,
                'fd_id' => $fd->id,
                'member_id' => $fd->member_id,
                'amount' => $withdrawAmount,
                'transaction_type' => 'credit',
                'type' => 'member',
                'note' => 'FD Withdraw Received'
            ]);

            DB::commit();

            return back()->with('success', 'FD Withdraw Successfully Completed!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage());
        }
    }

    public function getRate($months)
    {
        $rate = FdRate::where('min_months', '<=', $months)
            ->where('max_months', '>=', $months)
            ->first();

        return $rate ? $rate->rate : 0;
    }
}
