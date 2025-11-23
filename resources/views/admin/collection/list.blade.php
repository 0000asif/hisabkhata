@extends('admin.masterAdmin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Today's Collection</h4>
        </div>

        <div class="card-body">

            @include('components.alert')

            <div class="table-responsive mt-3">
                <table class="table table-bordered w-100" id="dt-responsive">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Loan Amount</th>
                            <th>Installment</th>
                            <th>Remaining</th>
                            <th>Member Balance</th>
                            <th>Pay</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($installments as $i)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $i->member->name }}</td>
                                <td>{{ $i->loan->loan_amount }}</td>
                                <td>{{ number_format($i->amount, 2) }}</td>
                                <td>{{ number_format($i->remaining_amount, 2) }}</td>

                                <td>
                                    @php
                                        $balance = \App\Models\Transaction::where('member_id', $i->member_id)->sum(
                                            'loan_amount',
                                        );
                                    @endphp
                                    <b>{{ $balance }}</b>
                                </td>

                                <td>
                                    @if ($i->remaining_amount > 0)
                                        <form action="{{ route('collection.pay', $i->id) }}" method="POST"
                                            class="d-flex gap-2">
                                            @csrf
                                            <input type="number" step="0.01" name="amount" class="form-control"
                                                style="width:120px" required>
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
