<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DpsAccountController extends Controller
{
    public function index()
    {
        return view('admin.dps.calculator');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'duration' => 'required|numeric',
            'monthly_installment' => 'required|numeric',
            'interest' => 'required|numeric',
        ]);

        $duration = $request->duration; // months
        $monthly = $request->monthly_installment;
        $interest = $request->interest; // percent

        $total_deposit = $monthly * $duration;
        $profit = ($total_deposit * $interest) / 100;
        $total_amount = $total_deposit + $profit;

        return view('admin.dps.calculator', compact('duration', 'monthly', 'interest', 'profit', 'total_amount'));
    }
}
