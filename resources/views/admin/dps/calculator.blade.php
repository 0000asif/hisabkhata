@extends('admin.masterAdmin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fa fa-calculator me-2"></i>DPS ক্যালকুলেটর</h4>
        </div>

        <div class="card-body">
            @include('components.alert')

            <form id="dpsForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="duration" class="form-label">মেয়াদ (মাস)</label>
                        <input type="number" id="duration" name="duration_months" class="form-control" placeholder="মাস" required>
                    </div>

                    <div class="col-md-4">
                        <label for="monthly" class="form-label">মাসিক জমা</label>
                        <input type="number" id="monthly" name="monthly_deposit" class="form-control" placeholder="টাকা" required>
                    </div>

                    <div class="col-md-4">
                        <label for="interest" class="form-label">সুদ (%)</label>
                        <input type="number" step="0.01" id="interest" name="interest_rate" class="form-control" placeholder="%" required>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button type="button" class="btn btn-success btn-lg" onclick="calculateDPS()">
                        <i class="fa fa-calculator me-1"></i> ক্যালকুলেট
                    </button>
                </div>
            </form>

            <!-- Loader -->
            <div class="text-center mt-4" id="loader" style="display:none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <!-- Result Card -->
            <div class="card mt-4 shadow-sm" id="resultCard" style="display:none;">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="fa fa-check-circle me-2"></i>ফলাফল</h5>
                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>টার্গেট টাকাঃ</strong> <span id="target">0</span> টাকা
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>প্রফিটঃ</strong> <span id="profit">0</span> টাকা
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>মোট টাকা প্রফিট সহঃ</strong> <span id="total">0</span> টাকা
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('script')
<script>
function calculateDPS() {
    // Show loader
    document.getElementById('loader').style.display = 'block';
    document.getElementById('resultCard').style.display = 'none';

    setTimeout(() => {
        let duration = parseFloat(document.getElementById('duration').value) || 0;
        let monthly = parseFloat(document.getElementById('monthly').value) || 0;
        let interest = parseFloat(document.getElementById('interest').value) || 0;

        let target = duration * monthly;
        let profit = (target * interest) / 100;
        let total = target + profit;

        document.getElementById('target').innerText = target.toLocaleString('bn-BD');
        document.getElementById('profit').innerText = profit.toLocaleString('bn-BD');
        document.getElementById('total').innerText = total.toLocaleString('bn-BD');

        // Hide loader and show result
        document.getElementById('loader').style.display = 'none';
        document.getElementById('resultCard').style.display = 'block';
    }, 500); // simulate processing delay
}
</script>
@endsection

