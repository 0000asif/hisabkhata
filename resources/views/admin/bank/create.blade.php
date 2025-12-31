@extends('admin.masterAdmin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>ব্যাংক এড করুন</h4>
    </div>

    <div class="card-body">
        @include('components.alert')

        <form action="{{ route('bank.store') }}" method="POST">
            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>ব্যাংকের নাম *</label>
                    <input type="text" name="bank_name" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>ব্রাঞ্চ নাম *</label>
                    <input type="text" name="branch_name" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>একাউন্টের নাম *</label>
                    <input type="text" name="account_name" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>একাউন্ট টাইপ *</label>
                    <input type="text" name="account_type" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>একাউন্ট নম্বর *</label>
                    <input type="text" name="account_number" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>হিসাব শুরুর টাকাঃ</label>
                    <input type="number" step="0.01" name="opening_balance" class="form-control" value="0.00">
                </div>

                <div class="col-md-6 mb-3">
                    <label>স্ট্যাটাস *</label>
                    <select name="status" class="form-control" required>
                        <option value="1">সক্রিয়</option>
                        <option value="0">নিষ্ক্রিয়</option>
                    </select>
                </div>

            </div>

            <button class="btn btn-primary mt-3">জমা দিন</button>

        </form>

    </div>
</div>

@endsection

