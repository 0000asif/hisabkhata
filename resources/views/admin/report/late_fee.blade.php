@extends('admin.masterAdmin')

@section('content')

<div class="card">
    <div class="card-header bg-dark text-white">
        <h4>Late Fee Report</h4>
    </div>

    <div class="card-body">

        <!-- Filters -->
        <form class="row mb-4">

            <div class="col-md-3">
                <label>Date</label>
                <input type="date" name="date" class="form-control"
                       value="{{ request('date') }}">
            </div>

            <div class="col-md-3">
                <label>Area</label>
                <select name="area_id" class="form-control">
                    <option value="">All</option>
                    @foreach ($areas as $a)
                        <option value="{{ $a->id }}" {{ request('area_id') == $a->id ? 'selected' : '' }}>
                            {{ $a->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>Member</label>
                <select name="member_id" class="form-control">
                    <option value="">All</option>
                    @foreach ($members as $m)
                        <option value="{{ $m->id }}" {{ request('member_id') == $m->id ? 'selected' : '' }}>
                            {{ $m->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>&nbsp;</label>
                <button class="btn btn-primary w-100">Filter</button>
            </div>

        </form>

        <!-- Summary -->
        <div class="alert alert-info d-flex justify-content-between fw-bold">
            <span>Total Late Fee: {{ number_format($totalLateFee, 2) }}</span>
            <span>Late Fee Collected: {{ number_format($totalLateFeePaid, 2) }}</span>
            <span>Late Fee Due: {{ number_format($totalLateFeeDue, 2) }}</span>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">

                <thead class="bg-secondary text-white">
                    <tr>
                        <th>#</th>
                        <th>Member</th>
                        <th>Area</th>
                        <th>Due Date</th>
                        <th>Late Days</th>
                        <th>Late Fee</th>
                        <th>Paid</th>
                        <th>Remaining</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($installments as $i)
                        @php
                            $late_due = $i->late_fee - $i->late_fee_paid;
                            $lateDays = now()->gt($i->due_date) 
                                        ? $i->due_date->diffInDays(now()) 
                                        : 0;
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td><b>{{ $i->member->name }}</b></td>
                            <td>{{ $i->member->area->name }}</td>

                            <td>{{ $i->due_date->format('d M, Y') }}</td>

                            <td class="fw-bold {{ $lateDays > 0 ? 'text-danger' : '' }}">
                                {{ $lateDays }}
                            </td>

                            <td>{{ number_format($i->late_fee, 2) }}</td>
                            <td class="text-success">{{ number_format($i->late_fee_paid, 2) }}</td>
                            <td class="text-danger fw-bold">{{ number_format($late_due, 2) }}</td>

                            <td>
                                @if ($late_due <= 0)
                                    <span class="badge bg-success">Cleared</span>
                                @else
                                    <span class="badge bg-danger">Due</span>
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
