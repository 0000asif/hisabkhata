@extends('admin.masterAdmin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>ব্যাংক ট্রান্সফার</h4>
    </div>

    <div class="card-body">

        @include('components.alert')

        <form action="{{ route('bank-transfer.store') }}" method="POST">
            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>From Bank *</label>
                    <select name="from_account_id" class="form-control" required>
                        <option value="">Select</option>
                        @foreach($accounts as $acc)
                            <option value="{{ $acc->id }}">{{ $acc->bank_name }} ({{ $acc->account_number }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>To Bank *</label>
                    <select name="to_account_id" class="form-control" required>
                        <option value="">Select</option>
                        @foreach($accounts as $acc)
                            <option value="{{ $acc->id }}">{{ $acc->bank_name }} ({{ $acc->account_number }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Amount *</label>
                    <input type="number" step="0.01" name="amount" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Date *</label>
                    <input type="date" name="date" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Description</label>
                    <input type="text" name="description" class="form-control">
                </div>

            </div>

            <button class="btn btn-warning mt-3">Transfer</button>

        </form>

    </div>
</div>

@endsection
