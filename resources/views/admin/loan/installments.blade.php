@extends('admin.masterAdmin')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>কিস্তি দেওয়ার তারিখ সমূহ (Installment Schedule)</h4>
    </div>

    <div class="card-body">

        {{-- Loan Basic Info --}}
        <h5>Loan Information</h5>
        <table class="table table-bordered mt-3">
            <tr>
                <th>Loan Date</th>
                <td>{{ $loan->date }}</td>
            </tr>
            <tr>
                <th>Member Name</th>
                <td>{{ $loan->member->name }}</td>
            </tr>
            <tr>
                <th>Total Loan</th>
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
                <th>Total Late Fee</th>
                <td class="text-danger fw-bold">
                    {{ $loan->installments->sum('late_fee') }}
                </td>
            </tr>
        </table>


        {{-- Installment list --}}
        <h5 class="mt-4">Installment Schedule</h5>

        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Due Date</th>
                        <th>Installment Amount</th>
                        <th>Paid</th>
                        <th>Remaining</th>
                        <th>Late Fee</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($loan->installments as $install)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ date('d M, Y', strtotime($install->due_date)) }}
                        </td>

                        <td>{{ number_format($install->amount, 2) }}</td>
                        <td>{{ number_format($install->paid_amount, 2) }}</td>
                        <td>{{ number_format($install->remaining_amount, 2) }}</td>

                        <td class="{{ $install->late_fee > 0 ? 'text-danger' : '' }}">
                            {{ number_format($install->late_fee, 2) }}
                        </td>

                        <td>
                            @if ($install->status == 'paid')
                                <span class="badge bg-success">Paid</span>
                            @elseif ($install->status == 'partial')
                                <span class="badge bg-warning">Partial</span>
                            @else
                                {{-- If due date passed --}}
                                @if (now()->gt($install->due_date))
                                    <span class="badge bg-danger">Overdue</span>
                                @else
                                    <span class="badge bg-secondary">Pending</span>
                                @endif
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
