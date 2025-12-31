@extends('admin.masterAdmin')
@section('content')

<div class="report-card">

    <h3>💰 Late Fee Collection History</h3>

    <table class="table table-bordered table-hover mt-3">
        <thead>
            <tr>
                <th>Date</th>
                <th>Member</th>
                <th>Loan Amount</th>
                <th>Late Fee Paid</th>
            </tr>
        </thead>

        <tbody>
            @foreach($latePayments as $p)
            <tr>
                <td>{{ $p->date }}</td>
                <td>{{ $p->member->name }}</td>
                <td>{{ $p->loan->loan_amount }}</td>
                <td class="text-success">{{ $p->loan_amount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
