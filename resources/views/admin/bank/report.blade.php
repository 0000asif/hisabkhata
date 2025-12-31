@extends('admin.masterAdmin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>ব্যাংক রিপোর্ট</h4>
    </div>

    <div class="card-body">

        <form method="GET" class="mb-3">
            <div class="row">

                <div class="col-md-4">
                    <label>ব্যাংক নির্বাচন *</label>
                    <select name="bank_account_id" class="form-control" required>
                        <option value="">Select</option>
                        @foreach($accounts as $a)
                            <option value="{{ $a->id }}" {{ $bank_account_id==$a->id?'selected':'' }}>
                                {{ $a->bank_name }} - {{ $a->account_number }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $start_date }}">
                </div>

                <div class="col-md-3">
                    <label>End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $end_date }}">
                </div>

                <div class="col-md-2">
                    <label>&nbsp;</label><br>
                    <button class="btn btn-primary btn-block">সার্চ</button>
                </div>

            </div>
        </form>

        @if(isset($bank_account_id))

        <h5>পূর্বের ব্যালেন্সঃ {{ number_format($previous_balance,2) }}</h5>

        <table class="table table-bordered mt-3" id="dt-responsive">
            <thead class="thead-light">
                <tr>
                    <th>তারিখ</th>
                    <th>লেনদেন</th>
                    <th>ব্যাংক</th>
                    <th>একাউন্ট</th>
                    <th>নম্বর</th>
                    <th>বর্ণনা</th>
                    <th>জমা</th>
                    <th>উত্তোলন</th>
                    <th>ব্যালেন্স</th>
                </tr>
            </thead>

            <tbody>

                @php $running = $previous_balance; @endphp

                @foreach($transactions as $trx)
                    @php
                        if ($trx->type == 'deposit') $running += $trx->amount;
                        else $running -= $trx->amount;
                    @endphp
                    <tr>
                        <td>{{ date('d-m-Y', strtotime($trx->date)) }}</td>
                        <td>{{ $trx->type == 'deposit' ? 'জমা' : 'উত্তোলন' }}</td>
                        <td>{{ $trx->account->bank_name }}</td>
                        <td>{{ $trx->account->account_name }}</td>
                        <td>{{ $trx->account->account_number }}</td>
                        <td>{{ $trx->description }}</td>
                        <td>{{ $trx->type == 'deposit' ? number_format($trx->amount,2) : '0.00' }}</td>
                        <td>{{ $trx->type == 'withdraw' ? number_format($trx->amount,2) : '0.00' }}</td>
                        <td>{{ number_format($running,2) }}</td>
                    </tr>
                @endforeach

            </tbody>

            <tfoot>
                <tr class="font-weight-bold">
                    <td colspan="6">সর্বমোট</td>
                    <td>{{ number_format($total_deposit,2) }}</td>
                    <td>{{ number_format($total_withdraw,2) }}</td>
                    <td>{{ number_format($ending_balance,2) }}</td>
                </tr>
            </tfoot>

        </table>

        @endif

    </div>
</div>

@endsection
