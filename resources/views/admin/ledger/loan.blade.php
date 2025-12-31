@extends('admin.masterAdmin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Loan Ledger</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-3">
                <table class="table table-bordered w-100" id="dt-responsive">
                    <thead>
                        <tr>
                            <th>Loan ID</th>
                            <th>Member</th>
                            <th>Loan Amount</th>
                            <th>Total Paid</th>
                            <th>Remaining</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loans as $loan)
                            @php
                                $totalPaid = $loan->installments->sum('paid_amount');
                                $remaining = $loan->total_amount - $totalPaid;
                            @endphp
                            <tr>
                                <td>{{ $loan->id }}</td>
                                <td>{{ $loan->member->name }}</td>
                                <td>{{ number_format($loan->loan_amount, 2) }}</td>
                                <td>{{ number_format($totalPaid, 2) }}</td>
                                <td>{{ number_format($remaining, 2) }}</td>
                                <td>
                                    @if ($remaining <= 0)
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($totalPaid > 0)
                                        <span class="badge bg-warning">Partial</span>
                                    @else
                                        <span class="badge bg-danger">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
