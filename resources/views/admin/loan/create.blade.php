@extends('admin.masterAdmin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>New Loan Create</h4>
        </div>

        <div class="card-body">

            @include('components.alert')

            <form action="{{ route('loan.store') }}" method="POST">
                @csrf

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Date <span class="text-danger">*</span></label>
                        <input type="text" name="date" value="{{ date('d-m-Y') }}" class="form-control datetimepicker_5"
                            required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Area <span class="text-danger">*</span></label>
                        <select name="area_id" class="form-control" required>
                            <option value="">Select Area</option>
                            @foreach ($areas as $a)
                                <option value="{{ $a->id }}">{{ $a->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>User / Staff <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-control" required>
                            <option value="">Select User</option>
                            @foreach ($staffs as $u)
                                <option value="{{ $u->user_id }}">{{ $u->name }} - {{ $u->position->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Member <span class="text-danger">*</span></label>
                        <select name="member_id" class="form-control" required>
                            <option value="">Select Member</option>
                            @foreach ($members as $m)
                                <option value="{{ $m->id }}">{{ $m->name }} - {{ $m->phone }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Loan Amount <span class="text-danger">*</span></label>
                        <input type="number" name="loan_amount" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Interest Type</label>
                        <select name="interest_type" class="form-control">
                            <option value="percent">Percent</option>
                            <option value="flat">Flat</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Interest Value</label>
                        <input type="number" step="any" name="interest" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Installment Type</label>
                        <select name="installment_type" class="form-control" required>
                            <option value="">Select</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="fortnightly">Fortnightly</option>
                            <option value="monthly">Monthly</option>
                            <option value="6month">6 Month</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>No. of Installments <span class="text-danger">*</span></label>
                        <input type="number" name="loan_count" class="form-control" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Note</label>
                        <textarea name="note" class="form-control"></textarea>
                    </div>

                </div>

                <button class="btn btn-primary mt-3">Save Loan</button>
            </form>

        </div>
    </div>
@endsection
