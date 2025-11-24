@extends('admin.masterAdmin')
@section('content')
    <div class="card">

        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="box-title">ফিক্সড ডিপোজিট তালিকা</h5>

            <div class="d-flex gap-2">

                <!-- Area Filter -->
                <form action="{{ route('fd.index') }}" id="filter_area" method="get" class="me-2">
                    <select name="area_id" class="form-control select2_demo" id="area_id" onchange="this.form.submit()">
                        <option value="">সব এরিয়া</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>
                                {{ $area->name }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <!-- Search -->
                <form action="{{ route('fd.index') }}" method="get">
                    <input type="text" name="search" class="form-control" placeholder="মেম্বারের নাম/ID"
                        value="{{ request('search') }}">
                </form>

                <!-- Add FD -->
                <a href="{{ route('fd.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> নতুন FDR
                </a>
            </div>
        </div>

        <!-- Body -->
        <div class="card-body">

            @include('components.alert')

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped w-100" id="dt-responsive">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Date</th>
                            <th>Member</th>
                            <th>Deposit</th>
                            <th>Rate</th>
                            <th>Mature Amount</th>
                            <th>Mature Date</th>
                            <th>Status</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($fds as $fd)
                            <tr class="text-center">

                                <td>{{ $fd->id }}</td>

                                <td>{{ date('d-m-Y', strtotime($fd->date)) }}</td>

                                <td>
                                    <strong>{{ $fd->member->name }}</strong><br>
                                    <small>ID: {{ $fd->member->id }}</small>
                                </td>

                                <td>{{ number_format($fd->deposit_amount, 2) }}</td>

                                <td>{{ $fd->interest_rate }}%</td>

                                <td>{{ number_format($fd->mature_amount, 2) }}</td>

                                <td>{{ date('d-m-Y', strtotime($fd->mature_date)) }}</td>

                                <td>
                                    @if ($fd->status == 'running')
                                        <span class="badge bg-warning">Running</span>
                                    @elseif ($fd->status == 'matured')
                                        <span class="badge bg-success">Matured</span>
                                    @else
                                        <span class="badge bg-secondary">Withdrawn</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('fd.show', $fd->id) }}" class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    @if ($fd->status != 'withdrawn')
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#withdrawModal{{ $fd->id }}">
                                            Withdraw
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- Withdraw Modal -->
                            <div class="modal fade" id="withdrawModal{{ $fd->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('fd.withdraw', $fd->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">FDR Withdraw</h5>
                                            </div>

                                            <div class="modal-body text-start">
                                                <p>Member: <strong>{{ $fd->member->name }}</strong></p>
                                                <p>Deposit: <strong>{{ number_format($fd->deposit_amount, 2) }}</strong>
                                                </p>
                                                <p>Mature Amount:
                                                    <strong>{{ number_format($fd->mature_amount, 2) }}</strong>
                                                </p>

                                                <label>Withdraw Type:</label>
                                                <select name="withdraw_type" class="form-control" required>
                                                    <option value="mature">Mature Withdraw</option>
                                                    <option value="early">Early Withdraw (Penalty)</option>
                                                </select>
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button class="btn btn-primary">Confirm Withdraw</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>

                </table>


            </div>

        </div>

    </div>
@endsection
