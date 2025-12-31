@extends('admin.masterAdmin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>ব্যাংক আপডেট করুন</h4>
    </div>

    <div class="card-body">
        @include('components.alert')

        <form action="{{ route('bank.update',$bank->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>ব্যাংকের নাম *</label>
                    <input type="text" name="bank_name" class="form-control"
                        value="{{ $bank->bank_name }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>ব্রাঞ্চ নাম *</label>
                    <input type="text" name="branch_name" class="form-control"
                        value="{{ $bank->branch_name }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>একাউন্টের নাম *</label>
                    <input type="text" name="account_name" class="form-control"
                        value="{{ $bank->account_name }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>একাউন্ট টাইপ *</label>
                    <input type="text" name="account_type" class="form-control"
                        value="{{ $bank->account_type }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>একাউন্ট নম্বর *</label>
                    <input type="text" name="account_number" class="form-control"
                        value="{{ $bank->account_number }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>হিসাব শুরুর টাকাঃ</label>
                    <input type="number" step="0.01" name="opening_balance"
                        value="{{ $bank->opening_balance }}" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>স্ট্যাটাস *</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $bank->status==1?'selected':'' }}>সক্রিয়</option>
                        <option value="0" {{ $bank->status==0?'selected':'' }}>নিষ্ক্রিয়</option>
                    </select>
                </div>

            </div>

            <button class="btn btn-primary mt-3">আপডেট করুন</button>

        </form>

    </div>
</div>

@endsection
