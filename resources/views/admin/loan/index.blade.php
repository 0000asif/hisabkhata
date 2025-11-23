@extends('admin.masterAdmin')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Loan List</h4>
            <a href="{{ route('loan.create') }}" class="btn btn-primary btn-sm">+ New Loan</a>
        </div>

        <div class="card-body">

            @include('components.alert')

            <div class="table-responsive mt-3">
                <table class="table table-bordered w-100" id="dt-responsive">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Member</th>
                            <th>Area</th>
                            <th>Loan Amount</th>
                            <th>Total Payable</th>
                            <th>Installments</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($loans as $key => $loan)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $loan->date }}</td>
                                <td>{{ $loan->member->name }}</td>
                                <td>{{ $loan->area->name }}</td>
                                <td>{{ number_format($loan->loan_amount, 2) }}</td>
                                <td>{{ number_format($loan->total_amount, 2) }}</td>
                                <td>{{ $loan->loan_count }}</td>
                                <td>
                                    @php
                                        $due = $loan->installments->sum('remaining_amount');
                                    @endphp

                                    @if ($due <= 0)
                                        <span class="badge bg-success">Paid</span>
                                    @else
                                        <span class="badge bg-danger">Due: {{ $due }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('loan.details', $loan->id) }}" class="btn btn-info btn-sm">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $loans->links() }}

        </div>
    </div>
@endsection
