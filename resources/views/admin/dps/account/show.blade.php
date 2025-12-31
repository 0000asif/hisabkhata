@extends('admin.masterAdmin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>DPS Details</h4>
    </div>

    <div class="card-body">

        <h5>Member: {{ $dps->member->name }}</h5>
        <p>Monthly Deposit: {{ $dps->monthly_deposit }}</p>
        <p>Mature Amount: {{ $dps->mature_amount }}</p>
        <p>Mature Date: {{ $dps->mature_date }}</p>

        <hr>

        <h4>DPS Installments</h4>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Month</th>
                <th>Due Date</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Pay</th>
            </tr>
            </thead>

            @foreach ($dps->installments as $ins)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ins->due_date }}</td>
                    <td>{{ $ins->amount }}</td>
                    <td>{{ $ins->status }}</td>
                    <td>
                        @if($ins->status == 'pending')
                        <form action="{{ route('dps.pay', $ins->id) }}" method="POST">
                            @csrf
                            <input type="number" name="amount" value="{{ $ins->amount }}" class="form-control" required>
                            <button class="btn btn-success btn-sm mt-1">Pay</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach

        </table>

        @if($dps->status != 'closed')
        <a href="{{ route('dps.withdraw', $dps->id) }}" class="btn btn-danger mt-3">
            DPS Withdraw
        </a>
        @endif

    </div>
</div>

@endsection
