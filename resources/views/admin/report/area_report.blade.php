@extends('admin.masterAdmin')
@section('content')

<div class="report-card">

    <h3>🌍 Area Wise Collection</h3>

    <form class="filter-box">
        <div class="col-md-4">
            <label>Select Area</label>
            <select name="area_id" class="form-control" onchange="this.form.submit()">
                <option value="">Select...</option>
                @foreach($areas as $a)
                <option value="{{ $a->id }}" {{ request('area_id') == $a->id ? 'selected' : '' }}>
                    {{ $a->name }}
                </option>
                @endforeach
            </select>
        </div>
    </form>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Member</th>
                <th>Total Loan</th>
                <th>Total Paid</th>
                <th>Remaining</th>
            </tr>
        </thead>

        <tbody>
            @foreach($members as $m)
            <tr>
                <td>{{ $m->name }}</td>
                <td>{{ $m->loans->sum('total_amount') }}</td>
                <td class="text-success">{{ $m->transactions->sum('loan_amount') }}</td>
                <td class="text-danger">{{ $m->loans->sum('remaining_total') }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>

</div>
@endsection
