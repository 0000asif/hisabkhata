@extends('admin.masterAdmin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ $member->name }} Ledger</h4>
            <a href="{{ route('member.ledger.index') }}" class="btn btn-primary btn-sm">
                Back
            </a>
        </div>
        <div class="card-body">

            <div class="table-responsive mt-3">
                <table class="table table-bordered w-100" id="dt-responsive">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Loan ID</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Running Balance</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $t)
                            <tr>
                                <td>{{ $t->date }}</td>
                                <td>{{ $t->loan_id ?? '-' }}</td>
                                <td>{{ $t->transaction_type == 'debit' ? number_format($t->loan_amount, 2) : '-' }}</td>
                                <td>{{ $t->transaction_type == 'credit' ? number_format($t->loan_amount, 2) : '-' }}</td>
                                <td>{{ number_format($t->running_balance, 2) }}</td>
                                <td>{{ $t->note }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
