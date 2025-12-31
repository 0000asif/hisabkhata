<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Position;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = Staff::get();
        return view('admin.staff.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Position::get();
        return view('admin.staff.form', compact('positions'));
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
            'name'          => 'required',
            'email'         => 'required|unique:users,email',
            'phone'         => 'required',
            'address'       => 'required',
            'status'        => 'required',
            'feild'         => 'required',
            'position_id'   => 'required|exists:positions,id',
            'password'      => 'required|confirmed',
        ]);


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $staff = new Staff();
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->phone = $request->phone;
        $staff->address = $request->address;
        $staff->status = $request->status;
        $staff->feild = $request->feild;
        $staff->user_id = $user->id;
        $staff->position_id = $request->position_id;
        $staff->branch_id = $request->branch_id;
        $staff->save();


        return redirect()->route('staff.index')->with('success', 'স্টাফ সফলভাবে তৈরি হয়েছে!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        $positions = Position::get();
        $branchs = Branch::get();
        return view('admin.staff.form', compact('staff', 'positions', 'branchs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|email|unique:users,email,' . $staff->user_id,
            'phone'         => 'required',
            'address'       => 'required',
            'status'        => 'required',
            'feild'         => 'required',
            'position_id'   => 'required|exists:positions,id',
            'password'      => 'nullable|confirmed',
            'branch_id'     => 'required',
        ]);


        $user = User::find($staff->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->phone = $request->phone;
        $staff->address = $request->address;
        $staff->status = $request->status;
        $staff->feild = $request->feild;
        $staff->position_id = $request->position_id;
        $staff->branch_id = $request->branch_id;
        $staff->save();
        return redirect()->route('staff.index')->with('success', 'স্টাফ তথ্য সফলভাবে আপডেট হয়েছে!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        return 'pore';
    }
}
