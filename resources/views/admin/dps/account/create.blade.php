@extends('admin.masterAdmin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>নতুন DPS খুলুন</h4>
    </div>

    <div class="card-body">

        <form action="{{ route('dps.account.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Member</label>
                <select name="member_id" class="form-control select2_demo" required>
                    <option value="">Select Member</option>
                    @foreach($members as $m)
                        <option value="{{ $m->id }}">{{ $m->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>DPS Plan</label>
                <select name="plan_id" id="plan_id" class="form-control" required>
                    <option value="">Select Plan</option>
                    @foreach($plans as $p)
                        <option value="{{ $p->id }}"
                                data-months="{{ $p->duration_months }}"
                                data-deposit="{{ $p->monthly_deposit }}"
                                data-rate="{{ $p->interest_rate }}">
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Starting Date</label>
                <input type="date" name="start_date" required class="form-control">
            </div>

            <div class="form-group">
                <label>Maturity Date</label>
                <input type="text" id="mature_date" readonly class="form-control bg-light">
            </div>

            <div class="form-group">
                <label>Mature Amount</label>
                <input type="text" id="mature_amount" readonly class="form-control bg-light">
            </div>

            <button class="btn btn-primary mt-3">DPS Create করুন</button>

        </form>

    </div>
</div>

@endsection

@section('script')
<script>
    $('#plan_id').change(function() {
        let months = $(this).find(':selected').data('months');
        let deposit = $(this).find(':selected').data('deposit');
        let rate = $(this).find(':selected').data('rate');

        let total = deposit * months;
        let interest = (total * rate / 100);
        let mature = total + interest;

        $('#mature_amount').val(mature);
    });
</script>
@endsection
