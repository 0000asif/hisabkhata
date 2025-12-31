@extends('admin.masterAdmin')
@section('content')
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">

                    <div class="card-header">
                        <h5 class="box-title">
                            {{ isset($member) ? 'মেম্বার সম্পাদনা করুন' : 'নতুন মেম্বার যোগ করুন' }}
                        </h5>
                    </div>

                    <div class="card-body">
                        @include('components.alert')

                        <form action="{{ isset($member) ? route('member.update', $member->id) : route('member.store') }}"
                            id="memberform" method="POST" enctype="multipart/form-data">

                            @csrf
                            @if (isset($member))
                                @method('PUT')
                            @endif

                            <div class="row">

                                {{-- তারিখ --}}
                                <div class="col-md-6 mb-3">
                                    <label>তারিখ <span class="text-danger">*</span></label>
                                    <input type="text" name="date" class="form-control datetimepicker_5"
                                        value="{{ old('date', isset($member->date) ? \Carbon\Carbon::parse($member->date)->format('d-m-Y') : now()->format('d-m-Y')) }}"
                                        placeholder="dd-mm-yyyy" required>
                                </div>

                                {{-- নাম --}}
                                <div class="col-md-6 mb-3">
                                    <label>নাম <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $member->name ?? '') }}" required>
                                </div>

                                {{-- নম্বর --}}
                                <div class="col-md-6 mb-3">
                                    <label>মোবাইল নম্বর <span class="text-danger">*</span></label>
                                    <input type="text" name="number" class="form-control"
                                        value="{{ old('number', $member->phone ?? '') }}" required>
                                </div>

                                {{-- ঠিকানা --}}
                                <div class="col-md-6 mb-3">
                                    <label>ঠিকানা <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ old('address', $member->address ?? '') }}" required>
                                </div>

                                {{-- NID --}}
                                <div class="col-md-6 mb-3">
                                    <label>এনআইডি নম্বর <span class="text-danger">*</span></label>
                                    <input type="text" name="nid" class="form-control"
                                        value="{{ old('nid', $member->nid ?? '') }}" required>
                                </div>

                                {{-- ফাদার নাম --}}
                                <div class="col-md-6 mb-3">
                                    <label>পিতার নাম</label>
                                    <input type="text" name="father_name" class="form-control"
                                        value="{{ old('father_name', $member->father_name ?? '') }}">
                                </div>

                                {{-- এরিয়া --}}
                                <div class="col-md-6 mb-3">
                                    <label>এরিয়া <span class="text-danger">*</span></label>
                                    <select name="area_id" class="form-control" required>
                                        <option value="">এরিয়া নির্বাচন করুন</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->id }}"
                                                {{ old('area_id', $member->area_id ?? '') == $area->id ? 'selected' : '' }}>
                                                {{ $area->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- রেফারেন্স ইউজার (optional) --}}
                                <div class="col-md-6 mb-3">
                                    <label>ইউজার নির্বাচন করুন <span class="text-danger">*</span></label>
                                    <select name="user_id" class="form-control" required>
                                        <option value="">ইউজার নির্বাচন করুন</option>
                                        @foreach ($staffs as $staff)
                                            <option value="{{ $staff->user_id }}"
                                                {{ old('user_id', $member->user_id ?? '') == $staff->user_id ? 'selected' : '' }}>
                                                {{ $staff->name }} - {{ $staff->position->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- গ্যারান্টর --}}
                                <div class="col-md-6 mb-3">
                                    <label>গ্যারান্টর</label>
                                    <input type="text" name="guarantor" class="form-control"
                                        value="{{ old('guarantor', $member->guarantor ?? '') }}">
                                </div>

                                {{-- নোমিনি নাম --}}
                                <div class="col-md-6 mb-3">
                                    <label>নোমিনি নাম</label>
                                    <input type="text" name="nominee" class="form-control"
                                        value="{{ old('nominee', $member->nominee ?? '') }}">
                                </div>

                                {{-- নোমিনি ফোন --}}
                                <div class="col-md-6 mb-3">
                                    <label>নোমিনি ফোন</label>
                                    <input type="text" name="nominee_phone" class="form-control"
                                        value="{{ old('nominee_phone', $member->nominee_phone ?? '') }}">
                                </div>

                                {{-- নোমিনি সম্পর্ক --}}
                                <div class="col-md-6 mb-3">
                                    <label>নোমিনির সম্পর্ক</label>
                                    <input type="text" name="nominee_relation" class="form-control"
                                        value="{{ old('nominee_relation', $member->nominee_relation ?? '') }}">
                                </div>

                                {{-- স্ট্যাটাস --}}
                                <div class="col-md-6 mb-3">
                                    <label>স্ট্যাটাস <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control" required>
                                        <option value="">স্ট্যাটাস নির্বাচন করুন</option>
                                        <option value="1"
                                            {{ old('status', $member->status ?? '') == 1 ? 'selected' : '' }}>সক্রিয়
                                        </option>
                                        <option value="2"
                                            {{ old('status', $member->status ?? '') == 2 ? 'selected' : '' }}>নিষ্ক্রিয়
                                        </option>
                                    </select>
                                </div>

                                {{-- পাসওয়ার্ড --}}
                                <div class="col-md-6 mb-3">
                                    <label>
                                        পাসওয়ার্ড
                                        {{ isset($member) ? '(প্রয়োজনে পরিবর্তন করুন)' : '' }}
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" name="password" value="123456" class="form-control"
                                        {{ isset($member) ? '' : 'required' }}>
                                </div>


                                {{-- Member Photo --}}
                                <div class="col-md-6 mb-3">
                                    <label>মেম্বার ছবি</label>
                                    <input type="file" name="member_photo" class="form-control">
                                    @if (isset($member) && $member->member_photo)
                                        <img src="{{ asset($member->member_photo) }}" width="80" class="mt-2">
                                    @endif
                                </div>

                                {{-- Nominee Photo --}}
                                <div class="col-md-6 mb-3">
                                    <label>নোমিনি ছবি</label>
                                    <input type="file" name="nominee_photo" class="form-control">
                                    @if (isset($member) && $member->nominee_photo)
                                        <img src="{{ asset($member->nominee_photo) }}" width="80" class="mt-2">
                                    @endif
                                </div>

                                {{-- NID Front --}}
                                <div class="col-md-6 mb-3">
                                    <label>NID Front</label>
                                    <input type="file" name="nid_front" class="form-control">
                                    @if (isset($member) && $member->nid_front)
                                        <img src="{{ asset($member->nid_front) }}" width="80" class="mt-2">
                                    @endif
                                </div>

                                {{-- NID Back --}}
                                <div class="col-md-6 mb-3">
                                    <label>NID Back</label>
                                    <input type="file" name="nid_back" class="form-control">
                                    @if (isset($member) && $member->nid_back)
                                        <img src="{{ asset($member->nid_back) }}" width="80" class="mt-2">
                                    @endif
                                </div>

                                {{-- Signature --}}
                                <div class="col-md-6 mb-3">
                                    <label>সিগনেচার</label>
                                    <input type="file" name="signature" class="form-control">
                                    @if (isset($member) && $member->signature)
                                        <img src="{{ asset($member->signature) }}" width="80" class="mt-2">
                                    @endif
                                </div>
                                
                                {{-- Signature --}}
                                <div class="col-md-6 mb-3">
                                    <label>পিডিএফ ফাইল</label>
                                    <input type="file"  name="pdf_file" class="form-control">
                                    @if (isset($member) && $member->pdf_file)
                                        <img src="{{ asset($member->pdf_file) }}" width="80" class="mt-2">
                                    @endif
                                </div>
                                {{-- fee --}}
                                <div class="col-md-6 mb-3">
                                    <label>ভর্তি ফি<span class="text-danger">*</span></label>
                                    <input type="number" id="fee_amount" disabled readonly value="250"
                                        class="form-control">
                                </div>

                                {{-- fee Amount --}}
                                <div class="col-md-6 mb-3">
                                    <label>ভর্তি ফি এর টাকা<span class="text-danger">*</span></label>
                                    <input type="number" required placeholder="টাকার পরিমান লিখুন" name="membership_fee"
                                        id="get_fee_amount" step="any" class="form-control"
                                        value="{{ old('membership_fee', $member->membership_fee ?? '') }}">
                                </div>

                                {{-- fee Amount --}}
                                <div class="col-md-6 mb-3">
                                    <label>নোট</label>
                                    <input type="text" placeholder="নোট লিখুন" name="amount" class="form-control"
                                        value="{{ old('note', $member->note ?? '') }}">
                                </div>

                            </div> {{-- row end --}}

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($member) ? 'আপডেট করুন' : 'জমা দিন' }}
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#memberform').on('submit', function(event) {
                let feeamount = parseFloat($('#fee_amount').val());
                let enterfeeamount = parseFloat($('#get_fee_amount').val());

                // Check for empty or non-number values
                if (isNaN(feeamount) || isNaN(enterfeeamount)) {
                    event.preventDefault();
                    Swal.fire("Error", "Please enter valid numbers", "error");
                    return false;
                }

                // Validation: entered amount must be >= fee amount
                if (enterfeeamount < feeamount) {
                    event.preventDefault();
                    $('#get_fee_amount').val(feeamount); // fixed
                    Swal.fire("Error", "Enter Valid Amount", "error");
                    return false;
                }
            });
        });
    </script>
@endsection
