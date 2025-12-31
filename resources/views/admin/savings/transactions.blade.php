@extends('admin.masterAdmin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Savings Transactions of {{ $account->member->name }}</h4>
        </div>

        <div class="card-body">

            <h5>Balance: {{ number_format($account->balance, 2) }}</h5>

            <form action="{{ route('savings.withdraw', $account->id) }}" method="POST" class="my-3">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <input type="number" name="amount" required class="form-control" placeholder="Withdraw Amount">
                    </div>

                    <div class="col-md-4">
                        <input type="date" name="date" required class="form-control" value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-danger">Withdraw</button>
                    </div>
                </div>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Balance After</th>
                        <th>Note</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($account->transactions as $t)
                        <tr>
                            <td>{{ $t->date }}</td>
                            <td>{{ ucfirst($t->transaction_type) }}</td>
                            <td>{{ number_format($t->amount, 2) }}</td>
                            <td>{{ number_format($t->balance_after, 2) }}</td>
                            <td>{{ $t->note }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
@endsection
