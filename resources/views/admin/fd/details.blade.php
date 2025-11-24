@extends('admin.masterAdmin')
@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2">

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">FD Details</h4>
                </div>

                <div class="card-body">

                    <table class="table table-bordered">
                        <tr>
                            <th width="35%">Member Name</th>
                            <td>{{ $fd->member->name }}</td>
                        </tr>

                        <tr>
                            <th>FD Start Date</th>
                            <td>{{ $fd->date }}</td>
                        </tr>

                        <tr>
                            <th>Deposit Amount</th>
                            <td>{{ number_format($fd->deposit_amount) }} ৳</td>
                        </tr>

                        <tr>
                            <th>Interest Rate</th>
                            <td>{{ $fd->interest_rate }}%</td>
                        </tr>

                        <tr>
                            <th>Duration</th>
                            <td>{{ $fd->duration_months }} Months</td>
                        </tr>

                        <tr>
                            <th>Maturity Amount</th>
                            <td><strong>{{ number_format($fd->mature_amount) }} ৳</strong></td>
                        </tr>

                        <tr>
                            <th>Maturity Date</th>
                            <td>{{ $fd->mature_date }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                @if ($fd->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif ($fd->status == 'matured')
                                    <span class="badge bg-info">Matured</span>
                                @else
                                    <span class="badge bg-danger">Withdrawn</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <hr>

                    {{-- FD Withdraw Section --}}
                    @include('admin.fd.withdraw')

                </div>
            </div>

        </div>
    </div>
@endsection
