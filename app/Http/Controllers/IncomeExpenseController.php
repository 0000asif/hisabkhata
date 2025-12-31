<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\IncomeExpense;
use App\Http\Controllers\Controller;

class IncomeExpenseController extends Controller
{
     public function index()
    {
        $incomeExpenses = IncomeExpense::with(['category', 'user'])
                            ->orderBy('id', 'DESC')
                            ->get();

        return view('admin.income_expense.index', compact('incomeExpenses'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.income_expense.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'category_id' => 'required',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
        ]);

        IncomeExpense::create([
            'date' => $request->date,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'note' => $request->note,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('income-expense.index')
            ->with('success', 'Record added successfully!');
    }

    public function edit($id)
    {
        $incomeExpense = IncomeExpense::findOrFail($id);
        $categories = Category::orderBy('name')->get();

        return view('income_expense.form', compact('incomeExpense', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'category_id' => 'required',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
        ]);

        $incomeExpense = IncomeExpense::findOrFail($id);

        $incomeExpense->update([
            'date' => $request->date,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'note' => $request->note,
        ]);

        return redirect()->route('income-expense.index')
            ->with('success', 'Record updated successfully!');
    }

    public function destroy($id)
    {
        $incomeExpense = IncomeExpense::findOrFail($id);
        $incomeExpense->delete();

        return redirect()->route('income-expense.index')
            ->with('success', 'Record deleted successfully!');
    }

    public function report(Request $request)
{
    $categories = Category::orderBy('name')->get();

    // Default filters
    $start_date = $request->start_date ?? date('Y-m-01');
    $end_date = $request->end_date ?? date('Y-m-d');

    $query = IncomeExpense::with(['category', 'user'])
                ->whereBetween('date', [$start_date, $end_date]);

    // Type filter
    if ($request->type && $request->type != 'all') {
        $query->where('type', $request->type);
    }

    // Category filter
    if ($request->category_id) {
        $query->where('category_id', $request->category_id);
    }

    $records = $query->orderBy('date', 'ASC')->get();

    // Summary totals
    $total_income = $records->where('type', 'income')->sum('amount');
    $total_expense = $records->where('type', 'expense')->sum('amount');
    $balance = $total_income - $total_expense;

    return view('admin.income_expense.report', compact(
        'categories',
        'records',
        'start_date',
        'end_date',
        'total_income',
        'total_expense',
        'balance'
    ));
}


    // Category-wise report
    public function categoryReport()
    {
        $categories = Category::where('status', 1)->get();
        $data = [];

        foreach ($categories as $cat) {

            $income = IncomeExpense::where('category_id', $cat->id)
                ->where('type', 'income')
                ->sum('amount');

            $expense = IncomeExpense::where('category_id', $cat->id)
                ->where('type', 'expense')
                ->sum('amount');

            $data[] = [
                'category' => $cat->name,
                'income'   => $income,
                'expense'  => $expense,
            ];
        }

        return view('admin.income_expense.report', compact('data'));
    }
}
