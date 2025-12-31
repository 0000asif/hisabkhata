@extends('admin.masterAdmin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-fullheight">

                <div class="card-header">
                    <h5 class="box-title">মেম্বার বিস্তারিত তথ্য</h5>
                    <a href="{{ route('member.index') }}" class="btn btn-primary btn-sm">
                        Back
                    </a>
                </div>

                <div class="card-body">

                    {{-- Alert --}}
                    @include('components.alert')

                    <div class="row">

                        {{-- Basic Info --}}
                        <div class="col-md-6 mb-3">
                            <label>তারিখ :</label>
                            <p><strong>{{ \Carbon\Carbon::parse($member->date)->format('d-m-Y') }}</strong></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>নাম :</label>
                            <p><strong>{{ $member->name }}</strong></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>মোবাইল নম্বর :</label>
                            <p><strong>{{ $member->phone }}</strong></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>ঠিকানা :</label>
                            <p><strong>{{ $member->address }}</strong></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>NID নম্বর :</label>
                            <p><strong>{{ $member->nid }}</strong></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>পিতার নাম :</label>
                            <p><strong>{{ $member->father_name }}</strong></p>
                        </div>

                        {{-- Area, Staff, Status --}}
                        <div class="col-md-6 mb-3">
                            <label>এরিয়া :</label>
                            <p><strong>{{ $member->area->name }}</strong></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>রেফারেন্স ইউজার :</label>
                            <p><strong>{{ $member->user->name ?? 'N/A' }}</strong></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>স্ট্যাটাস :</label>
                            <p>
                                <strong class="{{ $member->status == 1 ? 'text-success' : 'text-danger' }}">
                                    {{ $member->status == 1 ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}
                                </strong>
                            </p>
                        </div>

                        {{-- Guarantor & Nominee --}}
                        <div class="col-md-6 mb-3">
                            <label>গ্যারান্টর :</label>
                            <p><strong>{{ $member->guarantor }}</strong></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>নোমিনি নাম :</label>
                            <p><strong>{{ $member->nominee }}</strong></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>নোমিনি ফোন :</label>
                            <p><strong>{{ $member->nominee_phone }}</strong></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>নোমিনির সম্পর্ক :</label>
                            <p><strong>{{ $member->nominee_relation }}</strong></p>
                        </div>

                        {{-- Payment Info --}}
                        <div class="col-md-6 mb-3">
                            <label>ভর্তি ফি নির্ধারিত :</label>
                            <p><strong>250</strong></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>ভর্তি ফি প্রদান :</label>
                            <p><strong>{{ $member->membership_fee }}</strong></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>নোট :</label>
                            <p><strong>{{ $member->note ?? 'N/A' }}</strong></p>
                        </div>

                        {{-- Images --}}
                        <div class="col-md-6 mb-3">
                            <label>মেম্বার ছবি :</label><br>
                            @if ($member->member_photo)
                                <img src="{{ asset($member->member_photo) }}" width="120" class="border p-1">
                            @else
                                <p>No Image</p>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>নোমিনি ছবি :</label><br>
                            @if ($member->nominee_photo)
                                <img src="{{ asset($member->nominee_photo) }}" width="120" class="border p-1">
                            @else
                                <p>No Image</p>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>NID Front :</label><br>
                            @if ($member->nid_front)
                                <img src="{{ asset($member->nid_front) }}" width="120" class="border p-1">
                            @else
                                <p>No Image</p>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>NID Back :</label><br>
                            @if ($member->nid_back)
                                <img src="{{ asset($member->nid_back) }}" width="120" class="border p-1">
                            @else
                                <p>No Image</p>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>সিগনেচার :</label><br>
                            @if ($member->signature)
                                <img src="{{ asset($member->signature) }}" width="120" class="border p-1">
                            @else
                                <p>No Image</p>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>পিডিএফ ফাইল :</label><br>
                            @if ($member->pdf_file)
                               <a href="{{ asset('public/'.$member->pdf_file) }}" class="btn btn-primary" >Download</a>
                            @else
                                <p>No PDF</p>
                            @endif
                        </div>

                    </div>

                    {{-- Buttons --}}
                    <div class="mt-4">
                        <a href="{{ route('member.index') }}" class="btn btn-secondary">ফিরে যান</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
