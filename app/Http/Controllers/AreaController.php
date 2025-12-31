<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::get();
        return view('admin.area.index', compact('areas'));
    }
    public function create()
    {
        return view('admin.area.form');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $area = new Area();
        $area->name = $request->name;
        $area->user_id = Auth::user()->id;
        $area->status = $request->status;
        $area->save();
        return redirect()->route('area.index')->with('success', 'Area Created Successfully!');
    }
    public function edit(Request $request, $id)
    {
        $area = Area::find($id);
        return view('admin.area.form', compact('area'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $area = Area::find($id);
        $area->name = $request->name;
        $area->status = $request->status;
        $area->save();
        return redirect()->route('area.index')->with('success', 'Area Updated Successfully!');
    }

    public function destroy(Request $request)
    {
        return "Pore";
        // $area = Area::find($request->id);
        // $area->delete();
        // return redirect('area.index')->with('success', 'Area Deleted Successfully!');
    }
}
