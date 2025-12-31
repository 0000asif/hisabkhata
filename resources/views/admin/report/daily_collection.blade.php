@extends('admin.masterAdmin')
@section('content')

<div class="report-card">

    <h3>📌 Daily Collection ({{ $date }})</h3>

    <form class="filter-box" method="GET">
        <div class="row">
            <div class="col-md-4">
                <label><b>Date</b></label>
                <input type="date" name="date" value="{{ $date }}" class="form-control">
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
                <th>Loan Amount</th>
                <th>Paid</th>
                <th>Note</th>
            </tr>
        </thead>

        <tbody>
            @foreach($transactions as $t)
            <tr>
                <td>{{ $t->member->name }}</td>
                <td>{{ $t->loan->loan_amount }}</td>
                <td class="text-success"><b>{{ $t->loan_amount }}</b></td>
                <td>{{ $t->note }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>

</div>
@endsection
