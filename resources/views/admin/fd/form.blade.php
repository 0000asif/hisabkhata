@extends('admin.masterAdmin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-fullheight">
                <div class="card-header">
                    <h5 class="box-title">নতুন ফিক্সড ডিপোজিট (FD) যোগ করুন</h5>
                </div>

                <div class="card-body">
                    @include('components.alert')

                    <form action="{{ route('fd.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            <!-- Date -->
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>তারিখ</label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>
                            </div>

                            <!-- Member -->
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>মেম্বার</label>
                                    <select name="member_id" class="form-control select2_demo" required>
                                        <option value="">মেম্বার নির্বাচন করুন</option>
                                        @foreach ($members as $member)
                                            <option value="{{ $member->id }}">{{ $member->name }} (ID:
                                                {{ $member->id }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Area -->
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>এরিয়া</label>
                                    <select name="area_id" class="form-control select2_demo" required>
                                        <option value="">এরিয়া নির্বাচন করুন</option>
                                        @foreach ($areas as $area)
                                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Deposit Amount -->
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>ডিপোজিট এমাউন্ট</label>
                                    <input type="number" name="deposit_amount" class="form-control" min="1"
                                        required>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Duration (Months)</label>
                                    <input type="number" id="duration" name="duration_months" class="form-control"
                                        min="1" required>
                                </div>
                            </div>

                            <!-- Interest Rate -->
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Interest Rate (%)</label>
                                    <input type="text" id="rate" name="interest_rate" class="form-control" readonly
                                        required>
                                </div>
                            </div>

                            <!-- Note -->
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>নোট</label>
                                    <textarea name="note" rows="3" class="form-control" placeholder="যদি কিছু লিখতে চান..."></textarea>
                                </div>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary mt-2">
                            <i class="fa fa-save"></i> সংরক্ষণ করুন
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#duration').on('keyup change', function() {
            let months = $(this).val();

            if (months > 0) {
                $.get("{{ url('/fd/get-rate') }}/" + months, function(rate) {
                    $('#rate').val(rate);
                });
            }
        });
    </script>
@endsection
