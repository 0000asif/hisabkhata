@extends('admin.masterAdmin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Daily Collection</h4>
        </div>

        <div class="card-body">
            @include('components.alert')

            <form action="{{ route('collection.load') }}" method="POST">
                @csrf

                <div class="row">

                    <div class="col-md-4">
                        <label>Select Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label>Select Area</label>
                        <select name="area_id" class="form-control" required>
                            <option value="">Select Area</option>
                            @foreach ($areas as $a)
                                <option value="{{ $a->id }}">{{ $a->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <button class="btn btn-primary w-100">Load</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
@endsection
