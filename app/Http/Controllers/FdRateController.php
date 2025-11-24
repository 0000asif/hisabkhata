<?php

namespace App\Http\Controllers;

use App\Models\FdRate;
use Illuminate\Http\Request;

class FdRateController extends Controller
{
    public function index()
    {
        $rates = FdRate::orderBy('months')->get();
        return view('admin.fd_rate.index', compact('rates'));
    }

    public function create()
    {
        return view('admin.fd_rate.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'months' => 'required|numeric',
            'rate'   => 'required|numeric'
        ]);

        FdRate::create($request->all());

        return redirect()->route('fd.rate.index')->with('success', 'FD Rate Added Successfully');
    }

    public function edit($id)
    {
        $rate = FdRate::findOrFail($id);
        return view('admin.fd_rate.edit', compact('rate'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'months' => 'required|numeric',
            'rate'   => 'required|numeric'
        ]);

        FdRate::findOrFail($id)->update($request->all());

        return redirect()->route('fd.rate.index')->with('success', 'Rate Updated Successfully');
    }

    public function destroy($id)
    {
        FdRate::findOrFail($id)->delete();
        return back()->with('success', 'Rate Deleted Successfully');
    }

    // Ajax: find rate by months
    public function getRate($months)
    {
        $rate = FdRate::where('months', $months)->first();
        return $rate ? $rate->rate : 0;
    }
}
