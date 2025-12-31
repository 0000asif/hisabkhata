@extends('admin.masterAdmin')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>Savings Report</h4>
    </div>

    <div class="card-body">

        <form action="{{ route('savings.report') }}" method="GET">
            <div class="row">

                <div class="col-md-3">
                    <label>Member</label>
                    <select name="member_id" class="form-control select2_demo">
                        <option value="">All Members</option>
                        @foreach ($members as $m)
                            <option value="{{ $m->id }}"
                                {{ request('member_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->name }} (ID: {{ $m->id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>From Date</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <div class="col-md-3">
                    <label>To Date</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>

                <div class="col-md-3">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                </div>

            </div>
        </form>

        @isset($transactions)
            <hr>

            <h5>Total Deposit: <b>{{ number_format($totalDeposit, 2) }}</b></h5>
            <h5>Total Withdraw: <b>{{ number_format($totalWithdraw, 2) }}</b></h5>
            <h5>Net Balance: <b>{{ number_format($totalDeposit - $totalWithdraw, 2) }}</b></h5>

            <hr>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Member</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Balance After</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($transactions as $t)
                        <tr>
                            <td>{{ $t->date }}</td>
                            <td>{{ $t->account->member->name }}</td>
                            <td>
                                @if($t->transaction_type == 'deposit')
                                    <span class="badge bg-success">Deposit</span>
                                @else
                                    <span class="badge bg-danger">Withdraw</span>
                                @endif
                            </td>
                            <td>{{ number_format($t->amount, 2) }}</td>
                            <td>{{ number_format($t->balance_after, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endisset
    </div>

</div>

@endsection
