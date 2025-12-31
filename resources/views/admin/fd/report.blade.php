@extends('admin.masterAdmin')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>FD Report</h4>
    </div>

    <div class="card-body">

        <!-- Filter Form -->
        <form action="{{ route('fd.report') }}" method="GET">
            <div class="row">

                <div class="col-md-2">
                    <label>Member</label>
                    <select name="member_id" class="form-control select2_demo">
                        <option value="">All</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ request('member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->name }} (ID: {{ $member->id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Area</label>
                    <select name="area_id" class="form-control">
                        <option value="">All</option>
                        @foreach($areas as $area)
                            <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">All</option>
                        <option value="running" {{ request('status')=='running'?'selected':'' }}>Running</option>
                        <option value="withdrawn" {{ request('status')=='withdrawn'?'selected':'' }}>Withdrawn</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label>From</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <div class="col-md-2">
                    <label>To</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>

                <div class="col-md-2">
                    <label>&nbsp;</label>
                    <button class="btn btn-primary btn-block">Search</button>
                </div>

            </div>
        </form>

        @isset($fds)

        <hr>

        <!-- Summary Section -->
        <div class="row mb-3">
            <div class="col-md-3">
                <h5>Total Deposit: <b>{{ number_format($totalDeposit, 2) }}</b></h5>
            </div>
            <div class="col-md-3">
                <h5>Total Interest: <b>{{ number_format($totalInterest, 2) }}</b></h5>
            </div>
            <div class="col-md-3">
                <h5>Total Mature: <b>{{ number_format($totalMature, 2) }}</b></h5>
            </div>
            <div class="col-md-3">
                <h5>Running: <b>{{ $totalRunning }}</b> | Withdrawn: <b>{{ $totalWithdrawn }}</b></h5>
            </div>
        </div>

        <!-- Table -->
        <table class="table table-bordered" >
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Member</th>
                    <th>Area</th>
                    <th>Deposit Amount</th>
                    <th>Interest Rate</th>
                    <th>Duration</th>
                    <th>Mature Amount</th>
                    <th>Mature Date</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach($fds as $fd)
                <tr>
                    <td>{{ $fd->date }}</td>
                    <td>{{ $fd->member->name }}</td>
                    <td>{{ $fd->area->name }}</td>
                    <td>{{ number_format($fd->deposit_amount,2) }}</td>
                    <td>{{ $fd->interest_rate }}%</td>
                    <td>{{ $fd->duration_months }} Months</td>
                    <td>{{ number_format($fd->mature_amount,2) }}</td>
                    <td>{{ $fd->mature_date }}</td>
                    <td>
                        @if($fd->status == 'running')
                            <span class="badge bg-info">Running</span>
                        @else
                            <span class="badge bg-success">Withdrawn</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
        @endisset

    </div>
</div>

@endsection
