@extends('admin.masterAdmin')

@section('content')
<div class="report-card">

    <h3>👤 Member Wise Collection Report</h3>

    {{-- Filter Box --}}
    <form method="GET" class="filter-box mb-3">
        <div class="row">
            <div class="col-md-4">
                <label>Select Member</label>
                <select name="member_id" class="form-control" onchange="this.form.submit()">
                    <option value="">Select...</option>
                    @foreach($members as $m)
                        <option value="{{ $m->id }}" {{ request('member_id') == $m->id ? 'selected' : '' }}>
                            {{ $m->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    @if($member)
        <h4 class="mt-3">{{ $member->name }} – Report</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-hover mt-3">
                <thead class="thead-dark">
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Loan Amount</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $t)
                        <tr>
                            {{-- Date --}}
                            <td>{{ $t->date }}</td>

                            {{-- Transaction Type --}}
                            <td>
                                @if($t->join_fee)
                                    Join Fee
                                @elseif($t->service_charge)
                                    Service Charge
                                @elseif($t->late_service_charge)
                                    Late Service Charge
                                @elseif($t->loan_amount)
                                    Loan Payment
                                @elseif($t->single_loan_amount)
                                    Single Loan Payment
                                @else
                                    Other
                                @endif
                            </td>

                            {{-- Amount --}}
                            <td class="text-success">
                                @if($t->join_fee)
                                    {{ number_format($t->join_fee, 2) }}
                                @elseif($t->service_charge)
                                    {{ number_format($t->service_charge, 2) }}
                                @elseif($t->late_service_charge)
                                    {{ number_format($t->late_service_charge, 2) }}
                                @elseif($t->loan_amount)
                                    {{ number_format($t->loan_amount, 2) }}
                                @elseif($t->single_loan_amount)
                                    {{ number_format($t->single_loan_amount, 2) }}
                                @else
                                    -
                                @endif
                            </td>

                            {{-- Loan Amount (if exists) --}}
                            <td>{{ optional($t->loan)->loan_amount ? number_format($t->loan->loan_amount, 2) : '-' }}</td>

                            {{-- Note --}}
                            <td>{{ $t->note ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">Total</th>
                        <th class="text-success">
                            {{ number_format($transactions->sum(function($t){
                                return $t->loan_amount ?? $t->single_loan_amount ?? $t->join_fee ?? $t->service_charge ?? $t->late_service_charge ?? 0;
                            }), 2) }}
                        </th>
                        <th>-</th>
                        <th>-</th>
                    </tr>
                </tfoot>

            </table>
        </div>
    @endif
</div>
@endsection
