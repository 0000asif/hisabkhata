@extends('admin.masterAdmin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Add FD Rate</h4>
        </div>

        <div class="card-body">
            @include('components.alert')

            <form action="{{ route('fd.rate.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Duration (Months)</label>
                    <input type="number" name="months" class="form-control" required>
                </div>

                <div class="form-group mt-2">
                    <label>Interest Rate (%)</label>
                    <input type="number" step="0.01" name="rate" class="form-control" required>
                </div>

                <button class="btn btn-primary mt-3">Save</button>
            </form>

        </div>
    </div>
@endsection
