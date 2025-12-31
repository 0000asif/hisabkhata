@extends('admin.masterAdmin')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>DPS প্লানসমূহ</h4>
            <a href="{{ route('dps.plan.create') }}" class="btn btn-primary btn-sm">নতুন প্লান</a>
        </div>

        <div class="card-body">
            @include('components.alert')

            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>প্লান নাম</th>
                        <th>মাস</th>
                        <th>মাসিক জমা</th>
                        <th>সুদ (%)</th>
                        {{-- <th>একশন</th> --}}
                    </tr>
                </thead>

                @foreach ($plans as $plan)
                    <tr>
                        <td>{{ $plan->id }}</td>
                        <td>{{ $plan->name }}</td>
                        <td>{{ $plan->duration_months }}</td>
                        <td>{{ $plan->monthly_deposit }}</td>
                        <td>{{ $plan->interest_rate }}%</td>
                        {{-- <td>
                    <a href="{{ route('dps.plan.edit', $plan->id) }}" class="btn btn-info btn-sm">Edit</a>
                </td> --}}
                    </tr>
                @endforeach

            </table>
        </div>
    </div>
@endsection
