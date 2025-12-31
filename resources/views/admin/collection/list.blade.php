@extends('admin.masterAdmin')

@section('content')
<div class="card">
    <div class="card-header bg-dark text-white">
        <h4>Today's Installment Collection</h4>
        <small>Date: {{ date('d M, Y', strtotime(request('date'))) }}</small>
    </div>

    <div class="card-body">

        @include('components.alert')

        <div class="alert alert-info d-flex justify-content-between">
    <div><b>Total Members:</b> {{ count($installments) }}</div>
    <div><b>Total Due:</b> 
        {{ number_format($installments->sum(fn($i)=> 
            ($i->remaining_amount + ($i->late_fee - $i->late_fee_paid))
        ), 2) }}
    </div>
    <div><b>Total Late Fee:</b> 
        {{ number_format($installments->sum(fn($i)=> $i->late_fee - $i->late_fee_paid), 2) }}
    </div>
</div>

        <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered table-hover w-100">

                <thead class="bg-secondary text-white">
                    <tr>
                        <th>#</th>
                        <th>Member Info</th>
                        <th>Installment</th>
                        <th>Paid</th>
                        <th>Remaining</th>
                        <th>Late Fee</th>
                        <th>Total Due</th>
                        <th>Pay Now</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($installments as $i)

                        @php
                            $late_due = $i->late_fee - $i->late_fee_paid;
                            $total_due = $i->remaining_amount + $late_due;
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <!-- MEMBER INFORMATION -->
                            <td>
                                <strong>{{ $i->member->name }}</strong> <br>
                                <small>Phone: {{ $i->member->phone }}</small> <br>
                                <small>Area: {{ $i->member->area->name }}</small>
                            </td>

                            <!-- INSTALLMENT AMOUNT -->
                            <td>
                                {{ number_format($i->amount, 2) }}
                            </td>

                            <!-- TOTAL PAID -->
                            <td>
                                {{ number_format($i->paid_amount, 2) }}
                            </td>

                            <!-- REMAINING INSTALLMENT -->
                            <td class="text-danger fw-bold">
                                {{ number_format($i->remaining_amount, 2) }}
                            </td>

                            <!-- LATE FEE -->
                            <td class="{{ $late_due > 0 ? 'text-danger fw-bold' : '' }}">
                                {{ number_format($late_due, 2) }}
                                @if ($late_due > 0)
                                    <br><span class="badge bg-danger">Late</span>
                                @endif
                            </td>

                            <!-- TOTAL DUE -->
                            <td class="text-primary fw-bold">
                                {{ number_format($total_due, 2) }}
                            </td>

                            <!-- PAYMENT FORM -->
                            <td>
                                @if ($total_due > 0)
                                    <form action="{{ route('collection.pay', $i->id) }}" method="POST" class="d-flex gap-2">
                                        @csrf
                                        <input type="number" step="0.01" 
                                               name="amount" 
                                               class="form-control form-control-sm"
                                               placeholder="Pay Amount"
                                               required
                                               style="width:120px;">
                                        <button class="btn btn-success btn-sm">Pay</button>
                                    </form>
                                @else
                                    <span class="badge bg-success">Paid</span>
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

