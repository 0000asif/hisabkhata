@extends('admin.masterAdmin')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Daily Collection</h4>
    </div>

    <div class="card-body">

        <form method="GET" action="">
            <div class="row">
                <div class="col-md-4">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control"
                           value="{{ request('date', date('Y-m-d')) }}">
                </div>

                <div class="col-md-4">
                    <label>Area</label>
                    <select name="area_id" class="form-control">
                        <option value="">Select Area</option>
                        @foreach ($areas as $a)
                            <option value="{{ $a->id }}">{{ $a->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <button class="btn btn-primary mt-4">Search</button>
                </div>
            </div>
        </form>

        <hr>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Installment Amount</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Late Fee</th>
                    <th>Pay Amount</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($installments as $i)
                <tr>
                    <td>{{ $i->member->name }}</td>
                    <td>{{ $i->amount }}</td>
                    <td>{{ $i->paid_amount }}</td>
                    <td>{{ $i->remaining_amount }}</td>
                    <td>
                        @if ($i->late_fee > 0)
                            <span class="text-danger">{{ $i->late_fee }}</span>
                        @else
                            <span class="text-success">0</span>
                        @endif
                    </td>

                    <td>
                        <form action="{{ route('collection.pay', $i->id) }}" method="POST">
                            @csrf
                            <input type="number" name="amount" class="form-control" min="1" required>
                    </td>

                    <td>
                            <button class="btn btn-success btn-sm">Pay</button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection
