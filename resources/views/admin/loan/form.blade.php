@extends('admin.masterAdmin')
@section('content')
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">

                    <div class="card-header">
                        <h5 class="box-title">
                            {{ isset($loan) ? 'লোন সম্পাদনা করুন' : 'নতুন লোন যোগ করুন' }}
                        </h5>
                    </div>

                    <div class="card-body">
                        @include('components.alert')

                        <form action="{{ isset($loan) ? route('loan.update', $loan->id) : route('loan.store') }}"
                            method="POST" id="loanForm">

                            @csrf

                            @if (isset($loan))
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

                                {{-- Staff (User) --}}
                                <div class="col-md-6 mb-3">
                                    <label>ইউজার নির্বাচন করুন <span class="text-danger">*</span></label>
                                    <select name="user_id" class="form-control" required>
                                        <option value="">ইউজার নির্বাচন করুন</option>
                                        @foreach ($staffs as $staff)
                                            <option value="{{ $staff->user_id }}"
                                                {{ old('user_id', $loan->user_id ?? '') == $staff->user_id ? 'selected' : '' }}>
                                                {{ $staff->name }} ({{ $staff->position->name }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Area --}}
                                <div class="col-md-6 mb-3">
                                    <label>এরিয়া নির্বাচন করুন <span class="text-danger">*</span></label>
                                    <select name="area_id" class="form-control" required>
                                        <option value="">এরিয়া নির্বাচন করুন</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->id }}"
                                                {{ old('area_id', $loan->area_id ?? '') == $area->id ? 'selected' : '' }}>
                                                {{ $area->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Member --}}
                                <div class="col-md-6 mb-3">
                                    <label>মেম্বার নির্বাচন করুন <span class="text-danger">*</span></label>
                                    <select name="member_id" class="form-control" required>
                                        <option value="">মেম্বার নির্বাচন করুন</option>
                                        @foreach ($members as $member)
                                            <option value="{{ $member->id }}"
                                                {{ old('member_id', $loan->member_id ?? '') == $member->id ? 'selected' : '' }}>
                                                {{ $member->name }} - {{ $member->phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Loan Amount --}}
                                <div class="col-md-6 mb-3">
                                    <label>লোনের পরিমাণ <span class="text-danger">*</span></label>
                                    <input type="number" step="any" name="loan_amount" id="loan_amount"
                                        class="form-control" value="{{ old('loan_amount', $loan->loan_amount ?? '') }}"
                                        required>
                                </div>

                                {{-- Interest Type --}}
                                <div class="col-md-6 mb-3">
                                    <label>ইন্টারেস্ট ধরণ <span class="text-danger">*</span></label>
                                    <select name="interest_type" id="interest_type" class="form-control" required>
                                        <option value="">নির্বাচন করুন</option>
                                        <option value="percent"
                                            {{ old('interest_type', $loan->interest_type ?? '') == 'percent' ? 'selected' : '' }}>
                                            শতাংশ
                                        </option>
                                        <option value="flat"
                                            {{ old('interest_type', $loan->interest_type ?? '') == 'flat' ? 'selected' : '' }}>
                                            ফ্লাট
                                        </option>
                                    </select>
                                </div>

                                {{-- Interest --}}
                                <div class="col-md-6 mb-3">
                                    <label>ইন্টারেস্ট (%) বা (টাকা)</label>
                                    <input type="number" step="any" name="interest" id="interest" class="form-control"
                                        value="{{ old('interest', $loan->interest ?? '') }}">
                                </div>

                                {{-- Total Amount --}}
                                <div class="col-md-6 mb-3">
                                    <label>মোট টাকা (Auto Calculate)</label>
                                    <input type="number" step="any" name="total_amount" id="total_amount"
                                        class="form-control" readonly
                                        value="{{ old('total_amount', $loan->total_amount ?? '') }}">
                                </div>

                                {{-- Installment Type --}}
                                <div class="col-md-6 mb-3">
                                    <label>কিস্তির ধরণ <span class="text-danger">*</span></label>
                                    <select name="installment_type" class="form-control" required>
                                        <option value="">নির্বাচন করুন</option>
                                        <option value="daily"
                                            {{ old('installment_type', $loan->installment_type ?? '') == 'daily' ? 'selected' : '' }}>
                                            দৈনিক
                                        </option>
                                        <option value="weekly"
                                            {{ old('installment_type', $loan->installment_type ?? '') == 'weekly' ? 'selected' : '' }}>
                                            সাপ্তাহিক
                                        </option>
                                        <option value="fortnightly"
                                            {{ old('installment_type', $loan->installment_type ?? '') == 'fortnightly' ? 'selected' : '' }}>
                                            পাক্ষিক
                                        </option>
                                        <option value="monthly"
                                            {{ old('installment_type', $loan->installment_type ?? '') == 'monthly' ? 'selected' : '' }}>
                                            মাসিক
                                        </option>
                                        <option value="6month"
                                            {{ old('installment_type', $loan->installment_type ?? '') == '6month' ? 'selected' : '' }}>
                                            ৬ মাস
                                        </option>
                                    </select>
                                </div>

                                {{-- Loan Count --}}
                                <div class="col-md-6 mb-3">
                                    <label>কিস্তির সংখ্যা <span class="text-danger">*</span></label>
                                    <input type="number" name="loan_count" id="loan_count" class="form-control"
                                        value="{{ old('loan_count', $loan->loan_count ?? '') }}" required>
                                </div>

                                {{-- Single Installment --}}
                                <div class="col-md-6 mb-3">
                                    <label>প্রতি কিস্তির টাকা (Auto)</label>
                                    <input type="number" step="any" name="single_loan_amount" id="single_loan_amount"
                                        class="form-control" readonly
                                        value="{{ old('single_loan_amount', $loan->single_loan_amount ?? '') }}">
                                </div>

                                {{-- Note --}}
                                <div class="col-md-12 mb-3">
                                    <label>নোট</label>
                                    <textarea name="note" class="form-control" rows="3">{{ old('note', $loan->note ?? '') }}</textarea>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary mt-3">
                                {{ isset($loan) ? 'আপডেট করুন' : 'জমা দিন' }}
                            </button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Auto Calculation --}}
    <script>
        function calculateLoan() {
            let amount = parseFloat(document.getElementById("loan_amount").value) || 0;
            let interest = parseFloat(document.getElementById("interest").value) || 0;
            let type = document.getElementById("interest_type").value;
            let count = parseFloat(document.getElementById("loan_count").value) || 0;

            let total = 0;

            if (type === 'percent') {
                total = amount + (amount * interest / 100);
            } else if (type === 'flat') {
                total = amount + interest;
            }

            document.getElementById("total_amount").value = total.toFixed(2);

            if (count > 0) {
                document.getElementById("single_loan_amount").value = (total / count).toFixed(2);
            }
        }

        document.querySelectorAll("#loan_amount, #interest, #interest_type, #loan_count")
            .forEach(el => el.addEventListener("input", calculateLoan));
    </script>
@endsection
