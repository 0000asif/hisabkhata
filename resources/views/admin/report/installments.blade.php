@extends('admin.masterAdmin')
@section('content')

<div class="report-card">

    <h3>📅 Installment Report</h3>

    <form method="GET" class="filter-box">
        <div class="row">
            <div class="col-md-4">
                <label><b>Select Date</b></label>
                <input type="date" name="date" value="{{ request('date') }}" class="form-control">
            </div>

            <div class="col-md-3">
                <label>&nbsp;</label>
                <button class="btn btn-primary w-100">Search</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Member</th>
                <th>Due Date</th>
                <th>Amount</th>
                <th>Paid</th>
                <th>Remaining</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($installments as $i)
            <tr>
                <td>{{ $i->member->name }}</td>
                <td>{{ $i->due_date }}</td>
                <td>{{ number_format($i->amount,2) }}</td>
                <td class="text-success">{{ number_format($i->paid_amount,2) }}</td>
                <td class="text-danger">{{ number_format($i->remaining_amount,2) }}</td>
                <td>
                    @if ($i->status == 'paid')
                    <span class="badge bg-success">Paid</span>
                    @elseif($i->status == 'partial')
                    <span class="badge bg-warning">Partial</span>
                    @else
                    <span class="badge bg-danger">Due</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
