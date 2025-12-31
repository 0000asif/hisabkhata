@extends('admin.masterAdmin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>All Member Savings</h4>
        </div>

        <div class="card-body">

            <div class="table-responsive mt-3">
                <table class="table table-bordered w-100" id="dt-responsive">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Phone</th>
                            <th>Balance</th>
                            <th>Transactions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($accounts as $acc)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $acc->member->name }}</td>
                                <td>{{ $acc->member->phone }}</td>
                                <td><strong>{{ number_format($acc->balance, 2) }}</strong></td>
                                <td>
                                    <a href="{{ route('savings.transactions', $acc->id) }}" class="btn btn-sm btn-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>
@endsection
