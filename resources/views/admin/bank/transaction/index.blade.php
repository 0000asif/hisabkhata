@extends('admin.masterAdmin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>সকল ব্যাংক লেনদেন</h4>
    </div>

    <div class="card-body">

        <table class="table table-bordered w-100" id="dt-responsive">
            <thead class="thead-light">
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Bank</th>
                    <th>Account</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Description</th>
                </tr>
            </thead>

            <tbody>
                @foreach($transactions as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d-m-Y', strtotime($t->date)) }}</td>
                    <td>{{ $t->account->bank_name }}</td>
                    <td>{{ $t->account->account_number }}</td>
                    <td>
                        @if($t->type=='deposit')
                            <span class="badge badge-success">Deposit</span>
                        @else
                            <span class="badge badge-danger">Withdraw</span>
                        @endif
                    </td>
                    <td>{{ number_format($t->amount,2) }}</td>
                    <td>{{ $t->description }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

@endsection
