@extends('admin.masterAdmin')

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="card">
            <div class="card-header">
                <h5>FDR Profit Calculator</h5>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">
                        <label>FDR Amount</label>
                        <input type="number" id="amount" class="form-control" placeholder="0.00">
                    </div>

                    <div class="col-md-4">
                        <label>Interest % (Monthly)</label>
                        <input type="number" id="rate" class="form-control" placeholder="0.00">
                    </div>

                    <div class="col-md-4">
                        <label>Duration (Months)</label>
                        <input type="number" id="months" class="form-control" placeholder="0">
                    </div>

                </div>

                <hr>

                <div class="row mt-3">

                    <div class="col-md-4">
                        <label>Monthly Profit</label>
                        <input type="text" id="monthly_profit" class="form-control" readonly>
                    </div>

                    <div class="col-md-4">
                        <label>Total Profit</label>
                        <input type="text" id="total_profit" class="form-control" readonly>
                    </div>

                    <div class="col-md-4">
                        <label>Total Amount (FDR + Profit)</label>
                        <input type="text" id="total_amount" class="form-control" readonly>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

@endsection


@section('script')

<script>
    function calculateFDR() {

        let amount = $('#amount').val();
        let rate = $('#rate').val();
        let months = $('#months').val();

        if (amount == "" || rate == "" || months == "") return;

        $.ajax({
            url: "{{ route('fdr.calculate') }}",
            type: "POST",
            data: {
                amount: amount,
                rate: rate,
                months: months,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                $('#monthly_profit').val(res.monthly_profit);
                $('#total_profit').val(res.total_profit);
                $('#total_amount').val(res.total_amount);
            }
        });
    }

    $('#amount, #rate, #months').on('keyup change', function() {
        calculateFDR();
    });
</script>

@endsection
