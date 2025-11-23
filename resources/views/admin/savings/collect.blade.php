@extends('admin.masterAdmin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Daily Savings Collection</h4>
        </div>

        <div class="card-body">

            @include('components.alert')

            <form action="{{ route('savings.collect') }}" method="POST">
                @csrf

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Member</label>
                        <select name="member_id" class="form-control" required>
                            <option value="">Select Member</option>
                            @foreach ($members as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} - {{ $m->phone }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Date</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>

                </div>

                <button class="btn btn-primary">Collect Savings</button>

            </form>

        </div>
    </div>
@endsection
