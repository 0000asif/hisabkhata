@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page heading-->
    <div class="page-heading">
        <div class="page-breadcrumb">
            <h1 class="page-title">Dashboard</h1><br>
            @can('view category')
                <br>
                <h1 class="page-title">Category</h1>
            @endcan

        </div>
        <div class="subheader_daterange" id="subheader_daterange"><span class="subheader-daterange-label"><span
                    class="subheader-daterange-title"></span><span class="subheader-daterange-date"></span></span><button
                class="btn btn-floating btn-sm rounded-0" type="button"><i class="ti-calendar"></i></button></div>
    </div>
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h4>Total Loan Disbursed</h4>
                        <h3>{{ number_format($totalLoan, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h4>Total Collection Received</h4>
                        <h3>{{ number_format($totalCollection, 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h4>Total Pending</h4>
                        <h3>{{ number_format($totalPending, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>


    </div><!-- END: Page content-->
@endsection
