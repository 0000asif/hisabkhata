@extends('admin.masterAdmin')

@section('content')

<div class="card">
    <div class="card-header">
        <h4>DPS Report</h4>
    </div>

    <div class="card-body">

        <!-- Filters -->
        <form action="{{ route('dps.report') }}" method="GET">
            <div class="row">

                <div class="col-md-3">
                    <label>Member</label>
                    <select name="member_id" class="form-control select2_demo">
                        <option value="">All</option>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}" {{ request('member_id')==$m->id?'selected':'' }}>
                                {{ $m->name }} (ID: {{ $m->id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Plan</label>
                    <select name="plan_id" class="form-control">
                        <option value="">All</option>
                        @foreach($plans as $p)
                            <option value="{{ $p->id }}" {{ request('plan_id')==$p->id?'selected':'' }}>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">All</option>
                        <option value="running" {{ request('status')=='running'?'selected':'' }}>Running</option>
                        <option value="closed" {{ request('status')=='closed'?'selected':'' }}>Closed</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label>From</label>
                    <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                </div>

                <div class="col-md-2">
                    <label>To</label>
                    <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                </div>

                <div class="col-md-2">
                    <label>&nbsp;</label>
                    <button class="btn btn-primary btn-block">Search</button>
                </div>

            </div>
        </form>

        @isset($dps)

        <hr>

        <!-- Summary Section -->
        <div class="row mb-3">
            <div class="col-md-3">
                <h6>Total Deposit: <b>{{ number_format($totalDeposit,2) }}</b></h6>
            </div>

            <div class="col-md-3">
                <h6>Total Mature Amount: <b>{{ number_format($totalMatureAmount,2) }}</b></h6>
            </div>

            <div class="col-md-3">
                <h6>Total Paid Installments: <b>{{ number_format($totalPaid,2) }}</b></h6>
            </div>

            <div class="col-md-3">
                <h6>Total Due Installments: <b>{{ number_format($totalDue,2) }}</b></h6>
            </div>
        </div>

        <!-- Data Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Start Date</th>
                    <th>Member</th>
                    <th>Plan</th>
                    <th>Monthly Deposit</th>
                    <th>Duration</th>
                    <th>Total Deposit</th>
                    <th>Mature Amount</th>
                    <th>Mature Date</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach($dps as $row)
                <tr>
                    <td>{{ $row->start_date }}</td>
                    <td>{{ $row->member->name }}</td>
                    <td>{{ $row->plan->name }}</td>
                    <td>{{ $row->monthly_deposit }}</td>
                    <td>{{ $row->duration_months }} Months</td>
                    <td>{{ number_format($row->total_deposit,2) }}</td>
                    <td>{{ number_format($row->mature_amount,2) }}</td>
                    <td>{{ $row->mature_date }}</td>

                    <td>
                        {{ number_format($row->installments->where('status','paid')->sum('paid_amount'), 2) }}
                    </td>
                    <td>
                        {{ number_format($row->installments->where('status','pending')->sum('amount'), 2) }}
                    </td>

                    <td>
                        @if($row->status == 'running')
                            <span class="badge bg-info">Running</span>
                        @else
                            <span class="badge bg-success">Closed</span>
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
