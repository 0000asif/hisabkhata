@extends('admin.masterAdmin')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>All Loans</h4>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped w-100" id="dt-responsive">
            <thead class="bg-light">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Member</th>
                    <th>Area</th>
                    <th>Loan Amount</th>
                    <th>Total Payable</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Installment</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($loans as $loan)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $loan->date }}</td>

                    <td>{{ $loan->member->name }}</td>

                    <td>{{ $loan->area->name }}</td>

                    <td>{{ number_format($loan->loan_amount, 2) }}</td>

                    <td>{{ number_format($loan->total_amount, 2) }}</td>

                    <td>
                        {{-- Total Paid = Sum of installment paid --}}
                        {{ number_format($loan->installments->sum('paid_amount'), 2) }}
                    </td>

                    <td class="text-danger fw-bold">
                        {{ number_format($loan->installments->sum('remaining_amount'), 2) }}
                    </td>

                    <td>{{ $loan->loan_count }}</td>

                    <td>
                        <a href="{{ route('loan.installments', $loan->id) }}" 
                           class="btn btn-primary btn-sm">
                           Installments
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


    </div>
</div>

@endsection
