@extends('admin.masterAdmin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Loan Details</h4>
        </div>

        <div class="card-body">

            <h5>Loan Information</h5>

            <div class="table-responsive mt-3">
                <table class="table table-bordered w-100" id="dt-responsive">
                    <tr>
                        <th>Date</th>
                        <td>{{ $loan->date }}</td>
                    </tr>
                    <tr>
                        <th>Member</th>
                        <td>{{ $loan->member->name }}</td>
                    </tr>
                    <tr>
                        <th>Area</th>
                        <td>{{ $loan->area->name }}</td>
                    </tr>
                    <tr>
                        <th>Loan Amount</th>
                        <td>{{ $loan->loan_amount }}</td>
                    </tr>
                    <tr>
                        <th>Total Payable</th>
                        <td>{{ $loan->total_amount }}</td>
                    </tr>
                    <tr>
                        <th>Installment Amount</th>
                        <td>{{ $loan->single_loan_amount }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
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
                    </tr>
                </table>
            </div>


            <h5 class="mt-4">Installment Schedule</h5>

            <div class="table-responsive mt-3">
                <table class="table table-bordered w-100" id="dt-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Due Date</th>
                            <th>Amount</th>
                            <th>Paid</th>
                            <th>Remaining</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($loan->installments as $i)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $i->due_date }}</td>
                                <td>{{ $i->amount }}</td>
                                <td>{{ $i->paid_amount }}</td>
                                <td>{{ $i->remaining_amount }}</td>
                                <td>{{ $i->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
