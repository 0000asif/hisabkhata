@extends('admin.masterAdmin')
@section('content')

<div class="page-heading">
    <h1 class="page-title">Dashboard Overview</h1>
</div>

<div class="row">

    <!-- LOAN SUMMARY -->
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5>Total Loan Disbursed</h5>
                <h3>{{ number_format($totalLoanDisbursed,2) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5>Total Loan Collection</h5>
                <h3>{{ number_format($totalLoanCollection,2) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5>Total Loan Pending</h5>
                <h3>{{ number_format($totalLoanPending,2) }}</h3>
            </div>
        </div>
    </div>

</div>

<hr>

<div class="row">

    <!-- SAVINGS SUMMARY -->
    <div class="col-md-6">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5>Total Savings Balance</h5>
                <h3>{{ number_format($totalSavingsBalance,2) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <h5>Total Savings Collection</h5>
                <h3>{{ number_format($totalSavingsCollection,2) }}</h3>
            </div>
        </div>
    </div>

</div>

<hr>

<div class="row">

    <!-- FDR SUMMARY -->
    <div class="col-md-4">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h5>Total FDR Amount</h5>
                <h3>{{ number_format($totalFdrAmount,2) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <h5>Total FDR Mature Paid</h5>
                <h3>{{ number_format($totalFdrMature,2) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5>Running FDR Accounts</h5>
                <h3>{{ $totalRunningFdr }}</h3>
            </div>
        </div>
    </div>

</div>

<hr>

<div class="row">

    <!-- DPS SUMMARY -->
    <div class="col-md-6">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5>Total DPS Accounts</h5>
                <h3>{{ $totalDpsAccounts }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5>Total DPS Mature Paid</h5>
                <h3>{{ number_format($totalDpsMature,2) }}</h3>
            </div>
        </div>
    </div>

</div>

<hr>

<div class="row">

    <!-- INCOME EXPENSE SUMMARY -->
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5>Total Income</h5>
                <h3>{{ number_format($totalIncome,2) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5>Total Expense</h5>
                <h3>{{ number_format($totalExpense,2) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5>Net Balance</h5>
                <h3>{{ number_format($netBalance,2) }}</h3>
            </div>
        </div>
    </div>

</div>

<hr>

<div class="row">

    <!-- MEMBERS & AREA SUMMARY -->
    <div class="col-md-6">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5>Total Members</h5>
                <h3>{{ $totalMembers }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <h5>Total Areas</h5>
                <h3>{{ $totalAreas }}</h3>
            </div>
        </div>
    </div>

</div>

@endsection

