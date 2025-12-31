@extends('admin.masterAdmin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>DPS অ্যাকাউন্ট তালিকা</h4>
        </div>

        <div class="card-body">
            @include('components.alert')

            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Member</th>
                        <th>Monthly Deposit</th>
                        <th>Mature Amount</th>
                        <th>Mature Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                @foreach ($dps as $a)
                    <tr>
                        <td>{{ $a->id }}</td>
                        <td>{{ $a->member->name }}</td>
                        <td>{{ $a->monthly_deposit }}</td>
                        <td>{{ $a->mature_amount }}</td>
                        <td>{{ $a->mature_date }}</td>
                        <td>{{ ucfirst($a->status) }}</td>
                        <td>
                            <a href="{{ route('dps.account.show', $a->id) }}" class="btn btn-info btn-sm">Details</a>
                        </td>
                    </tr>
                @endforeach

            </table>

        </div>
    </div>
@endsection
