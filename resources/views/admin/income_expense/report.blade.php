@extends('admin.masterAdmin')
@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Income & Expense Report</h4>

        <button onclick="window.print()" class="btn btn-dark btn-sm">
            <i class="fa fa-print"></i> Print
        </button>
    </div>

    <div class="card-body">

        {{-- FILTER FORM --}}
        <form method="GET" action="{{ route('income-expense.report') }}">
            <div class="row">

                {{-- Date From --}}
                <div class="col-md-3">
                    <label>Start Date</label>
                    <input type="date" name="start_date" value="{{ $start_date }}" class="form-control">
                </div>

                {{-- Date To --}}
                <div class="col-md-3">
                    <label>End Date</label>
                    <input type="date" name="end_date" value="{{ $end_date }}" class="form-control">
                </div>

                {{-- Type --}}
                <div class="col-md-3">
                    <label>Type</label>
                    <select name="type" class="form-control">
                        <option value="all">All</option>
                        <option value="income" {{ request('type')=='income' ? 'selected' : '' }}>Income</option>
                        <option value="expense" {{ request('type')=='expense' ? 'selected' : '' }}>Expense</option>
                    </select>
                </div>

                {{-- Category --}}
                <div class="col-md-3">
                    <label>Category</label>
                    <select name="category_id" class="form-control select2_demo">
                        <option value="">All Categories</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" {{ request('category_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="text-right mt-3">
                <button class="btn btn-primary">Filter</button>
            </div>

        </form>

        <hr>

        {{-- SUMMARY --}}
        <div class="row text-center mb-4">
            <div class="col-md-4">
                <div class="p-3 bg-success text-white rounded">
                    <h5>Total Income</h5>
                    <h3>{{ number_format($total_income, 2) }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 bg-danger text-white rounded">
                    <h5>Total Expense</h5>
                    <h3>{{ number_format($total_expense, 2) }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 bg-info text-white rounded">
                    <h5>Balance</h5>
                    <h3>{{ number_format($balance, 2) }}</h3>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-bordered" id="dt-responsive">
                <thead class="thead-light">
                    <tr>
                        <th>SL</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Note</th>
                        <th>User</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($records as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->date)->format('d-m-Y') }}</td>
                        <td>{{ $data->category->name }}</td>
                        <td>
                            <span class="badge badge-{{ $data->type == 'income' ? 'success' : 'danger' }}">
                                {{ ucfirst($data->type) }}
                            </span>
                        </td>
                        <td>{{ number_format($data->amount, 2) }}</td>
                        <td>{{ $data->note ?? '—' }}</td>
                        <td>{{ $data->user->name ?? '' }}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>


<style>
@media print {
    .card-header, form, .btn, nav, footer {
        display: none !important;
    }
    table {
        width: 100%;
        border-collapse: collapse !important;
    }
}
</style>

@endsection
