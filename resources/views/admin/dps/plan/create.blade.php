@extends('admin.masterAdmin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>নতুন DPS প্লান যোগ করুন</h4>
    </div>

    <div class="card-body">
      @include('components.alert')

        <form action="{{ route('dps.plan.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>প্লানের নাম</label>
                <input type="text" name="name" required class="form-control">
            </div>

            <div class="form-group">
                <label>মেয়াদ (মাস)</label>
                <input type="number" name="duration_months" required class="form-control">
            </div>

            <div class="form-group">
                <label>মাসিক জমা</label>
                <input type="number" name="monthly_deposit" required class="form-control">
            </div>

            <div class="form-group">
                <label>সুদ (%)</label>
                <input type="number" step="0.01" name="interest_rate" required class="form-control">
            </div>

            <button class="btn btn-primary mt-2">জমা দিন</button>
        </form>

    </div>
</div>

@endsection
