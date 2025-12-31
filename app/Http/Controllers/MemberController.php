<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\User;
use App\Models\Staff;
use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $area = $request->area_id;

        $members = Member::when($area, function ($q) use ($area) {
            $q->where('area_id', $area);
        })->latest()->get();

        $areas = Area::all();

        return view('admin.member.index', compact('members', 'areas'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::where("status", 1)->get();
        $staffs = Staff::where("status", 1)->get();
        return view("admin.member.form", compact('areas', 'staffs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $user = User::where('type', 'admin')->first();

        $request->validate([
            'date' => 'required',
            'name' => 'required',
            'number' => 'required',
            'address' => 'required',
            'nid' => 'required',
            'area_id' => 'required',
            'user_id' => 'required',
            'status' => 'required',
            'password' => 'required|min:4',
        ]);
        DB::beginTransaction();

        try {
            $date = date("Y-m-d", strtotime($request->date));

            $member = new Member();
            $member->date = $date;
            $member->name = $request->name;
            $member->phone = $request->number;
            $member->address = $request->address;
            $member->nid = $request->nid;
            $member->father_name = $request->father_name;
            $member->guarantor = $request->guarantor;
            $member->nominee = $request->nominee;
            $member->nominee_phone = $request->nominee_phone;
            $member->nominee_relation = $request->nominee_relation;
            $member->user_id = $request->user_id;
            $member->area_id = $request->area_id;
            $member->status = $request->status;
            $member->membership_fee = $request->membership_fee;
            $member->note = $request->note;
            $member->password = Hash::make($request->password);

            // Handle Photo Uploads (public path)
            $member->member_photo   = $this->uploadPublicFile($request, 'member_photo', 'member');
            $member->nominee_photo  = $this->uploadPublicFile($request, 'nominee_photo', 'nominee');
            $member->signature      = $this->uploadPublicFile($request, 'signature', 'signature');
            $member->nid_front      = $this->uploadPublicFile($request, 'nid_front', 'nid');
            $member->nid_back       = $this->uploadPublicFile($request, 'nid_back', 'nid');
            $member->pdf_file       = $this->uploadPublicFile($request, 'pdf_file', 'pdf');


            $member->save();

            $amount = $request->membership_fee;

            if ($amount > 0) {
                $transaction = new Transaction();
                $transaction->date = $date;
                $transaction->user_id = $user->id;
                $transaction->join_fee = $amount;
                $transaction->status = 1;
                $transaction->type = 'admin';
                $transaction->transaction_type = 'debit';
                $transaction->save();



                $transaction = new Transaction();
                $transaction->date = $date;
                $transaction->member_id = $member->id;
                $transaction->join_fee = $amount;
                $transaction->status = 1;
                $transaction->type = 'member';
                $transaction->transaction_type = 'credit';
                $transaction->save();
            }

            DB::commit();
            return redirect()->route('member.index')->with('success', 'মেম্বার সফলভাবে যুক্ত হয়েছে');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with('error', 'মেম্বার যুক্ত করতে সমস্যা হয়েছে: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function uploadPublicFile($request, $fieldName, $folder)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $filename = time() . '_' . uniqid() . '.' . $file->extension();
            $file->move(public_path($folder), $filename);
            return $folder . '/' . $filename;
        }
        return null;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = Member::with(['area', 'user'])->findOrFail($id);
        return view('admin.member.memberDetails', compact('member'));

        return view('admin.member.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        $areas = Area::where("status", 1)->get();
        $staffs = Staff::where("status", 1)->get();
        return view('admin.member.form', compact('member', 'areas', 'staffs'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'date' => 'required',
            'name' => 'required',
            'number' => 'required',
            'address' => 'required',
            'nid' => 'required',
            'area_id' => 'required',
            'user_id' => 'required',
            'status' => 'required',
            'password' => 'nullable|min:4',
        ]);

        DB::beginTransaction();

        try {

            $date = date("Y-m-d", strtotime($request->date));

            // Update normal fields manually (matching store() logic)
            $member->date              = $date;
            $member->name              = $request->name;
            $member->phone             = $request->number;
            $member->address           = $request->address;
            $member->nid               = $request->nid;
            $member->father_name       = $request->father_name;
            $member->guarantor         = $request->guarantor;
            $member->nominee           = $request->nominee;
            $member->nominee_phone     = $request->nominee_phone;
            $member->nominee_relation  = $request->nominee_relation;
            $member->user_id           = $request->user_id;
            $member->area_id           = $request->area_id;
            $member->status            = $request->status;
            $member->membership_fee    = $request->membership_fee;
            $member->note              = $request->note;

            // Update password only when provided
            if ($request->filled('password')) {
                $member->password = Hash::make($request->password);
            }

            // File update (replace + delete old)
            $member->member_photo   = $this->updatePublicFile($request, 'member_photo', $member->member_photo, 'member');
            $member->nominee_photo  = $this->updatePublicFile($request, 'nominee_photo', $member->nominee_photo, 'nominee');
            $member->signature      = $this->updatePublicFile($request, 'signature', $member->signature, 'signature');
            $member->nid_front      = $this->updatePublicFile($request, 'nid_front', $member->nid_front, 'nid');
            $member->nid_back       = $this->updatePublicFile($request, 'nid_back', $member->nid_back, 'nid');
            $member->pdf_file       = $this->updatePublicFile($request, 'pdf_file', $member->pdf_file, 'pdf');

            $member->save();

            DB::commit();

            return redirect()
                ->route('member.index')
                ->with('success', 'মেম্বার সফলভাবে আপডেট হয়েছে');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with('error', 'আপডেট করতে সমস্যা হয়েছে: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function updatePublicFile($request, $fieldName, $oldFilePath, $folder)
    {
        if ($request->hasFile($fieldName)) {

            // Create folder if not exists
            $uploadPath = public_path($folder);
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            // Delete old file
            if ($oldFilePath && file_exists(public_path($oldFilePath))) {
                unlink(public_path($oldFilePath));
            }

            // Upload new file
            $file = $request->file($fieldName);
            $filename = time() . '_' . uniqid() . '.' . $file->extension();
            $file->move($uploadPath, $filename);

            return $folder . '/' . $filename;  // return new path
        }

        // If no new file uploaded, return old file path
        return $oldFilePath;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        //
    }
}
