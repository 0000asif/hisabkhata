@extends('admin.masterAdmin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>All Member Loan Collection</h4>
        </div>

        <div class="card-body">

            @include('components.alert')

            <div class="table-responsive mt-3">
                <table class="table table-bordered w-100" id="dt-responsive">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Loan Amount</th>
                            <th>Total Payable</th>
                            <th>Total Paid</th>
                            <th>Remaining</th>
                            <th>Status</th>
                            <th>Installment Pay</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($loans as $loan)
                            @php
                                $totalPaid = $loan->installments->sum('paid_amount');
                                $remaining = $loan->total_amount - $totalPaid;
                                $nextInstallment = $loan->installments->where('status', '!=', 'paid')->first();
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <strong>{{ $loan->member->name }}</strong><br>
                                    <small>{{ $loan->member->phone }}</small>
                                </td>

                                <td>{{ number_format($loan->loan_amount, 2) }}</td>

                                <td>{{ number_format($loan->total_amount, 2) }}</td>

                                <td>{{ number_format($totalPaid, 2) }}</td>

                                <td class="{{ $remaining <= 0 ? 'text-success' : 'text-danger' }}">
                                    <strong>{{ number_format($remaining, 2) }}</strong>
                                </td>

                                <td>
                                    @if ($remaining <= 0)
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($totalPaid > 0)
                                        <span class="badge bg-warning">Partial</span>
                                    @else
                                        <span class="badge bg-danger">Pending</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($nextInstallment)
                                        <form action="{{ route('collection.pay', $nextInstallment->id) }}" method="POST"
                                            class="d-flex gap-2">
                                            @csrf
                                            <input type="number" name="amount" step="0.01"
                                                class="form-control form-control-sm" placeholder="Enter Amount" required
                                                style="width:120px;">
                                            <button class="btn btn-sm btn-primary">Pay</button>
                                        </form>

                                        <small>
                                            Installment Amount: {{ number_format($nextInstallment->amount, 2) }} <br>
                                            Remaining: {{ number_format($nextInstallment->remaining_amount, 2) }}
                                        </small>
                                    @else
                                        <span class="badge bg-success">Completed</span>
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
