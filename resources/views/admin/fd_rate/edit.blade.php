@extends('admin.masterAdmin')

@section('content')
    <div class="card">

        <div class="card-header">
            <h4>Edit FD Rate</h4>
        </div>

        <div class="card-body">
            @include('components.alert')

            <form action="{{ route('fd.rate.update', $rate->id) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Months</label>
                    <input type="number" name="months" value="{{ $rate->months }}" class="form-control" required>
                </div>

                <div class="form-group mt-2">
                    <label>Interest Rate (%)</label>
                    <input type="number" step="0.01" name="rate" value="{{ $rate->rate }}" class="form-control"
                        required>
                </div>

                <button class="btn btn-primary mt-3">Update</button>
            </form>

        </div>
    </div>
@endsection
