@extends('admin.masterAdmin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>ব্যাংক লেনদেন করুন (জমা / উত্তোলন)</h4>
    </div>

    <div class="card-body">

        @include('components.alert')

        <form action="{{ route('bank-transaction.store') }}" method="POST">
            @csrf

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label>ব্যাংক নির্বাচন করুন *</label>
                    <select name="bank_account_id" class="form-control" required>
                        <option value="">Select</option>
                        @foreach($accounts as $acc)
                            <option value="{{ $acc->id }}">{{ $acc->bank_name }} ({{ $acc->account_number }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>লেনদেনের ধরন *</label>
                    <select name="type" class="form-control" required>
                        <option value="">Select</option>
                        <option value="deposit">জমা</option>
                        <option value="withdraw">উত্তোলন</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>টাকার পরিমাণ *</label>
                    <input type="number" name="amount" step="0.01" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>তারিখ *</label>
                    <input type="date" name="date" class="form-control" required>
                </div>

                <div class="col-md-8 mb-3">
                    <label>বর্ণনা (ঐচ্ছিক)</label>
                    <input type="text" name="description" class="form-control">
                </div>

            </div>

            <button class="btn btn-primary mt-3">জমা দিন</button>

        </form>

    </div>
</div>

@endsection
