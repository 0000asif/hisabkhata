<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FdrCalculatorController extends Controller
{
       public function index()
        {
            return view('admin.fd.calculator');
        }

    public function calculate(Request $request)
    {
        $amount = $request->amount;
        $rate = $request->rate;
        $months = $request->months;

        $monthly_profit = ($amount * $rate) / 100;
        $total_profit = $monthly_profit * $months;
        $total_amount = $amount + $total_profit;

        return response()->json([
            'monthly_profit' => number_format($monthly_profit, 2),
            'total_profit' => number_format($total_profit, 2),
            'total_amount' => number_format($total_amount, 2),
        ]);
    }
}
